<?php
namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\View\View;

class NotFoundController extends AbstractController
{
    public function __construct(View $view, SessionStorageInterface $session)
    {
        parent::__construct($view, $session);
    }
    public function show404()
    {
        $this->render("Erreur 404", "404-error");
    }
}