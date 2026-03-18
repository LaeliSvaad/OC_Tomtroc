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
    ["/recherche-livres", LibraryController::class, "showSearchResults"],
    ["/nos-livres/{bookId:\d+}", BookController::class, "showBook"],
    ["/chat", ChatController::class, "showChat"],
    ["/chat/{type}-{id:\d+}", ChatController::class, "showChat"],
    ["/formulaire-inscription", UserController::class, "signUp"],
    ["/inscription", UserController::class, "signUp"],
    ["/connexion", UserController::class, "logIn"],
    ["/deconnexion", UserController::class, "logOut"],
    ["/mon-compte", UserController::class, "showPrivateUserPage"],
    ["/editer-utilisateur", UserController::class, "modifyUser"],
    ["/utilisateur/{userId:\d+}", UserController::class, "showPublicUserPage"],
    ["/formulaire-livre", LibraryController::class, "addBookForm"],
    ["/checkExistingBooks", LibraryController::class, "checkExistingBooks"],
    ["/ajouter-livre", LibraryController::class, "addBook"],
    ["/supprimer-livre/{bookId:\d+}", LibraryController::class, "deleteBook"],
    ["/formulaire-livre/{bookId:\d+}", BookController::class, "editBookForm"],
    ["/modifier-livre/{bookId:\d+}", BookController::class, "editBook"],
];