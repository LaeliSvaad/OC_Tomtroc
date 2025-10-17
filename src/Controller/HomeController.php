<?php
declare(strict_types=1);

namespace App\Controller;

use App\Manager\LibraryManager;

final class HomeController extends AbstractController
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
}
