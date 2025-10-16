<?php
class SignInController
{
    public function connectUser() : void
    {

        // On récupère les données du formulaire.
        $nickname = Utils::request("nickname");
        $email = Utils::request("email");
        $password = Utils::request("password");
        //On sécurise les entrées utilisateur
        $nickname = Utils::controlUserInput($nickname);
        $email = Utils::controlUserInput($email);

        // On vérifie que les données sont valides.
        if (empty($nickname) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLoginInfo($nickname, $email);

        if (!$user) {
            throw new Exception("Une erreur est survenue lors de l'authentification.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            throw new Exception("Une erreur est survenue lors de l'authentification.");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user->getId();

        //On redirige vers la page utilisateur
        Utils::redirect("user-private-account", ["userId" => $user->getId()]);
    }

    public function disconnectUser() : void
    {
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

        Utils::redirect("home");
    }

    public function showForm() : void
    {
        $view = new View('sign-in');
        $view->render("sign-in");
    }
}