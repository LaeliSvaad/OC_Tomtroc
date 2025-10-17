<?php


namespace App\Controller;

use App\Manager\BookManager;

class BookController extends AbstractController
{
    public function showBook(int $id) : void
    {

        $bookManager = new BookManager();
        $book = $bookManager->getBook($id);

        $this->render($book->getTitle(), "book-details", ['book' => $book]);

    }

    public function bookForm() : void
    {
        $id = Utils::request("id", -1);

        $bookManager = new BookManager();
        $book = $bookManager->getBook($id);

        $view = new View('book-form');
        $view->render("book-form", ['book' => $book]);
    }

    public function editBook() : void
    {

    }
}