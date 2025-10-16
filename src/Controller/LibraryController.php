<?php
namespace App\Controller;

use App\Manager\LibraryManager;
use App\View\View;
class LibraryController
{
    public function showLibrary() : void
    {
        $libraryManager = new LibraryManager();
        $library = $libraryManager->getAvailableBooks();
        $this->render("nos-livres", 'our-books', ['library' => $library->getLibrary()] );
    }

    public function showSearchResults() : void
    {
        $booksearch = Utils::request("booksearch", NULL);
        $booksearch = Utils::controlUserInput($booksearch);

        $libraryManager = new LibraryManager();
        $library = $libraryManager->getBooksByTitle($booksearch);

        $view = new View('nos-livres');
        $view->render("our-books", ['library' => $library->getLibrary()] );
    }

    public function deleteBook() : void
    {
        $libraryManager = new LibraryManager();
        $id = Utils::request('id', '-1');

        if($libraryManager->deleteBook($id) > 0)
            Utils::redirect("user-private-account");
        else
            throw new Exception("Une erreur est survenue lors de la suppression du livre.");

    }
    private function render(string $title, string $viewName, array $data): void
    {
        $view = new View($title, $viewName);
        $view->render($title, $viewName, $data);
    }
}