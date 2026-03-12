<?php

/**
 * Entité Author
 */
namespace App\Model;
class Author extends AbstractEntity
{
    private string $name;
    private int $authorId;

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
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