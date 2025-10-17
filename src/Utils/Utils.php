<?php
declare(strict_types=1);

namespace App\Utils;

final class Utils
{
    public static function request(string $key, mixed $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }

    public static function redirect(string $action, array $params = []) : void
    {
        $url = "/";
        foreach ($params as $param) {
            $url .= "/$param";
        }
        header("Location: $url");
        exit();
    }

    public static function dateInterval(DateTime $registrationDate) :string
    {
        $now = new DateTime();
        $interval = $now->diff($registrationDate);
        if($interval->y != 0)
            return $interval->format("%y ans");
        else if($interval->y === 0 && $interval->m != 0)
            return $interval->format("%m mois");
        else if($interval->y === 0 && $interval->m === 0 && $interval->d != 0)
            return $interval->format("%d jours");
        else
            return $interval->format("%H heures");
    }
    public static function convertDateToMediumFormat(DateTime $date) : string
    {
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $today = new DateTime('today');
        if ($date->format('Y-m-d') !== $today->format('Y-m-d')) {
            $dateFormatter->setPattern('dd.MM HH:mm');
        } else {
            $dateFormatter->setPattern('HH:mm');
        }
        return $dateFormatter->format($date);
    }

    public static function convertDateToSmallFormat(DateTime $date) : string
    {
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $today = new DateTime('today');
        if ($date->format('Y-m-d') !== $today->format('Y-m-d')) {
            $dateFormatter->setPattern('dd.MM');
        } else {
            $dateFormatter->setPattern('HH:mm');
        }
        return $dateFormatter->format($date);
    }

    public static function askConfirmation(string $message) : string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    public static function controlPassword(string $password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function controlProfilePicture(string $filename) : ?string
    {
        if($filename != "")
            return "pictures/profile/" . htmlspecialchars(strtolower(trim($filename)));
        else
            return "pictures/profile/default-profile-picture.png";
    }

    public static function controlUserInput(string $userInput) : string
    {
        return htmlspecialchars($userInput);
    }
}