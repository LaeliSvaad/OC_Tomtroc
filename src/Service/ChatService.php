<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Manager\UserManager;
    use App\Manager\ChatManager;
    use App\Manager\ConversationManager;
    use App\Model\Conversation;
    use App\Model\Chat;
    use Exception;

    final class ChatService
    {
        public function __construct(
        private readonly UserManager $userManager,
        private readonly ChatManager $chatManager,
        private readonly ConversationManager $conversationManager
        ) {}

        public function getConversationData(int $connectedUserId, int $interlocutorId, ?int $conversationId): array
        {
        $connectedUser = $this->userManager->getPublicUserById($connectedUserId);
        $interlocutor = $this->userManager->getPublicUserById($interlocutorId);
        $chat = $this->initializeChat($connectedUserId, $connectedUser);

        if (empty($chat->getChat()) && $interlocutorId === -1) {
        return ['chat' => $chat, 'conversation' => null];
        }

        if (empty($chat->getChat()) && $interlocutorId !== -1) {
        $conversation = $this->createConversation($connectedUserId, $interlocutorId, $interlocutor);
        return ['chat' => $chat, 'conversation' => $conversation];
        }

        $conversation = $this->resolveConversation(
        $chat,
        $connectedUserId,
        $interlocutor,
        $interlocutorId,
        $conversationId
        );

        return ['chat' => $chat, 'conversation' => $conversation];
        }

        private function initializeChat(int $userId, $connectedUser): Chat
        {
        $chat = $this->chatManager->getChat($userId);
        $chat->setConnectedUser($connectedUser);
        $this->chatManager->getUnreadMessagesIds($userId, $chat);
        return $chat;
        }

        private function createConversation(int $userId, int $interlocutorId, $interlocutor): Conversation
        {
        $conversation = new Conversation();
        $conversation->setInterlocutor($interlocutor);

        if ($this->conversationManager->addConversation($userId, $interlocutorId)) {
        $conversation->setConversationId($this->conversationManager->getLastConversationId());
        return $conversation;
        }

        throw new Exception("Erreur lors de l'initialisation de la conversation.");
        }

        private function resolveConversation(
        Chat $chat,
        int $connectedUserId,
        ?object $interlocutor,
        int $interlocutorId,
        ?int $conversationId
        ): Conversation {
        if ($interlocutor !== null) {
        $conversation = $this->conversationManager->getConversationByUsersId($connectedUserId, $interlocutorId);

        if ($conversation === null) {
        return $this->createConversation($connectedUserId, $interlocutorId, $interlocutor);
        }

        $conversation->setInterlocutor($interlocutor);
        return $conversation;
        }

        if ($conversationId === null && !empty($chat->getChat())) {
        $conversationId = $chat->getChat()[0]->getConversationId();
        }

        $conversation = $this->conversationManager->getConversationById($conversationId, $connectedUserId);
        $interlocutor = $this->conversationManager->getInterlocutor($connectedUserId, $conversationId);
        $conversation->setInterlocutor($interlocutor);

        return $conversation;
        }
    }