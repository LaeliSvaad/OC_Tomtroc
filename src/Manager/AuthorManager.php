<?php

/**
 * Classe qui gère les auteurs.
 */

namespace App\Manager;
use App\Model\Author;


class AuthorManager extends AbstractEntityManager
{
    public function addAuthor(Author $author) : int
    {
        $sql = "INSERT INTO `author` (`name`) VALUES (:name)";

        $this->db->query($sql, [
            'name' => $author->getName()
        ]);
        return $this->db->lastInsertId();
    }
}