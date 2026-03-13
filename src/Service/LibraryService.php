<?php
namespace App\Service;

use App\Manager\LibraryManager;
use App\Model\Library;
use App\Http\Request;
use App\Utils\UserInput;

class LibraryService
{
    private LibraryManager $libraryManager;
    private Request $request;

    public function __construct()
    {
        $this->libraryManager = new LibraryManager();
        $this->request = new Request();
    }

    /**
     * Supprime un livre dans la base de données
     *
     * @param Request $request
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
            $modif =  $this->libraryManager->deleteBook($bookId);
            if($modif == 0)
                throw new \Exception("Une erreur est survenue lors de la suppression du livre");
        }
    }

    public function handleBookResearch() : Library
    {
        //var_dump($this->request->post('booksearch'));
        if($this->request->isPost()){
            $booksearch = UserInput::controlUserInput($this->request->post("booksearch"));
            return $this->libraryManager->getBooksByTitle('%'.$booksearch.'%');
        }

    }
}