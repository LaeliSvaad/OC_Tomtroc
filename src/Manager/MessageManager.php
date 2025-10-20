<?php
/**
 * Classe qui gère un message
 */
namespace App\Manager;

use App\Model\Message;

class MessageManager extends AbstractEntityManager
{
    public function sendMessage(Message $message) : bool
    {
        $sql = "INSERT INTO `message` (`text`, `sender_id`, `seen_by_recipient`, `conversation_id`, `date`) VALUES (:text, :senderId, :seenByRecipient, :conversationId, NOW())";

        $result = $this->db->query($sql, [
            'text' => $message->getText(),
            'senderId' => $message->getSender()->getUserId(),
            'seenByRecipient' => (int)$message->getSeenByRecipient(),
            'conversationId' => $message->getConversationId()
        ]);

        return $result->rowCount() > 0;
    }

    public function updateMessageStatus(array $params, array $placeholders) : bool
    {
        $sql = "UPDATE `message`
            SET `seen_by_recipient` = TRUE
            WHERE `id` IN (" . implode(',', $placeholders) . ")";

        $result = $this->db->query($sql, $params);
        return $result->rowCount() > 0;
    }
}