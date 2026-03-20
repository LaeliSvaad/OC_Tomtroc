<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Service\ChatService;
use App\Service\MessageService;
use App\View\View;
use App\Utils\Utils;

class ChatController extends AbstractController
{
    private ChatService $chatService;
    private MessageService $messageService;
    private Request $request;

    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        parent::__construct($view, $session);
        $this->request = $request;
        $this->chatService = new ChatService();
        $this->messageService = new MessageService();
    }

    public function showChat(?string $type = null, ?int $id = null): void
    {
        /* Premièrement: pas d'accès au chat si pas d'utilisateur connecté. */
        $connectedUserId = $this->session->get('userId');
        if ($connectedUserId === null) {
            Utils::redirect('/login');
            return;
        }

        /* Si un message est envoyé, on le traite puis on récupère le chat et on renvoie la vue: */
        $messageData = $this->messageService->handleMessagePost($connectedUserId, $this->request);

        if (!empty($messageData)) {
            $this->render("chat", 'chat', $messageData);
            return;
        }

        /* Si aucun message n'est envoyé, on récupère le chat et on envoie la vue: */
        $chatData = $this->chatService->prepareChatData($connectedUserId, $type, $id);
        $this->render("chat", 'chat', ["conversation" => $chatData["conversation"], "chat" => $chatData["chat"]]);
    }
}