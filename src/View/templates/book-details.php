<?php
$connectedUserId = $this->session->get('userId') ?? null;
$author = $book->getAuthor();
$user = $book->getUser();
$isOwner = $connectedUserId === $user->getUserId();
$bookPicture = $book->getBookPicture();
$bookTitle = $book->getTitle();
$bookDescription = $book->getDescription();
$userPicture = $user->getPicture();
$userNickname = $user->getNickname();
$userId = $user->getUserId();
?>
<section>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-12 col-sm-6 background-img-col'>
                <img class='background-img' src='<?= \App\Utils\Url::to($bookPicture) ?>' alt='<?= $bookTitle ?>'>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="inner-col">
                    <h2 class="playfair-display-title-font"><?= $bookTitle ?></h2>
                    <span>par <strong><?= $author->getFirstname() ?> <?= $author->getLastname() ?></strong></span>
                    <span>Description</span>
                    <p><?= $bookDescription ?></p>
                    <span>Propriétaire</span>
                    <div>
                        <div>
                            <a href='<?= $isOwner ? \App\Utils\Url::to('/mon-compte')  : \App\Utils\Url::to('/utilisateur/' . $userId) ?>'>
                                <img class="profile-picture large-profile-picture" src='<?= \App\Utils\Url::to($userPicture) ?>' alt='<?= $userNickname ?>'>
                                <span><?= $isOwner ? "Vous" : $userNickname ?></span>
                            </a>
                        </div>
                        <div>
                            <?= !$connectedUserId
                                ? "<span>Créez un compte ou connectez-vous pour lui envoyer un message.</span>"
                                : (!$isOwner
                                    ? "<a class='button-link' href='" . \App\Utils\Url::to('/chat/interlocuteur-' . $userId) . "'><button class='btn green-button'>Envoyer un message</button></a>"
                                    : "") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>