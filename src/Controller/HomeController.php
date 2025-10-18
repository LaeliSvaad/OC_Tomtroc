<?php
declare(strict_types=1);

namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\Manager\LibraryManager;
use App\View\View;

final class HomeController extends AbstractController
{
    private readonly LibraryManager $libraryManager;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->libraryManager = new LibraryManager();
        parent::__construct($view, $session);
    }
    public function showHomepage(): void
    {
        $library = $this->libraryManager->getHomepageBooks();
        $this->render('Accueil', 'home', ['library' => $library->getLibrary()]);
    }
}
