<?php
declare(strict_types=1);

namespace App\Utils;

final class UserInput
{
    public static function controlPassword(string $password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function controlProfilePicture(string $filename) : string
    {
        if($filename != "")
            return "/assets/images/profile" . htmlspecialchars(strtolower(trim($filename)));
        else
            return "/assets/images/profile/default-profile-picture.png";
    }

    public static function controlBookPicture(string $filename) : string
    {
        if($filename != "")
            return "/assets/images/books" . htmlspecialchars(strtolower(trim($filename)));
        else
            return "/assets/images/books/default-book-picture.png";
    }

    public static function controlUserInput(string $userInput) : string
    {
        return htmlspecialchars($userInput);
    }
}