<?php
declare(strict_types=1);

namespace App\Routing;

use App\Controller\HomeController;
use App\Controller\LibraryController;
use App\Controller\BookController;
use App\Controller\ChatController;
use App\Controller\UserController;

final class Router
{
    public function handleRequest(string $uri): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($path) {
            case '/':
                $this->homeRoute();
                break;
            case '/nos-livres':
                $this->libraryRoute();
                break;
            case (preg_match('#^/nos-livres/(\d+)$#', $path, $matches) ? true : false):
                $this->bookRoute((int)$matches[1]);
                break;
            case '/chat':
                $this->chatRoute();
                break;
            case '/mon-compte':
                $this->privateUserRoute();
                break;
            case '/utilisateur':
                $this->publicUserRoute();
                break;
            default:
                http_response_code(404);
                echo "Page not found.";
        }
    }

    private function homeRoute(): void
    {
        $homeController = new HomeController();
        $homeController->showHomepage();
    }

    private function libraryRoute(): void
    {
        $libraryController = new LibraryController();
        $libraryController->showLibrary();
    }

    private function chatRoute(): void
    {
        $chatController = new ChatController();
        $chatController->showChat();
    }

    private function bookRoute(int $id): void
    {
        $bookController = new BookController();
        $bookController->showBook($id);
    }
    private function publicUserRoute(): void
    {
        $userController = new UserController();
        $userController->showPublicUserPage();
    }
    private function privateUserRoute(): void
    {
        $userController = new UserController();
        $userController->showPrivateUserPage();
    }
}