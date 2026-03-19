<?php

/**
 * Entité User
 */
namespace App\Model;
class User extends AbstractEntity
{
    private ?string $nickname;
    private ?string $email;
    private ?string $password;
    private ?string $profilePicture;
    private ?\DateTime $registrationDate = null;
    private ?Library $library;
    private ?Chat $chat;
    private int $userId;


    public function setUserId(int $id) : void
    {
        $this->userId = $id;
    }

   public function setLibrary(?Library $library) : void
    {
        $this->library = $library;
    }

    public function getLibrary() : ?Library
    {
        return $this->library;
    }

    public function setChat(?Chat $chat) : void
    {
        $this->chat = $chat;
    }

    public function getChat() : ?Chat
    {
        return $this->chat;
    }

    public function setNickname(?string $nickname) : void
    {
        $this->nickname = $nickname;
    }

    public function setProfilePicture(?string $picture) : void
    {
        $this->profilePicture = $picture;
    }

    public function setEmail(?string $email) : void
    {
        $this->email = $email;
    }
    public function setPassword(?string $password) : void
    {
        $this->password = $password;
    }

    public function getUserId() : ?int
    {
        return $this->userId;
    }

    public function getNickname() : ?string
    {
        return $this->nickname;
    }

    public function getProfilePicture() : ?string
    {
        return $this->profilePicture;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function getRegistrationDate() : ?\DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTime $registrationDate) : void
    {
        $this->registrationDate = $registrationDate;
    }

}