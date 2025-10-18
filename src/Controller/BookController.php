<?php
namespace App\Controller;

use App\Manager\BookManager;
use App\Utils\Utils;

class BookController extends AbstractController
{
    private readonly BookManager $bookManager;

    public function __construct()
    {
        $this->bookManager = new BookManager();
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