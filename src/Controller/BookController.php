<?php


namespace App\Controller;

use App\Manager\BookManager;
use App\Utils\Utils;

class BookController extends AbstractController
{
    public function showBook(int $id) : void
    {

        $bookManager = new BookManager();
        $book = $bookManager->getBook($id);

        $this->render($book->getTitle(), "book-details", ['book' => $book]);

    }

    public function editBookForm(int $id) : void
    {
        $bookManager = new BookManager();
        $book = $bookManager->getBook($id);
        $this->render("Editer " . $book->getTitle(),"book-form", ['book' => $book] );
    }

    public function editBook() : void
    {
        Utils::Redirect('mon-compte');
    }
}