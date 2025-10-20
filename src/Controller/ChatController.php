<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Manager\UserManager;
use App\Manager\MessageManager;
use App\Manager\ConversationManager;
use App\Manager\ChatManager;
use App\Model\Conversation;
use App\Model\Message;
use App\Utils\Utils;
use App\View\View;

class ChatController extends AbstractController
{
    private readonly ChatManager $chatManager;
    private readonly UserManager $userManager;
    private readonly ConversationManager $conversationManager;
    private Request $request;

    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        $this->request = $request;
        parent::__construct($view, $session);
        $this->chatManager= new ChatManager();
        $this->userManager= new UserManager();
        $this->conversationManager= new ConversationManager();

    }

    public function showChat(?string $type = null, ?int $id = null) : void
    {
        /* On récupère l'utilisateur connecté*/
        $connectedUserId = $this->session->get('userId');
        if(!is_null($connectedUserId))
            $connectedUser = $this->userManager->getPublicUserById($connectedUserId);

        $conversationId = $this->request->post('conversationId');
        $text = $this->request->post('message');
        $seenByRecipientMessagesIds = $this->request->post('seenByRecipientMessagesIds');

        if(isset($conversationId) && isset($text))
        {
            if(!is_null($seenByRecipientMessagesIds))
                $seenByRecipientMessagesIds = json_decode($seenByRecipientMessagesIds);
            $messageManager = new MessageManager();
            $message = new Message();
            $message->setConversationId($conversationId);
            $message->setText($text);
            $message->setSender($connectedUser);
            $message->setSeenByRecipient(false);
            if($messageManager->sendMessage($message) != 0)
            {
                if(!empty($seenByRecipientMessagesIds))
                {
                    $placeholders = [];
                    $params = [];
                    foreach ($seenByRecipientMessagesIds as $index => $id) {
                        $placeholder = ":id{$index}";
                        $placeholders[] = $placeholder;
                        $params[$placeholder] = (int)$id;
                    }
                    $messageManager->updateMessageStatus($params, $placeholders);
                }
                $chat = $this->chatManager->getChat($connectedUserId);
                $chat->setConnectedUser($connectedUser);
                $this->chatManager->getUnreadMessagesIds($connectedUserId, $chat);
                $conversation = $this->conversationManager->getConversationById($conversationId, $connectedUserId);
                $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
            }
            else
            {
                throw new \Exception("Une erreur est survenue lors de l'envoi du message");
            }
        }
        
        /* On récupère le chat de l'utilisateur connecté */
        $chat = $this->chatManager->getChat($connectedUserId);
        $chat->setConnectedUser($connectedUser);

        if(is_null($type))
        {
            if(!empty($chat->getChat()[0]))
            {
                $conversationId = $chat->getChat()[0]->getConversationId();
                $conversation = $this->conversationManager->getConversationById($conversationId, $connectedUserId);

                $this->chatManager->getUnreadMessagesIds($connectedUserId, $chat);

                $interlocutor = $this->conversationManager->getInterlocutor($connectedUserId, $conversationId);
                $conversation->setInterlocutor($interlocutor);
                $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
            }
            else
            {

                $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => NULL]);
            }
        }
        else if($type === "conversation")
        {

            $conversation = $this->conversationManager->getConversationById($id, $connectedUserId);
            $interlocutor = $this->conversationManager->getInterlocutor($connectedUserId, $id);
            $conversation->setInterlocutor($interlocutor);
            $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
        }
        else if($type === "interlocuteur")
        {
            $interlocutor = $this->userManager->getPublicUserById($id);
            $conversation = $this->conversationManager->getConversationByUsersIds($connectedUserId, $id);
            if(is_null($conversation))
            {

                if($this->conversationManager->addConversation($connectedUserId, $id) === true)
                {
                    $conversation = new Conversation();
                    $conversation->setConversationId($this->conversationManager->getLastConversationId());
                }
                else
                    throw new \Exception("Une erreur est survenue lors de l'initialisation de la conversation.");


                $conversation->setInterlocutor($interlocutor);
            }
            else
            {
                $conversation->setInterlocutor($interlocutor);
            }
            $this->render("chat", 'chat', ['chat' => $chat, 'conversation' => $conversation]);
        }
        else{
            $this->render("Erreur", '404-error');
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