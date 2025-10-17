<?php
declare(strict_types=1);

namespace App\Controller;

use App\Manager\LibraryManager;

final class HomeController extends AbstractController
{
    private readonly LibraryManager $libraryManager;

    public function __construct()
    {
        $this->libraryManager = new LibraryManager();
    }
    public function showHomepage(): void
    {
        $library = $this->libraryManager->getHomepageBooks();
        $this->render('Accueil', 'home', ['library' => $library->getLibrary()]);
    }
}
