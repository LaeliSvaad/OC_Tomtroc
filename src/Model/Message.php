<?php
/**
 * Entité Message
 */
namespace App\Model;
class Message extends AbstractEntity
{

    private ?Datetime $datetime;
    private string $text;
    private bool $seenByRecipient;
    private bool $connectedUserMessage = false;
    private User $sender;
    private int $conversationId;

    protected int $id;

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

   public function setSender(User $user) : void
    {
        $this->sender = $user;
    }

    public function getSender() : User
    {
        return $this->sender;
    }

    public function setConnectedUserMessage(bool $connectedUserMessage) : void
    {
        $this->connectedUserMessage = $connectedUserMessage;
    }

    public function isConnectedUserMessage() : bool
    {
        return $this->connectedUserMessage;
    }

    public function setConversationId(int $conversationId) : void
    {
        $this->conversationId = $conversationId;
    }

    public function getConversationId() : int
    {
        return $this->conversationId;
    }

    public function setDatetime(?Datetime $datetime) : void
    {
        $this->datetime = $datetime;
    }

    public function getDatetime() : ?Datetime
    {
        return $this->datetime;
    }

    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function setSeenByRecipient(bool $seenByRecipient) : void
    {
        $this->seenByRecipient = $seenByRecipient;
    }

    public function getSeenByRecipient() : bool
    {
        return $this->seenByRecipient;
    }

}