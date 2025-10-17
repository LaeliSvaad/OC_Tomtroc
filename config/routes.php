<?php

declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\LibraryController;
use App\Controller\BookController;
use App\Controller\ChatController;
use App\Controller\UserController;

return[
    ["/", HomeController::class, "showHomepage"],
    ["/nos-livres", LibraryController::class, "showLibrary"],
    ["/nos-livres/{id:\d+}", BookController::class, "showBook"],
    ["/chat", ChatController::class, "showChat"],
    ["/chat/{id:\d+}", ChatController::class, "showConversation"],
    ["/inscription", UserController::class, "signUp"],
    ["/connexion", UserController::class, "logIn"],
    ["/deconnexion", UserController::class, "logOut"],
    ["/mon-compte", UserController::class, "showPrivateUserPage"],
    ["/editer-utilisateur", UserController::class, "modifyUser"],
    ["/utilisateur/{id:\d+}", UserController::class, "showPublicUserPage"],
    ["/editer-livre/{id:\d+}", BookController::class, "editBook"],
];