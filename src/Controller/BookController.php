<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Session\SessionStorageInterface;
use App\Manager\BookManager;
use App\Model\Book;
use App\Service\BookService;
use App\View\View;
use App\Utils\Utils;

class BookController extends AbstractController
{
    private readonly BookManager $bookManager;
    private BookService $bookService;
    private Request $request;

    public function __construct(View $view, SessionStorageInterface $session, Request $request)
    {
        $this->bookManager = new BookManager();
        $this->bookService = new BookService();
        $this->request = $request;

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

    public function addBookForm():void
    {
        $this->render("Ajouter un livre ","add-book");
    }

    public function editBook() : void
    {
        /* Traitement via le BookService des données envoyées par l'utilisateur via le formulaire */
        $this->bookService->handleBookEdition($this->request);

        /* Retour sur la page mon compte une fois les modifications faites */
        Utils::redirect('mon-compte');
    }

}