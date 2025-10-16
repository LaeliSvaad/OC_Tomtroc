<?php
declare(strict_types=1);

namespace App\Config;

final class Config
{
    private static array $configs = [];


    public static function get(string $key, mixed $default = null): mixed
    {
        $parts = explode('.', $key, 2); // limite à 2 parties
        $file = $parts[0];
        $param = $parts[1] ?? null;

        // Charger le fichier si ce n’est pas déjà fait
        if (!isset(self::$configs[$file])) {
            $path = __DIR__ . "/../../config/{$file}.php";
            if (!file_exists($path)) {
                throw new \RuntimeException("Configuration file '{$file}.php' not found.");
            }
            self::$configs[$file] = require $path; // stocke tout le tableau
        }

        // Si aucun paramètre, retourne tout le fichier
        if ($param === null) {
            return self::$configs[$file];
        }

        // Retourne la valeur du paramètre ou le default
        return self::$configs[$file][$param] ?? $default;
    }
}