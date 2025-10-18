<?php
declare(strict_types=1);

namespace App\Http\Session;

interface SessionStorageInterface
{
    public function start(): void;
    public function has(string $key): bool;
    public function get(string $key, mixed $default = null): mixed;
    public function set(string $key, mixed $value): void;
    public function remove(string $key): void;
    public function clear(): void;
    public function destroy(): void;
    public function regenerate(): void;
}