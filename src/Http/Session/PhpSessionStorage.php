<?php
declare(strict_types=1);

namespace App\Http\Session;

final class PhpSessionStorage implements SessionStorageInterface
{
    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        session_unset();
    }

    public function destroy(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            $_SESSION = [];
            session_destroy();
        }
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
    }
}