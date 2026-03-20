<?php
declare(strict_types=1);

namespace App\Utils;

final class UserInput
{
    /* Classe utilitaire regroupant diverses méthodes permettant d'effectuer le contrôle des données envoyées par l'utilisateur */
    public static function controlPassword(string $password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function controlUserInput(string $userInput) : string
    {
        return htmlspecialchars($userInput);
    }

    public static function askConfirmation(string $message) : string
    {
        return "onclick=\"return confirm('$message');\"";
    }

}