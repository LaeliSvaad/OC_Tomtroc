<?php
namespace App\Service;

use App\Http\Request;
use App\Manager\BookManager;
use App\Model\Book;
use App\Utils\UserInput;

class BookService
{
    private BookManager $bookManager;

    public function __construct()
    {
        $this->bookManager = new BookManager();
    }

    /**
     * Edite les informations d'un livre dans la base de données
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function handleBookEdition(Request $request) : Book
    {
        $bookId = $request->post('bookId');
        $bookDescription = $request->post('description');
        $bookTitle = $request->post('title');
        $bookAuthor = $request->post('author');
        $bookAuthorPseudo = $request->post('authorPseudo');
        $bookStatus = $request->post('status');

        var_dump($bookId);
        var_dump($bookDescription);
        var_dump($bookTitle);
        var_dump($bookAuthor);
        var_dump($bookAuthorPseudo);
        var_dump($bookStatus);
    }

}