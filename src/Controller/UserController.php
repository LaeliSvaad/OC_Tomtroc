<?php
namespace App\Controller;

use App\Manager\UserManager;
use App\Manager\ChatManager;
use App\Manager\ConversationManager;
use App\Manager\LibraryManager;
use App\Model\Chat;
use App\Http\Session\SessionStorageInterface;
use App\Http\Request;
use App\Utils\Utils;
use App\View\View;

class UserController extends AbstractController
{
    private readonly UserManager $userManager;
    private Request $request;
    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        $this->request = $request;
        parent::__construct($view, $session);
        $this->userManager= new UserManager();

    }

    public function logIn(): void
    {
        if($this->request->isPost())
        {
            $nickname = $this->request->post('nickname', '');
            $email = $this->request->post('email', '');
            $password = $this->request->post('password', '');

            $user = $this->userManager->getUserByLoginInfo($nickname, $email);

            if(!is_null($user))
            {
                if (!password_verify($password, $user->getPassword())) {
                    throw new \Exception("Une erreur est survenue lors de l'authentification.");
                }

                $this->session->set('userId', $user->getUserId());
                $this->session->regenerate();
                Utils::redirect("mon-compte");
            }
            else
            {
                $this->render("Connexion", "log-in");
            }
        }
        else
        {
            $this->render("Connexion", "log-in");
        }
    }

    public function signUp(){
        $params["nickname"] = Utils::controlUserInput(Utils::request("nickname"));
        $params["email"] = Utils::controlUserInput(Utils::request("email"));
        $params["password"] = Utils::controlPassword(Utils::request("password"));
        $user = new User($params);
        $userManager = new UserManager();
        if($userManager->checkExistingEmail($params["email"]))
        {
            throw new Exception("Un compte existe déjà avec cette adresse mail.");
        }
        else{
            $success = $userManager->addUser($user);
        }
        if($success){
            $view = new View('sign-in');
            $view->render("sign-in");
        }
        else{
            $view = new View('sign-up');
            $view->render("sign-up");
        }
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
        if(isset($_FILES["picture"]))
            $userRequest["picture"] = $_FILES["picture"];
        $userRequest["nickname"] = Utils::request("nickname");
        $userRequest["email"] = Utils::request("email");
        $userRequest["password"] = Utils::request("password");
        $userRequest["userId"]= Utils::request("userId");

        if(!isset($userRequest["userId"]) || $userRequest["userId"] == 0)
            throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 0");
        else{
            $userRequest["userId"] = (int)Utils::controlUserInput(Utils::request("userId"));
            $userManager = new UserManager();
            $user = $userManager->getPrivateUserById($userRequest["userId"]);
        }

        foreach ($userRequest as $key => $value) {

            switch ($key) {
                case 'nickname':
                    if($userRequest["nickname"] != null)
                    {
                        $userRequest["nickname"] = Utils::controlUserInput($userRequest["nickname"]);
                        if($userRequest["nickname"] != $user->getNickname()){
                            $modif = $userManager->modifyUserNickname($userRequest["nickname"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 1");
                        }
                    }
                    continue 2;

                case 'email':
                    if($userRequest["email"] != null && $userRequest["email"] != $user->getEmail())
                    {
                        $userRequest["email"] = Utils::controlUserInput($userRequest["email"]);
                        if($userRequest["email"] != $user->getEmail()){
                            $modif = $userManager->modifyUserEmail($userRequest["email"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 2");
                        }
                    }
                    continue 2;

                case 'password':
                    if($userRequest["password"] != null)
                    {
                        $userRequest["password"] = Utils::controlPassword($userRequest["password"]);
                        if($userRequest["password"] != $user->getPassword()){
                            $modif = $userManager->modifyUserPassword($userRequest["password"], $userRequest["userId"]);
                            if($modif == 0)
                                throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 3");
                        }
                    }
                    continue 2;

                case 'picture':
                    if($userRequest["picture"] != null)
                    {
                        $userRequest["picture"]["name"] = Utils::controlProfilePicture($userRequest["picture"]["name"]);

                        if(move_uploaded_file($userRequest["picture"]["tmp_name"], $userRequest["picture"]["name"]) === false){
                            throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 4");
                        }
                        else{
                            $modif = $userManager->modifyUserPicture($userRequest["picture"]["name"], $userRequest["userId"]);
                                if($modif == 0)
                                    throw new Exception("Une erreur est survenue lors de la mise à jour de vos informations. 5");
                            }
                    }
                    break;
            }
        }
        Utils::redirect('user-private-account');
    }
}