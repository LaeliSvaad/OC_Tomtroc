<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Manager\BookManager;
use App\Service\BookService;
use App\View\View;

class BookController extends AbstractController
{
    private readonly BookManager $bookManager;
    private BookService $bookService;
    private Request $request;

    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        $this->bookManager = new BookManager();
        $this->bookService = new BookService();
        $this->request = $request;

        parent::__construct($view, $session);
    }
    public function showBook(int $bookId) : void
    {
        $book = $this->bookManager->getBook($bookId);
        $this->render($book->getTitle(), "book-details", ['book' => $book]);
    }

    public function editBookForm(int $bookId) : void
    {
        $book = $this->bookManager->getBook($bookId);
        $this->render("Editer " . $book->getTitle(),"book-form", ['book' => $book] );
    }

    public function editBook() : void
    {
        /* Traitement via le BookService des données envoyées par formulaire et récupération du livre modifié */
        $book = $this->bookService->handleBookEdition($this->request);

        /* Si l'opération a réussi, on renvoie la vue */
        if (!empty($book)) {
            $this->render("Editer " . $book->getTitle(), 'book-form', $book);
        }
    }
}