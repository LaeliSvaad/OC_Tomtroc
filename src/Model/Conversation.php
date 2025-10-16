<?php
/**
 * Entité Conversation
 */
namespace App\Model;
class Conversation extends AbstractEntity
{
   private ?User $interlocutor = null;
   private ?array $conversation = [];
   private ?int $conversationId;

    public function getInterlocutor(): ?User
    {
        return $this->interlocutor;
    }

    public function setInterlocutor(?User $interlocutor): void
    {
        $this->interlocutor = $interlocutor;
    }

    public function getConversation(): ?array
    {
        return $this->conversation;
    }

    public function getConversationId(): ?int
    {
        return $this->conversationId;
    }

    public function setConversationId(?int $conversationId): void
    {
        $this->conversationId = $conversationId;
    }


    public function addMessage(Message $message): void
    {
        $this->conversation[] = $message;
    }
}