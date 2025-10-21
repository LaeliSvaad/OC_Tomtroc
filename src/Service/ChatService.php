<?php
namespace App\Service;

use App\Manager\ChatManager;
use App\Manager\ConversationManager;
use App\Manager\UserManager;
use App\Http\Request;
use App\Model\Conversation;
use App\Manager\MessageManager;

class ChatService
{
    private ChatManager $chatManager;
    private ConversationManager $conversationManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->chatManager = new ChatManager();
        $this->conversationManager = new ConversationManager();
        $this->userManager = new UserManager();
    }

    public function prepareChatData(int $connectedUserId, ?string $type, ?int $id, Request $request): array
    {
        $connectedUser = $this->userManager->getPublicUserById($connectedUserId);
        $chat = $this->chatManager->getChat($connectedUserId);
        $chat->setConnectedUser($connectedUser);

        if ($type === null) {
            return $this->getDefaultConversationData($chat, $connectedUserId);
        }

        if ($type === "conversation") {
            return $this->getConversationData($chat, $connectedUserId, $id);
        }

        if ($type === "interlocuteur") {
            return $this->getInterlocutorConversationData($chat, $connectedUserId, $id);
        }

        return ['chat' => $chat, 'conversation' => null];
    }

    private function getDefaultConversationData($chat, int $connectedUserId): array
    {
        $this->chatManager->getUnreadMessagesIds($connectedUserId, $chat);
        $firstConv = $chat->getChat()[0] ?? null;
        if ($firstConv) {
            $conversation = $this->conversationManager->getConversationById($firstConv->getConversationId(), $connectedUserId);
            $conversation->setInterlocutor(
                $this->conversationManager->getInterlocutor($connectedUserId, $firstConv->getConversationId())
            );
            return ['chat' => $chat, 'conversation' => $conversation];
        }
        return ['chat' => $chat, 'conversation' => null];
    }

    private function getConversationData($chat, int $connectedUserId, int $conversationId): array
    {
        $conversation = $this->conversationManager->getConversationById($conversationId, $connectedUserId);
        $conversation->setInterlocutor(
            $this->conversationManager->getInterlocutor($connectedUserId, $conversationId)
        );
        return ['chat' => $chat, 'conversation' => $conversation];
    }

    private function getInterlocutorConversationData($chat, int $connectedUserId, int $interlocutorId): array
    {
        $interlocutor = $this->userManager->getPublicUserById($interlocutorId);
        $conversation = $this->conversationManager->getConversationByUsersIds($connectedUserId, $interlocutorId);
        if (!$conversation) {
            $this->conversationManager->addConversation($connectedUserId, $interlocutorId);
            $conversation = new Conversation();
            $conversation->setConversationId($this->conversationManager->getLastConversationId());
        }
        $conversation->setInterlocutor($interlocutor);
        return ['chat' => $chat, 'conversation' => $conversation];
    }
}