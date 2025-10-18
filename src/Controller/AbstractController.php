<?php
declare(strict_types=1);

namespace App\Controller;

use App\View\View;
use App\Http\Session\SessionStorageInterface;

abstract class AbstractController
{
    protected View $view;
    protected SessionStorageInterface $session;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    protected function render(string $title, string $viewName, array $data = []): void
    {
        $shared = [
            'session' => $this->session,
            'current_page' => $viewName,
        ];

        // utilise l'instance View injectée (NE PAS instancier une nouvelle View ici)
        $this->view->render($title, $viewName, array_merge($shared, $data));
    }
}


