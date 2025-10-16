<?php

/**
 * Entité Book
 */
namespace App\Model;
class Book extends AbstractEntity
{
    private string $title;
    private string $description;
    private string $bookPicture;
    private BookStatus $status;
    private Author $author;
    private User $user;

    protected int $id;


    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setStatus(BookStatus $status) : void
    {
        $this->status = $status;
    }

    public function getStatus() : BookStatus
    {
        return $this->status;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setBookPicture(string $picture) : void
    {
        $this->bookPicture = $picture;
    }

    public function setAuthor(Author $author) : void
    {
        $this->author = $author;
    }

    public function getAuthor() : Author
    {
        return $this->author;
    }

    public function setUser(User $user) : void
    {
        $this->user = $user;
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function getBookPicture() : ?string
    {
        return $this->bookPicture;
    }

}