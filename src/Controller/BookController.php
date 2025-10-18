<?php
namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\Manager\BookManager;
use App\Utils\Utils;
use App\View\View;

class BookController extends AbstractController
{
    private readonly BookManager $bookManager;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->bookManager = new BookManager();
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

    public function editBook(int $bookId) : void
    {
        $book = $this->bookManager->getBook($bookId);
        Utils::Redirect('mon-compte');
    }
}