<?php
namespace App\Controller;

use App\Manager\UserManager;
use App\Manager\MessageManager;
use App\Manager\ConversationManager;
use App\Manager\ChatManager;
use App\Utils\Utils;

class ChatController extends AbstractController
{
    public function showChat() : void
    {
        $connectedUserId = $_SESSION["user"];
        $interlocutorId = Utils::request("interlocutorId", -1);
        $conversationId = Utils::request("conversationId", NULL);

        /*On récupère d'abord les données des 2 utilisateurs: l'interlocuteur de la conversation affichée et l'utilisateur connecté */
        $userManager = new UserManager();
        $interlocutor = $userManager->getPublicUserById($interlocutorId);
        $connectedUser = $userManager->getPublicUserById($connectedUserId);

        /* On récupère la liste de conversation avec le dernier message de chaque conversation pour l'utilisateur connecté */
        $chatManager = new ChatManager();
        $chat = $chatManager->getChat($connectedUserId);
        $chat->setConnectedUser($connectedUser);

        /* On récupère le tableau d'ids des messages non-lus par l'utilisateur connecté */
        $chatManager->getUnreadMessagesIds($connectedUserId, $chat);


        if(empty($chat->getChat()) && $interlocutorId === -1){
            /* Si la liste de conversations est vide et qu'il n'y a pas d'interlocuteur potentiel, on ne va pas plus loin et on envoie la vue */
            $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => NULL]);
        }
        else if(empty($chat->getChat()) && $interlocutorId != -1){
            /* Liste de conversations vide, mais interlocuteur demandé:
            on crée une conversation vierge qu'on envoie en DB et dont on récupère l'id */
            $conversationManager = new ConversationManager();
            $conversation = new Conversation();
            $conversation->setInterlocutor($interlocutor);
            if($conversationManager->addConversation($connectedUserId, $interlocutorId) === true)
                $conversation->setConversationId($conversationManager->getLastConversationId());
            else
                throw new Exception("Une erreur est survenue lors de l'initialisation de la conversation.");
            $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
        }
        else{
            /* On récupère une conversation à afficher entièrement */
            $conversationManager = new ConversationManager();
            if($interlocutor != NULL){
                /* Si l'interlocuteur existe, on charge la conversation entre l'utilisateur connecté et l'interlocuteur: */
                $conversation = $conversationManager->getConversationByUsersId($connectedUserId, $interlocutorId);
                if($conversation != NULL){
                    /* Le conversation existe, on lui attribue l'interlocuteur */
                    $conversation->setInterlocutor($interlocutor);
                }
                else{
                    /* Le conversation n'existe pas, on lui attribue l'interlocuteur et on l'initialise */
                    $conversationManager = new ConversationManager();
                    $conversation = new Conversation();
                    $conversation->setInterlocutor($interlocutor);
                    if($conversationManager->addConversation($connectedUserId, $interlocutorId) === true)
                        $conversation->setConversationId($conversationManager->getLastConversationId());
                    else
                        throw new Exception("Une erreur est survenue lors de l'initialisation de la conversation.");
                }

            }
            else{
                /* Si pas d'interlocuteur: */
                if($conversationId === NULL){
                    /* si pas d'id de conversation, on prend l'id de la conversation comportant le message le + récent */
                    $conversationId = $chat->getChat()[0]->getConversationId();
                }
                $conversation = $conversationManager->getConversationById($conversationId, $connectedUserId);
                $interlocutor = $conversationManager->getInterlocutor($connectedUserId, $conversationId);
                $conversation->setInterlocutor($interlocutor);
            }
            $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
        }

    }

    public function sendMessage() : void
    {
        $userId = $_SESSION["user"];
        $text = Utils::request("message");
        $conversationId = Utils::request("conversationId");

        $messageManager = new MessageManager();

        $seenByRecipientMessageIds = json_decode(Utils::request("seenByRecipientMessagesIds"));
        if(!empty($seenByRecipientMessageIds)){
            $placeholders = [];
            $params = [];
            foreach ($seenByRecipientMessageIds as $index => $id) {
                $placeholder = ":id{$index}";
                $placeholders[] = $placeholder;
                $params[$placeholder] = (int)$id;
            }
            $messageManager->updateMessageStatus($params, $placeholders);
        }

        $sender = new User(["userId" => $userId]);
        $message = new Message([
            "text" => $text,
            "sender" => $sender,
            "seenByRecipient" => false,
            "conversationId" => $conversationId]);
        if($messageManager->sendMessage($message))
        {
            Utils::redirect("chat", ["conversationId" => $conversationId]);
        }
        else
        {
            throw new Exception("Une erreur est survenue lors de l'envoi du message.");
        }

    }
}