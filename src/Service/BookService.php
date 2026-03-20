<?php
namespace App\Service;

use App\Config\Config;
use App\Http\Request;
use App\Manager\BookManager;
use App\Utils\UserInput;
use App\Enum\BookStatus;

class BookService
{
    private BookManager $bookManager;
    private Request $request;
    private ImageService $imageService;

    public function __construct()
    {
        $this->bookManager = new BookManager();
        $this->request = new Request();
        $this->imageService = new ImageService();
    }

    /**
     * Edite les informations d'un livre dans la base de données
     *
     * @return void
     * @throws \Exception
     */
    public function handleBookEdition() : void
    {
        /* On stocke dans un tableau les données envoyées par l'utilisateur à l'aide du formulaire, récupérées via l'objet Request */
        $bookRequest["id"]= $this->request->post("bookId");
        $bookRequest["title"] = $this->request->post("title");
        $bookRequest["authorName"] = $this->request->post("authorName");
        $bookRequest["picture"] = $this->request->file("picture");
        $bookRequest["description"] = $this->request->post("description");
        $bookRequest["status"] = $this->request->post("status");

        /* On s'assure de pouvoir traiter la requête en vérifiant la présence de l'id du livre */
        if(!isset($bookRequest["id"]) || $bookRequest["id"] == 0)
        {
            throw new \Exception("Une erreur est survenue lors de l'édition du livre");
        }
        else
        {
            $bookRequest["id"] = (int)UserInput::controlUserInput($this->request->post("bookId"));
            $book = $this->bookManager->getBook($bookRequest["id"]);
            /* On parcourt le tableau: pour chaque entrée, on sécurise les données et on met à jour la base lorsqu'un élément a été modifié */
            foreach ($bookRequest as $key => $value) {

                switch ($key) {
                    case 'title':
                        if ($bookRequest["title"] != null) {
                            $bookRequest["title"] = UserInput::controlUserInput($bookRequest["title"]);
                            if ($bookRequest["title"] != $book->getTitle()) {
                                $modif = $this->bookManager->modifyBookTitle($bookRequest["title"], $bookRequest["id"]);
                                if ($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de l'édition du titre");
                            }
                        }
                        continue 2;

                    case 'authorName':
                        if ($bookRequest["authorName"] != null) {
                            $bookRequest["authorName"] = UserInput::controlUserInput($bookRequest["authorName"]);
                            if ($bookRequest["authorName"] != $book->getAuthor()->getName()) {
                                $modif = $this->bookManager->modifyBookAuthorName($bookRequest["authorName"], $bookRequest["id"]);
                                if ($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de l'édition du nom de l'auteur");
                            }
                        }
                        continue 2;

                    case 'description':
                        if ($bookRequest["description"] != null) {
                            $bookRequest["description"] = UserInput::controlUserInput($bookRequest["description"]);
                            if ($bookRequest["description"] != $book->getDescription()) {
                                $modif = $this->bookManager->modifyBookDescription($bookRequest["description"], $bookRequest["id"]);
                                if ($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la description");
                            }
                        }
                        continue 2;

                    case 'status':
                        if ($bookRequest["status"] != null) {
                            $bookRequest["status"] = BookStatus::tryFrom(UserInput::controlUserInput($bookRequest["status"]) ?? '');
                            if ($bookRequest["status"] != $book->getStatus()) {
                                $modif = $this->bookManager->modifyBookStatus($bookRequest["status"]->value, $bookRequest["id"]);
                                if ($modif == 0)
                                    throw new \Exception("Une erreur est survenue lors de la description");
                            }
                        }
                        continue 2;

                    case 'picture':
                        if ($bookRequest["picture"] != null) {
                            $book_picture = $this->imageService->upload($bookRequest["picture"], Config::get('app.books_pictures_folder'));
                            if($book->getBookPicture() != 'assets/images/books/default-book-picture.png')
                                unlink($book->getBookPicture());
                            $modif = $this->bookManager->modifyBookPicture($book_picture, $bookRequest["id"]);
                            if ($modif == 0)
                                throw new \Exception("Une erreur est survenue lors de la mise à jour de l'image");
                        }
                        break;
                }
            }
        }
    }
}