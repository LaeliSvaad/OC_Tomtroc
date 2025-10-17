<?php
namespace App\Manager;

use App\Model\User;
use App\Model\Chat;
use App\Model\Conversation;
use App\Model\Message;

class ChatManager extends AbstractEntityManager
{
    public function getChat(int $connectedUserId): ?Chat
    {
        $sql = "SELECT
                conversation.id AS conversationId,
                message.id,
                message.text,
                message.seen_by_recipient,
                message.date,
                sender.id AS senderId,
                sender.nickname AS senderNickname,
                sender.picture AS senderPicture,
                interlocutor.id AS interlocutorId,
                interlocutor.nickname AS interlocutorNickname,
                interlocutor.picture AS interlocutorPicture
            FROM conversation
            JOIN (
                SELECT conversation_id, MAX(date) AS latest_sent
                FROM message
                GROUP BY conversation_id
            ) lastmessages 
                ON conversation.id = lastmessages.conversation_id
            JOIN message  
                ON message.conversation_id = lastmessages.conversation_id
               AND message.date = lastmessages.latest_sent
            JOIN user AS sender 
                ON sender.id = message.sender_id
            JOIN user AS interlocutor 
                ON interlocutor.id = CASE 
                    WHEN conversation.user_1_id = :userId THEN conversation.user_2_id
                    ELSE conversation.user_1_id
                END
            WHERE conversation.user_1_id = :userId OR conversation.user_2_id = :userId
            ORDER BY message.date DESC;" ;

        $result = $this->db->query($sql, ['userId' => $connectedUserId]);
        if(is_null($result))
            return null;
        else
        {
            $chat = new Chat();
            foreach ($result as $element) {
                $sender = new User();
                $sender->setUserId($element["senderId"]);
                $sender->setNickname($element["senderNickname"]);
                $sender->setPicture($element["senderPicture"]);
                $interlocutor = new User();
                $interlocutor->setUserId($element["interlocutorId"]);
                $interlocutor->setNickname($element["interlocutorNickname"]);
                $interlocutor->setPicture($element["interlocutorPicture"]);
                $message = new Message();
                $message->setConversationId($element["conversationId"]);
                $message->setText($element["text"]);
                $message->setId($element["id"]);
                $message->setDatetime(new \DateTime($element["date"]));
                $message->setSeenByRecipient($element["seen_by_recipient"]);
                $message->setSender($sender);
                if($sender->getUserId() === $connectedUserId)
                    $message->setConnectedUserMessage(true);
                $conversation = new Conversation();
                $conversation->setInterlocutor($interlocutor);
                $conversation->addMessage($message);
                $conversation->setConversationId($element['conversationId']);
                $chat->addConversation($conversation);
            }
            return $chat;
        }
    }

    public function getUnreadMessagesIds(int $connectedUserId, Chat $chat): void
    {
        $sql = "SELECT message.id
                FROM message
                WHERE seen_by_recipient = FALSE AND sender_id <> :connectedUserId";
        $result = $this->db->query($sql, ['connectedUserId' => $connectedUserId]);
        foreach ($result as $element) {
            $chat->addUnreadMessageId($element["id"]);
        }
    }
}