<?php
declare(strict_types=1);

namespace App\View;

use App\Http\Session\SessionStorageInterface;

final class View
{
    private ?SessionStorageInterface $session;
    private string $layout;
    private string $title;

    public function __construct(?SessionStorageInterface $session = null, string $layout = 'layout')
    {
        $this->session = $session;
        $this->layout = $layout;
        $this->title = '';
    }

    public function render(string $title, string $viewName, array $params = []): void
    {
        $this->title = $title;

        $shared = [
            'session' => $this->session,
            'current_page' => $viewName,
        ];

        extract(array_merge($shared, $params), EXTR_SKIP);

        // chemin du template principal
        $file = __DIR__ . "/templates/{$viewName}.php";

        if (!file_exists($file)) {
            throw new \RuntimeException("Template introuvable : {$file}");
        }

        // capture du contenu principal dans $content
        ob_start();
        require $file;
        $content = ob_get_clean();

        // inclure le layout (qui utilisera $content)
        require __DIR__ . "/templates/{$this->layout}.php";
    }
}