<?php

declare(strict_types=1);

namespace App\View;

final class View
{
    private string $title;
    private string $template;
    private string $layout;


    public function __construct(string $title, string $template, string $layout = 'layout')
    {
        $this->title = $title;
        $this->template = $template;
        $this->layout = $layout;
    }

    public function render(string $title, string $viewName, array $params = []): void
    {
        $templatePath = __DIR__ . "/templates/{$viewName}.php";
        $layoutPath = __DIR__ . "/templates/{$this->layout}.php";

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template {$viewName}.php introuvable.");
        }

        // Extraction des variables (ex: $chat, $conversation, etc.)
        extract($params);
        $this->title = $title;
        // On capture le contenu du template dans une variable
        ob_start();
        require $templatePath;
        $content = ob_get_clean();

        // On inclut le layout principal, qui utilise $content
        require $layoutPath;
    }
}