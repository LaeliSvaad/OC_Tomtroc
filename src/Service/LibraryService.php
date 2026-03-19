<?php
namespace App\Service;

use App\Manager\LibraryManager;
use App\Manager\BookManager;
use App\Manager\AuthorManager;
use App\Model\Author;
use App\Model\Library;
use App\Model\Book;
use App\Model\User;
use App\Http\Request;
use App\Utils\UserInput;

class LibraryService
{
    private LibraryManager $libraryManager;
    private BookManager $bookManager;
    private AuthorManager $authorManager;
    private Request $request;

    public function __construct()
    {
        $this->libraryManager = new LibraryManager();
        $this->bookManager = new BookManager();
        $this->authorManager = new AuthorManager();
        $this->request = new Request();
    }

    /**
     * Supprime un livre de la base de données
     * Supprime l'image associée au livre du dossier images/books
     *
     * @param int $bookId
     * @return void
     * @throws \Exception
     */

    public function handleBookSuppression(int $bookId) : void
    {
        if(!isset($bookId) || $bookId == 0)
            throw new \Exception("Une erreur est survenue lors de la suppression du livre");
        else
        {
            $bookId = (int)UserInput::controlUserInput($bookId);
            $bookPicture = $this->bookManager->getBookPicture($bookId);;
            if($bookPicture != 'assets/images/books/default-book-picture.png')
                unlink($bookPicture);
            $modif =  $this->libraryManager->deleteBook($bookId);
            if($modif == 0)
                throw new \Exception("Une erreur est survenue lors de la suppression du livre");
        }
    }

    /**
     * Recherche, dans la base de données,
     * les livres dont le titre contient la chaîne de caractères
     * entrée par l'utilisateur
     *
     * @return Library
     * @throws \Exception
     */
    public function handleBookResearch() : ?Library
    {
        if($this->request->isPost())
        {
            $booksearch = UserInput::controlUserInput($this->request->post("booksearch"));
            return $this->libraryManager->getBooksByTitle('%'.$booksearch.'%');
        }
        return null;
    }

    public function handleBookChecking(string $query) : ?Library
    {
        if(!is_null($query))
        {
            $bookchecking = UserInput::controlUserInput($query);
            return $this->libraryManager->checkExistingBooks('%'.$bookchecking.'%');
        }
        return null;
    }
    public function handleAuthorsChecking(string $query) : ?Array
    {
        if(!is_null($query))
        {
            $authorchecking = UserInput::controlUserInput($query);
            return $this->libraryManager->checkExistingAuthors('%'.$authorchecking.'%');
        }
        return null;
    }

    /**
     * Ajoute un livre dans la base de données
     *
     * @return void
     * @throws \Exception
     */
    public function handleAddBook() : void
    {
        if($this->request->isPost())
        {
            $bookRequest["title"] = UserInput::controlUserInput($this->request->post("title"));
            $bookRequest["id"] = (int)UserInput::controlUserInput($this->request->post("bookId"));
            $bookRequest["name"] = UserInput::controlUserInput($this->request->post("authorName"));
            $bookRequest["authorId"] = (int)UserInput::controlUserInput($this->request->post("authorId"));
            $bookRequest["bookPicture"] = UserInput::controlBookPicture($this->request->file("picture")['name']);
            $bookRequest["description"] = UserInput::controlUserInput($this->request->post("description"));
            $bookRequest["status"] = UserInput::controlUserInput($this->request->post("status"));
            $bookRequest["userId"] = UserInput::controlUserInput($this->request->post("userId"));

            $bookRequest["author"] = new Author($bookRequest);
            $bookRequest["user"] = new User($bookRequest);
            $book = new Book($bookRequest);

            if(!$book->getId() && !$book->getAuthor()->getAuthorId())
            {
                $book->getAuthor()->setAuthorId($this->authorManager->addAuthor($book->getAuthor()));
                $book->setId($this->libraryManager->addNewBook($book));
            }
            if ($bookRequest["bookPicture"] != null) {
                if (move_uploaded_file($this->request->file("picture")["tmp_name"], $book->getBookPicture()) === false) {
                    $book->setBookPicture("assets/images/books/default-book-picture.png");
                    throw new \Exception("Une erreur est survenue lors de la mise à jour de l'image");
                }
            }
            $this->libraryManager->addBookData($book);
        }
    }
}