<?php
declare(strict_types=1);

namespace App\Controller;

use App\Manager\LibraryManager;
use App\View\View;

final class HomeController
{
    public function __construct()
    {

    }

    public function showHomepage(): void
    {
        $libraryManager = new LibraryManager();
        $library = $libraryManager->getHomepageBooks();
        $this->render('Accueil', 'home', ['library' => $library->getLibrary()]);
    }
    private function render(string $title, string $viewName, array $data): void
    {
        $view = new View($title, $viewName);
        $view->render($title, $viewName, $data);
    }
}
