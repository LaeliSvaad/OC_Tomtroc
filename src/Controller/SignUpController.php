<?php

class SignUpController
{
    public function addUser() : void
    {
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

    public function showForm() : void
    {
        $view = new View('sign-up');
        $view->render("sign-up");
    }
}