<?php
namespace App\Model;
class Chat extends AbstractEntity
{
    private ?array $chat = [];
    private ?User $connectedUser = null;
    private array $unreadMessagesIds = [];

    public function setConnectedUser(?User $connectedUser): void
    {
       $this->connectedUser= $connectedUser;
    }
    public function getConnectedUser(): ?User
    {
        return $this->connectedUser;
    }
    public function addUnreadMessageId(int $unreadMessageId): void
    {
        $this->unreadMessagesIds[] = $unreadMessageId;
    }
    public function getUnreadMessagesIds(): array
    {
        return $this->unreadMessagesIds;
    }
    public function addConversation(?Conversation $conversation): void
    {
        $this->chat[] = $conversation;
    }

    public function getChat(): ?array
    {
        return $this->chat;
    }
}