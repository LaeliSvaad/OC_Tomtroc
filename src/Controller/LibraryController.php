<?php
namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\Manager\LibraryManager;
use App\Service\LibraryService;
use App\Utils\Utils;
use App\View\View;

class LibraryController extends AbstractController
{
    private readonly LibraryManager $libraryManager;
    private LibraryService $libraryService;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->libraryManager = new LibraryManager();
        $this->libraryService = new LibraryService();
        parent::__construct($view, $session);
    }
    public function showLibrary() : void
    {
        $library = $this->libraryManager->getAvailableBooks();
        $this->render("nos-livres", 'our-books', ['library' => $library->getLibrary()] );
    }

    public function addBookForm() : void
    {
        $this->render("Ajouter un livre ","add-book");
    }

    public function addBook() : void
    {
        $this->libraryService->handleAddBook();
        Utils::redirect('mon-compte');
    }
    public function showSearchResults() : void
    {
        $library = $this->libraryService->handleBookResearch();
        $this->render("nos-livres", 'our-books', ['library' => $library->getLibrary()] );

    }

    public function deleteBook(int $bookId) : void
    {
        $this->libraryService->handleBookSuppression($bookId);
        Utils::redirect('mon-compte');
    }
}