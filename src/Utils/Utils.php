<?php
declare(strict_types=1);

namespace App\Utils;

final class Utils
{
    /* Classe utilitaire regroupant des méthodes générales */
    public static function redirect(string $action, array $params = []) : void
    {
        $url = "/" . $action;
        foreach ($params as $param) {
            $url .= "/$param";
        }
        header("Location: $url");
        exit();
    }
}