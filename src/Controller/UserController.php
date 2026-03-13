<?php
namespace App\Controller;

use App\Manager\UserManager;
use App\Manager\ChatManager;
use App\Manager\ConversationManager;
use App\Manager\LibraryManager;
use App\Service\UserService;
use App\Model\Chat;
use App\Http\Session\SessionStorageInterface;
use App\Http\Request;
use App\Utils\Utils;
use App\Utils\UserInput;
use App\View\View;

class UserController extends AbstractController
{
    private readonly UserManager $userManager;
    private Request $request;
    private UserService $userService;
    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        $this->userManager = new userManager();
        $this->userService = new UserService();
        $this->request = $request;

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
       if(is_null($userId)){
           $this->render("Erreur","404-error");
       }
       else
       {
           $user = $this->userManager->getPublicUserById($userId);
           if (!is_null($user)) {
               $libraryManager = new LibraryManager();
               $userLibrary = $libraryManager->getLibraryByUserId($userId);
               $user->setLibrary($userLibrary);
               $chat = new Chat();
               if (isset($_SESSION["user"])) {
                   $conversationManager = new ConversationManager();
                   $conversation = $conversationManager->getConversationByUsersId($_SESSION["user"], $user->getUserId());
                   $chat->addConversation($conversation);
               }
               $user->setChat($chat);
           }

           $this->render("Utilisateur", "user-public-account", ['user' => $user]);
       }
    }

    public function showPrivateUserPage(): void
    {
        if(is_null($this->session->get('userId')))
        {
            $this->render("Erreur", "404-error");
        }
        else
        {
            $userId =$this->session->get('userId');
            $user = $this->userManager->getPrivateUserById($userId);

            if(!is_null($user))
            {
                $libraryManager = new LibraryManager();
                $userLibrary = $libraryManager->getLibraryByUserId($userId);
                $user->setLibrary($userLibrary);
                $chatManager = new ChatManager();
                $userChat = $chatManager->getChat($userId);
                $user->setChat($userChat);
            }
            $this->render("Utilisateur", "user-private-account", ['user' => $user, 'current_page' => 'user-private-account',]);
        }
    }

    public function modifyUser(): void
    {
        $userRequest["picture"] = $this->request->file("picture");
        $userRequest["nickname"] = $this->request->post("nickname");
        $userRequest["email"] = $this->request->post("email");
        $userRequest["password"] = $this->request->post("password");
        $userRequest["userId"]= $this->request->post("userId");

        if(!isset($userRequest["userId"]) || $userRequest["userId"] == 0)
            throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 0");
        else{
            $userRequest["userId"] = (int)UserInput::controlUserInput($this->request->post("userId"));
            $userManager = new UserManager();
            $user = $userManager->getPrivateUserById($userRequest["userId"]);
        }

        foreach ($userRequest as $key => $value) {

            switch ($key) {
                case 'nickname':
                    if($userRequest["nickname"] != null)
                    {
                        $userRequest["nickname"] = UserInput::controlUserInput($userRequest["nickname"]);
                        if($userRequest["nickname"] != $user->getNickname()){
                            $modif = $userManager->modifyUserNickname($userRequest["nickname"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 1");
                        }
                    }
                    continue 2;

                case 'email':
                    if($userRequest["email"] != null && $userRequest["email"] != $user->getEmail())
                    {
                        $userRequest["email"] = UserInput::controlUserInput($userRequest["email"]);
                        if($userRequest["email"] != $user->getEmail()){
                            $modif = $userManager->modifyUserEmail($userRequest["email"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 2");
                        }
                    }
                    continue 2;

                case 'password':
                    if($userRequest["password"] != null)
                    {
                        $userRequest["password"] = UserInput::controlPassword($userRequest["password"]);
                        if($userRequest["password"] != $user->getPassword()){
                            $modif = $userManager->modifyUserPassword($userRequest["password"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 3");
                        }
                    }
                    continue 2;

                case 'picture':
                    if($userRequest["picture"] != null)
                    {
                        $userRequest["picture"]["name"] = UserInput::controlProfilePicture($userRequest["picture"]["name"]);

                        if(move_uploaded_file($userRequest["picture"]["tmp_name"], $userRequest["picture"]["name"]) === false){
                            throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 4");
                        }
                        else{
                            $modif = $userManager->modifyUserPicture($userRequest["picture"]["name"], $userRequest["userId"]);
                                if($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 5");
                            }
                    }
                    break;
            }
        }
        Utils::redirect('mon-compte');
    }
}