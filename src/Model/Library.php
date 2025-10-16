<?php

/**
 * Entité Bibliothèque
 */

namespace App\Model;

class Library extends AbstractEntity
{
    private array $library = [];


    public function addBook(Book $book): void
    {
        $this->library[] = $book;
    }

    public function getLibrary(): array
    {
        return $this->library;
    }


    public function countBooks(): int
    {
        return count($this->library);
    }
}