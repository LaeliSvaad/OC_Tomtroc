<?php
namespace App\Controller;

use App\Service\UserService;
use App\Http\Session\SessionStorageInterface;
use App\Utils\Utils;
use App\View\View;

class UserController extends AbstractController
{
    private UserService $userService;
    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->userService = new UserService();
        parent::__construct($view, $session);
    }

    public function logIn(): void
    {
        /* Traitement via le UserService des données envoyées par l'utilisateur via le formulaire */
        $connected = $this->userService->handleLogIn($this->session);

        /* Redirection vers la page mon compte une fois la connexion établie, vers le formulaire de connexion si une erreur est survenue */
        if($connected === false)
            $this->view->render("Connexion", "log-in");
        else
            Utils::redirect('mon-compte');

    }

    public function signUp()
    {
        /* Traitement via le UserService des données envoyées par l'utilisateur via le formulaire */
        $registered = $this->userService->handleSignUp();

        /* Redirection vers le formulaire de connexion une fois l'inscription faite, retour au formulaire d'enregistrement si une erreur est survenue */
        if($registered === false)
            $this->view->render("Inscription", "sign-up");
        else
            $this->view->render("Connexion", "log-in");
    }

    public function logOut(){

        $_SESSION = [];
        //Suppression de la session côté client
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        Utils::redirect("");
    }

    public function showPublicUserPage(int $userId): void
    {
       if(!is_null($userId)){
           $user = $this->userService->handlePublicUser($userId);
           if (!is_null($user))
               $this->render("Utilisateur", "user-public-account", ['user' => $user]);
       }
       else
           $this->render("Erreur","404-error");

    }

    public function showPrivateUserPage(): void
    {
        if(!is_null($this->session->get('userId')))
        {
            $userId =$this->session->get('userId');
            $user = $this->userService->handlePrivateUser($userId);
            $this->render("Utilisateur", "user-private-account", ['user' => $user, 'current_page' => 'user-private-account',]);
        }
        else
        {
            $this->render("Erreur", "404-error");
        }
    }

    public function modifyUser(): void
    {
       $this->userService->handleModifyUser();
       Utils::redirect('mon-compte');
    }
}