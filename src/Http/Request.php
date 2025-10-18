<?php
declare(strict_types=1);

namespace App\Http;

final class Request
{
    private array $get;
    private array $post;
    private array $files;
    private array $server;

    public function __construct(array $get = [], array $post = [], array $files = [], array $server = [])
    {
        $this->get = $get ?: $_GET;
        $this->post = $post ?: $_POST;
        $this->files = $files ?: $_FILES;
        $this->server = $server ?: $_SERVER;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function allPost(): array
    {
        return $this->post;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function allFiles(): array
    {
        return $this->files;
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'] ?? '/', '?');
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }
}