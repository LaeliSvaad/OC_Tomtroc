<?php
/**
 * Classe qui gère le détail des livres.
 */

namespace App\Manager;

use App\Model\Author;
use App\Model\Book;
use App\Model\User;
use App\Enum\BookStatus;

class BookManager extends AbstractEntityManager
{

    public function getBook(int $id) : ?Book
    {
        $sql = "SELECT book.`title`,
                book_data.`description`, book_data.`status`, book_data.`picture` AS bookPicture, book_data.`id`,
                author.`name`, author.id AS authorId, 
                user.`nickname`, user.`picture`, user.`email`, user.`id` AS userId
                FROM book 
                INNER JOIN book_data ON book.`id` = book_data.book_id 
                INNER JOIN author ON book.`author_id` = author.id 
                INNER JOIN library ON book_data.`id` = library.book_data_id
                INNER JOIN user ON library.`user_id` = user.id
                WHERE book_data.`id` = :id";

        $result = $this->db->query($sql, ['id' => $id]);

        $db_array = $result->fetch();

        if ($db_array) {
            $db_array["author"] = new Author($db_array);
            $db_array["user"] = new User($db_array);
            return new Book($db_array);
        }
        return null;
    }

    public function modifyBookTitle(string $title, int $id) : ?int
    {
        $sql = "UPDATE `book` 
                JOIN `book_data` ON `book`.`id` = `book_data`.`book_id`
                SET `book`.`title` = :title
                WHERE `book_data`.`id` = :id";
        $result = $this->db->query($sql, [
            'title' => $title,
            'id' => $id
        ]);
        return $result->rowCount() > 0;
    }

    public function modifyBookAuthorName(string $name, int $id) : ?int
    {
        $sql = "UPDATE `author` 
                JOIN `book` ON `author`.`id` = `book`.`author_id`
                JOIN `book_data` ON `book`.`id` = `book_data`.`book_id`
                SET `author`.`name` = :name
                WHERE `book_data`.`id` = :id";
        $result = $this->db->query($sql, [
            'name' => $name,
            'id' => $id
        ]);
        return $result->rowCount() > 0;
    }

    public function modifyBookDescription(string $description, int $id) : ?int
    {
        $sql = "UPDATE `book_data` 
                SET `book_data`.`description` = :description
                WHERE `book_data`.`id` = :id";
        $result = $this->db->query($sql, [
            'description' => $description,
            'id' => $id
        ]);
        return $result->rowCount() > 0;
    }

    public function modifyBookStatus(string $status, int $id) : ?int
    {
        $sql = "UPDATE `book_data` 
                SET `book_data`.`status` = :status
                WHERE `book_data`.`id` = :id";
        $result = $this->db->query($sql, [
            'status' => $status,
            'id' => $id
        ]);
        return $result->rowCount() > 0;
    }

    public function modifyBookPicture(string $picture, int $id) : ?int
    {
        $sql = "UPDATE `book_data` 
                SET `book_data`.`picture` = :picture
                WHERE `book_data`.`id` = :id";
        $result = $this->db->query($sql, [
            'picture' => $picture,
            'id' => $id
        ]);
        return $result->rowCount() > 0;
    }
}