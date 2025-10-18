<?php
namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\Manager\LibraryManager;
use App\View\View;

class LibraryController extends AbstractController
{
    private readonly LibraryManager $libraryManager;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->libraryManager = new LibraryManager();
        parent::__construct($view, $session);
    }
    public function showLibrary() : void
    {
        $library = $this->libraryManager->getAvailableBooks();
        $this->render("nos-livres", 'our-books', ['library' => $library->getLibrary()] );
    }

    public function showSearchResults() : void
    {
        $booksearch = Utils::request("booksearch", NULL);
        $booksearch = Utils::controlUserInput($booksearch);

        $library = $this->libraryManager>getBooksByTitle($booksearch);

        $this->render("nos-livres", 'our-books', ['library' => $library->getLibrary()] );

    }

    public function deleteBook() : void
    {
        $id = Utils::request('id', '-1');

        if($this->libraryManager->deleteBook($id) > 0)
            Utils::redirect("user-private-account");
        else
            throw new \Exception("Une erreur est survenue lors de la suppression du livre.");

    }
}