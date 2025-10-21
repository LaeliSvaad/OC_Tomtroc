<?php
namespace App\Service;

use App\Http\Request;
use App\Manager\MessageManager;
use App\Manager\ChatManager;
use App\Manager\ConversationManager;
use App\Manager\UserManager;
use App\Model\Message;
use Exception;

class MessageService
{
    private MessageManager $messageManager;
    private ChatManager $chatManager;
    private ConversationManager $conversationManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->chatManager = new ChatManager();
        $this->conversationManager = new ConversationManager();
        $this->userManager = new UserManager();
    }

    /**
     * Envoie un message et met à jour les messages vus
     *
     * @param int $connectedUserId
     * @param Request $request
     * @return array Tableau contenant le chat et la conversation à rendre
     * @throws Exception
     */
    public function handleMessagePost(int $connectedUserId, Request $request): array
    {
        $conversationId = $request->post('conversationId');
        $text = $request->post('message');
        $seenByRecipientMessagesIds = $request->post('seenByRecipientMessagesIds');

        if (empty($conversationId) || empty($text)) {
            return [];
        }

        $connectedUser = $this->userManager->getPublicUserById($connectedUserId);

        if (!empty($seenByRecipientMessagesIds)) {
            $seenByRecipientMessagesIds = json_decode($seenByRecipientMessagesIds, true);
        }

        $message = new Message();
        $message->setConversationId((int)$conversationId);
        $message->setText($text);
        $message->setSender($connectedUser);
        $message->setSeenByRecipient(false);

        if ($this->messageManager->sendMessage($message) === 0) {
            throw new \Exception("Une erreur est survenue lors de l'envoi du message.");
        }


        if (!empty($seenByRecipientMessagesIds)) {
            $this->updateSeenMessages($seenByRecipientMessagesIds);
        }

        $chat = $this->chatManager->getChat($connectedUserId);
        $chat->setConnectedUser($connectedUser);
        $this->chatManager->getUnreadMessagesIds($connectedUserId, $chat);

        $conversation = $this->conversationManager->getConversationById($conversationId, $connectedUserId);
        $interlocutor = $this->conversationManager->getInterlocutor($connectedUserId, $conversationId);
        $conversation->setInterlocutor($interlocutor);

        return [
            'chat' => $chat,
            'conversation' => $conversation
        ];
    }

    /**
     * Met à jour le statut "vu" des messages passés
     *
     * @param array $seenByRecipientMessagesIds
     * @return void
     */
    private function updateSeenMessages(array $seenByRecipientMessagesIds): void
    {
        $placeholders = [];
        $params = [];
        foreach ($seenByRecipientMessagesIds as $index => $id) {
            $placeholder = ":id{$index}";
            $placeholders[] = $placeholder;
            $params[$placeholder] = (int)$id;
        }

        if (!empty($params)) {
            $this->messageManager->updateMessageStatus($params, $placeholders);
        }
    }
}