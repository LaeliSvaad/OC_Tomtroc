<?php
namespace App\Service;

use App\Http\Request;
use App\Manager\BookManager;
use App\Model\Book;
use App\Utils\UserInput;
use App\Enum\BookStatus;

class BookService
{
    private BookManager $bookManager;
    private Request $request;

    public function __construct()
    {
        $this->bookManager = new BookManager();
        $this->request = new Request();
    }

    /**
     * Edite les informations d'un livre dans la base de données
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function handleBookEdition(Request $request) : void
    {

        $bookRequest["id"]= $this->request->post("bookId");
        $bookRequest["title"] = $this->request->post("title");
        $bookRequest["authorName"] = $this->request->post("authorName");
        $bookRequest["picture"] = $this->request->file("picture");
        $bookRequest["description"] = $this->request->post("description");
        $bookRequest["status"] = $this->request->post("status");

        if(!isset($bookRequest["id"]) || $bookRequest["id"] == 0)
            throw new \Exception("Une erreur est survenue lors de l'édition du livre");
        else{
            $bookRequest["id"] = (int)UserInput::controlUserInput($this->request->post("bookId"));
            $bookManager = new BookManager();
            $book = $bookManager->getBook($bookRequest["id"]);
        }

        foreach ($bookRequest as $key => $value) {

            switch ($key) {
                case 'title':
                    if($bookRequest["title"] != null)
                    {
                        $bookRequest["title"] = UserInput::controlUserInput($bookRequest["title"]);
                        if($bookRequest["title"] != $book->getTitle()){
                            $modif = $bookManager->modifyBookTitle($bookRequest["title"], $bookRequest["id"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de l'édition du titre");
                        }
                    }
                    continue 2;

                case 'authorName':
                    if($bookRequest["authorName"] != null)
                    {
                        $bookRequest["authorName"] = UserInput::controlUserInput($bookRequest["authorName"]);
                        if($bookRequest["authorName"] != $book->getAuthor()->getName()){
                            $modif = $bookManager->modifyBookAuthorName($bookRequest["authorName"], $bookRequest["id"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de l'édition du nom de l'auteur");
                        }
                    }
                    continue 2;

                case 'description':
                    if($bookRequest["description"] != null)
                    {
                        $bookRequest["description"] = UserInput::controlUserInput($bookRequest["description"]);
                        if($bookRequest["description"] != $book->getDescription()){
                            $modif = $bookManager->modifyBookDescription($bookRequest["description"], $bookRequest["id"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la description");
                        }
                    }
                    continue 2;

                case 'status':
                    if($bookRequest["status"] != null)
                    {
                        $bookRequest["status"] = BookStatus::tryFrom(UserInput::controlUserInput($bookRequest["status"]) ?? '');
                        if($bookRequest["status"] != $book->getStatus()){
                            $modif = $bookManager->modifyBookStatus($bookRequest["status"]->value, $bookRequest["id"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la description");
                        }
                    }
                    continue 2;

                case 'picture':
                    if($bookRequest["picture"] != null)
                    {
                        $bookRequest["picture"]["name"] = UserInput::controlBookPicture($bookRequest["picture"]["name"]);

                        if(move_uploaded_file($bookRequest["picture"]["tmp_name"], $bookRequest["picture"]["name"]) === false){
                            throw new \Exception("Une erreur est survenue lors de la mise à jour de l'image");
                        }
                        else{
                            $modif = $bookManager->modifyBookPicture($bookRequest["picture"]["name"], $bookRequest["id"]);
                            if($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la mise à jour de l'image");
                        }
                    }
                    break;
            }
        }
        //return $this->bookManager->getBook($bookRequest["id"]);
    }
}