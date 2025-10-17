<?php
namespace App\Controller;

class NotFoundController extends AbstractController
{
    public function show404()
    {
        $this->render("Erreur 404", "404-error");
    }
}