<?php
namespace App\Service;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Manager\UserManager;
use App\Utils\UserInput;
use App\Model\User;

class UserService
{
    private UserManager $userManager;
    private Request $request;
    private User $user;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->request = new Request();
        $this->user = new User();
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
}
