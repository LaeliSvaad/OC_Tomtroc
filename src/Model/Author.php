<?php

/**
 * Entité Author
 */
namespace App\Model;
class Author extends AbstractEntity
{
    private string $firstname;
    private string $lastname;
    private ?string $pseudo;
    private int $authorId;

    public function setFirstname(string $firstname) : void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname) : void
    {
        $this->lastname = $lastname;
    }
    public function setPseudo(?string $pseudo) : void
    {
        $this->pseudo = $pseudo;
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function getLastname() : string
    {
        return $this->lastname;
    }

    public function getPseudo() : ?string
    {
        return $this->pseudo;
    }

    public function getAuthorId() : int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $id) : void
    {
        $this->authorId = $id;
    }
}