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
    ["/recherche-livres", LibraryController::class, "showSearchResults"],
    ["/chat", ChatController::class, "showChat"],
    ["/chat/{type}-{id:\d+}", ChatController::class, "showChat"],
    ["/formulaire-inscription", UserController::class, "signUp"],
    ["/inscription", UserController::class, "signUp"],
    ["/connexion", UserController::class, "logIn"],
    ["/deconnexion", UserController::class, "logOut"],
    ["/mon-compte", UserController::class, "showPrivateUserPage"],
    ["/editer-utilisateur", UserController::class, "modifyUser"],
    ["/utilisateur/{userId:\d+}", UserController::class, "showPublicUserPage"],
    ["/formulaire-livre", BookController::class, "addBookForm"],
    ["/ajouter-livre", BookController::class, "addBook"],
    ["/formulaire-livre/{bookId:\d+}", BookController::class, "editBookForm"],
    ["/modifier-livre/{bookId:\d+}", BookController::class, "editBook"],
    ["/supprimer-livre/{bookId:\d+}", LibraryController::class, "deleteBook"],
];