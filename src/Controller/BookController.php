<?php


class BookController
{
    public function showBook() : void
    {
        $id = Utils::request("id", -1);

        $bookManager = new BookManager();
        $book = $bookManager->getBook($id);

        $view = new View('book-details');
        $view->render("book-details", ['book' => $book]);
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