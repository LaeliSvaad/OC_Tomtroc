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
    ["/nos-livres/{bookId:\d+}", BookController::class, "showBook"],
    ["/chat", ChatController::class, "showChat"],
    ["/chat/{type}-{id:\d+}", ChatController::class, "showChat"],
    ["/inscription", UserController::class, "signUp"],
    ["/connexion", UserController::class, "logIn"],
    ["/deconnexion", UserController::class, "logOut"],
    ["/mon-compte", UserController::class, "showPrivateUserPage"],
    ["/editer-utilisateur", UserController::class, "modifyUser"],
    ["/utilisateur/{userId:\d+}", UserController::class, "showPublicUserPage"],
    ["/editer-livre/{bookId:\d+}", BookController::class, "editBook"],
];