<?php
declare(strict_types=1);

namespace App;

final class Utils
{
    public static function request(string $key, mixed $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }
}