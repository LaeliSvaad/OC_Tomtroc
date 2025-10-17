<?php
declare(strict_types=1);

namespace App\Controller;

use App\View\View;

abstract class AbstractController
{
    /**
    * Rendu d'une vue avec titre et données
    */
    protected function render(string $title, string $viewName, array $data = []): void
    {
        $view = new View($title, $viewName);
        $view->render($title, $viewName, $data);
    }

    /**
    * Redirection HTTP
    */
    protected function redirect(string $url): never
    {
        header("Location: {$url}");
        exit;
    }

    /**
    * Vérifie la session utilisateur
    */
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }
}

