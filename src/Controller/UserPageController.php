<?php

class UserPageController
{
    public function showPublicUserPage(): void
    {
        if(is_null(Utils::request("id")))
        {
            $view = new View('Erreur');
            $view->render("error-page");
        }
        else
        {
            $userId= Utils::request("id");
            $userManager = new UserManager();
            $user = $userManager->getPublicUserById($userId);
            if(!is_null($user))
            {
                $libraryManager = new LibraryManager();
                $userLibrary = $libraryManager->getLibraryByUserId($userId);
                $user->setLibrary($userLibrary);
                $chat = new Chat();
                if(isset($_SESSION["user"]))
                {
                    $conversationManager = new ConversationManager();
                    $conversation =  $conversationManager->getConversationByUsersId($_SESSION["user"], $user->getUserId());
                    $chat->addConversation($conversation);
                }
                $user->setChat($chat);
            }
            $view = new View('user-public-account');
            $view->render("user-public-account", ['user' => $user]);
        }
    }

    public function showPrivateUserPage(): void
    {
        if(!isset($_SESSION['user']))
        {
            $view = new View('sign-in');
            $view->render("sign-in");
        }
        else
        {
            $userId = $_SESSION['user'];
            $userManager = new UserManager();
            $user = $userManager->getPrivateUserById($userId);

            if(!is_null($user))
            {
                $libraryManager = new LibraryManager();
                $userLibrary = $libraryManager->getLibraryByUserId($userId);
                $user->setLibrary($userLibrary);
                $chatManager = new ChatManager();
                $userChat = $chatManager->getChat($userId);
                $user->setChat($userChat);
            }

            $view = new View('user-private-account');
            $view->render("user-private-account", ['user' => $user]);
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