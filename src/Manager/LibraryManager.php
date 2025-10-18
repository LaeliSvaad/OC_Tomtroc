<?php

namespace App\Manager;
use App\Enum\BookStatus;
use App\Model\Author;
use App\Model\Book;
use App\Model\Library;
use App\Model\User;

/**
 * Classe qui gère la bibliothèque
 */
class LibraryManager extends AbstractEntityManager
{
    public function getHomepageBooks(): ?Library
    {
        $status = BookStatus::AVAILABLE->value;

        $sql = "SELECT
                    `user`.nickname, 
                    `user`.id AS userId,
                    `book`.title,
                    `book_data`.id,
                    `book_data`.picture AS bookPicture, 
                    `author`.firstname, 
                    `author`.lastname
                FROM `library`
                INNER JOIN `user` ON `user`.`id` = `library`.`user_id`
                INNER JOIN `book_data` ON `library`.`book_data_id` = `book_data`.`id`
                INNER JOIN `book` ON `book_data`.`book_id` = `book`.`id`
                INNER JOIN `author` ON `author`.`id` = `book`.`author_id`
                WHERE `book_data`.`status` = :status LIMIT 4";

        $result = $this->db->query($sql, ['status' => $status]);
        $library = new Library();

        foreach ($result as $element) {
            $element["author"] = new Author($element);
            $element["user"] = new User($element);
            $book = new Book($element);
            $library->addBook($book);
        }
        return $library;
    }

    public function getAvailableBooks(): ?Library
    {
        $status = BookStatus::AVAILABLE->value;

        $sql = "SELECT
                `user`.nickname, 
                `user`.id AS userId,
                `book`.title, 
                `book_data`.description, 
                `book_data`.picture AS bookPicture, 
                `book_data`.id,
                `author`.firstname, 
                `author`.lastname, 
                `author`.pseudo
            FROM `library`
            INNER JOIN `user` ON `user`.`id` = `library`.`user_id`
            INNER JOIN `book_data` ON `library`.`book_data_id` = `book_data`.`id`
            INNER JOIN `book` ON `book_data`.`book_id` = `book`.`id`
            INNER JOIN `author` ON `author`.`id` = `book`.`author_id`
            WHERE `book_data`.`status` = :status";

        $result = $this->db->query($sql, ['status' => $status]);
        $library = new Library();
        foreach ($result as $element) {
            $element["author"] = new Author($element);
            $element["user"] = new User($element);
            $book = new Book($element);
            $library->addBook($book);
        }

        return $library;
    }

    public function getBooksByTitle(string $title): ?Library
    {
        $status = BookStatus::AVAILABLE->value;

        $sql = "SELECT
                    `user`.nickname, 
                    `user`.id AS userId,
                    `book`.title, 
                    `book_data`.description, 
                    `book_data`.picture AS bookPicture, 
                    `book_data`.id,
                    `author`.firstname, 
                    `author`.lastname, 
                    `author`.pseudo
                FROM `library`
                INNER JOIN `user` ON `user`.`id` = `library`.`user_id`
                INNER JOIN `book_data` ON `library`.`book_data_id` = `book_data`.`id`
                INNER JOIN `book` ON `book_data`.`book_id` = `book`.`id`
                INNER JOIN `author` ON `author`.`id` = `book`.`author_id`
                WHERE `book_data`.`status` = :status && `book`.`title` LIKE :title";

        $result = $this->db->query($sql, ['status' => $status, 'title' => $title]);
        $library = new Library();

        foreach ($result as $element) {
            $element["author"] = new Author($element);
            $element["user"] = new User($element);

            $book = new Book($element);
            $library->addBook($book);
        }
        return $library;
    }

    public function getLibraryByUserId(int $userId): ?Library
    {
        $sql = "SELECT
                    `book`.title,
                    `book_data`.description, 
                    `book_data`.picture AS bookPicture, 
                    `book_data`.status,
                    `book_data`.id,
                    `author`.firstname, 
                    `author`.lastname, 
                    `author`.pseudo
                FROM `library`
                INNER JOIN `book_data` ON `library`.`book_data_id` = `book_data`.`id`
                INNER JOIN `book` ON `book_data`.`book_id` = `book`.`id`
                INNER JOIN `author` ON `author`.`id` = `book`.`author_id`
                WHERE `library`.`user_id` = :userId";

        $result = $this->db->query($sql, ['userId' => $userId]);
        $library = new Library();

        $db_array = $result->fetchAll();

        if (is_null($db_array)) {
            return null;
        } else {
            foreach ($db_array as $element) {
                $element["author"] = new Author($element);
                $element["user"] = new User($element);
                $book = new Book($element);
                $library->addBook($book);
            }
            return $library;
        }
    }

    public function deleteBook(int $bookId): int
    {
        $sql = "DELETE `library`.*, `book_data`.*  FROM `library`
                INNER JOIN `book_data` ON `library`.`book_data_id` = `book_data`.`id`
                WHERE `library`.`book_data_id` = :id";
        $result = $this->db->query($sql, [
            'id' => $bookId]);
        return $result->rowCount() > 0;
    }

}