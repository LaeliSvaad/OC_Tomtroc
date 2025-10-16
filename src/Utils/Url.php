<?php

namespace App\Utils;

use App\Config\Config;

class Url
{
    public static function to(string $path): string
    {
        $base = rtrim(Config::get('app.base_url'), '/');
        $path = ltrim($path, '/');
        return $base . '/' . $path;
    }
}
