<?php
namespace App\Service;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Manager\ChatManager;
use App\Manager\ConversationManager;
use App\Manager\LibraryManager;
use App\Manager\UserManager;
use App\Model\Chat;
use App\Utils\UserInput;
use App\Model\User;

class UserService
{
    private UserManager $userManager;
    private ChatManager $chatManager;
    private ConversationManager $conversationManager;
    private LibraryManager $libraryManager;
    private Request $request;
    private User $user;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->libraryManager = new LibraryManager();
        $this->chatManager = new ChatManager();
        $this->conversationManager = new ConversationManager();
        $this->user = new User();
        $this->request = new Request();
    }

    public function handleLogIn(SessionStorageInterface $session) : bool
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
                $session->set('userId', $user->getUserId());
                $session->regenerate();
                return true;
            }
        }
        return false;
    }

    public function handleSignUp() : bool
    {
        if($this->request->isPost())
        {
            $this->user->setNickname(UserInput::controlUserInput($this->request->post("nickname")));
            $this->user->setEmail(UserInput::controlUserInput($this->request->post("email")));
            $this->user->setPassword(UserInput::controlUserInput($this->request->post("password")));
            if ($this->userManager->checkExistingEmail($this->user->getEmail()))
                throw new \Exception("Un compte existe déjà avec cette adresse mail.");
            else {
                $this->userManager->addUser($this->user);
                return true;
            }
        }
        return false;
    }

    public function handlePublicUser(int $userId) : User
    {
        $this->user = $this->userManager->getPublicUserById($userId);

        if (!is_null($this->user)) {
            $this->user->setLibrary($this->libraryManager->getLibraryByUserId($userId));
            $chat = new Chat();
            if (isset($_SESSION["user"])) {
                $conversation = $this->conversationManager->getConversationByUsersIds($_SESSION["user"], $this->user->getUserId());
                $chat->addConversation($conversation);
            }
            $this->user->setChat($chat);
        }

        return $this->user;
    }

    public function handlePrivateUser(int $userId) : User
    {
        $this->user = $this->userManager->getPrivateUserById($userId);

        if(!is_null($this->user))
        {
            $this->user->setLibrary($this->libraryManager->getLibraryByUserId($userId));
            $this->user->setChat($this->chatManager->getChat($userId));
        }
        return $this->user;
    }

    public function handleModifyUser() : bool
    {
        $userRequest["picture"] = $this->request->file("picture");
        $userRequest["nickname"] = $this->request->post("nickname");
        $userRequest["email"] = $this->request->post("email");
        $userRequest["password"] = $this->request->post("password");
        $userRequest["userId"]= $this->request->post("userId");

        if(!isset($userRequest["userId"]) || $userRequest["userId"] == 0){
            return false;
        }
        else{
            $userRequest["userId"] = (int)UserInput::controlUserInput($this->request->post("userId"));
            $this->user = $this->userManager->getPrivateUserById($userRequest["userId"]);
            foreach ($userRequest as $key => $value) {
                switch ($key) {
                    case 'nickname':
                        if($userRequest["nickname"] != null)
                        {
                            $userRequest["nickname"] = UserInput::controlUserInput($userRequest["nickname"]);
                            if($userRequest["nickname"] != $this->user->getNickname()){
                                $modif = $this->userManager->modifyUserNickname($userRequest["nickname"], $userRequest["userId"]);
                                if($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 1");
                            }
                        }
                        continue 2;

                    case 'email':
                        if($userRequest["email"] != null && $userRequest["email"] != $this->user->getEmail())
                        {
                            $userRequest["email"] = UserInput::controlUserInput($userRequest["email"]);
                            if($userRequest["email"] != $this->user->getEmail()){
                                $modif = $this->userManager->modifyUserEmail($userRequest["email"], $userRequest["userId"]);
                                if($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 2");
                            }
                        }
                        continue 2;

                    case 'password':
                        if($userRequest["password"] != null)
                        {
                            $userRequest["password"] = UserInput::controlPassword($userRequest["password"]);
                            if($userRequest["password"] != $this->user->getPassword()){
                                $modif = $this->userManager->modifyUserPassword($userRequest["password"], $userRequest["userId"]);
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
                                $modif = $this->userManager->modifyUserPicture($userRequest["picture"]["name"], $userRequest["userId"]);
                                if($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la mise à jour de vos informations. 5");
                            }
                        }
                        break;
                }
            }
            return true;
        }
    }
}
