<?php
namespace App\Controller;

use App\Http\Session\SessionStorageInterface;
use App\Manager\BookManager;
use App\Service\BookService;
use App\View\View;
use App\Utils\Utils;

class BookController extends AbstractController
{
    private readonly BookManager $bookManager;
    private BookService $bookService;

    public function __construct(View $view, SessionStorageInterface $session)
    {
        $this->bookManager = new BookManager();
        $this->bookService = new BookService();

        parent::__construct($view, $session);
    }
    public function showBook(int $bookId) : void
    {
        /* Récupère le détail du livre qu'on souhaite afficher, puis génère la vue */
        $book = $this->bookManager->getBook($bookId);
        $this->render($book->getTitle(), "book-details", ['book' => $book]);
    }

    public function editBookForm(int $bookId) : void
    {
        /*Récupère les données du livre qu'on souhaite éditer*/
        $book = $this->bookManager->getBook($bookId);

        /*Génère la vue du formulaire d'édition du livre*/
        $this->render("Editer " . $book->getTitle(),"book-form", ['book' => $book] );
    }

    public function editBook() : void
    {
        /* Traitement via le BookService des données envoyées par l'utilisateur via le formulaire */
        $this->bookService->handleBookEdition();

        /* Retour sur la page mon compte une fois les modifications faites */
        Utils::redirect('mon-compte');
    }

}