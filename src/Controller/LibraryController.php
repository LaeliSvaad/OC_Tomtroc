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

    public function checkExistingBooks() {

        $input = json_decode(file_get_contents('php://input'), true);

        $query = $input['query'] ?? '';

        $library = $this->libraryService->handleBookChecking($query);
        $results = array();
        $n = 0;
        foreach ($library->getLibrary() as $book) {
            $results[$n]["title"] = $book->getTitle();
            $results[$n]["bookId"] = $book->getId();
            $results[$n]["author"] = $book->getAuthor()->getName();
            $results[$n]["authorId"] = $book->getAuthor()->getAuthorId();
            ++$n;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'results' => array_values($results)
        ]);
        exit;
    }

    public function checkExistingAuthors() {

        $input = json_decode(file_get_contents('php://input'), true);

        $query = $input['query'] ?? '';
        $authors = $this->libraryService->handleAuthorsChecking($query);
        $results = array();

        $n = 0;
        foreach ($authors as $author) {
            $results[$n]["author"] = $author->getName();
            $results[$n]["authorId"] = $author->getAuthorId();
            ++$n;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'results' => array_values($results)
        ]);
        exit;
    }
}