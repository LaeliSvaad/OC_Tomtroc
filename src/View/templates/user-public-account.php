<?php
    $library = $user->getLibrary()->getLibrary();
?>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <div class="profile-picture">
                    <img class="profile-picture large-profile-picture" src="<?= \App\Utils\Url::to($user->getPicture()) ?>" alt="<?= $user->getNickname() ?> profile picture" />
                </div>
                <div>
                    <img src="<?= \App\Utils\Url::to('assets/images/separator.png') ?>" alt="separator">
                </div>
                <div class="content-block">
                    <h3 class="playfair-display-title-font"><?= $user->getNickname() ?></h3>
                    <div><span class="grey-text">Membre depuis <?= \App\Utils\Utils::dateInterval($user->getRegistrationDate()) ?></span></div>
                    <div><span class="uppercase-text">Bibliothèque</span></div>
                    <div><img src="<?= \App\Utils\Url::to('assets/images/library-icon.png') ?>" alt="library icon">&nbsp;<span><?= $user->getLibrary()->countBooks() ?> livres</span></div>
                    <?php if (!is_null($this->session->get('userId'))): ?>
                        <a href="<?= \App\Utils\Url::to('chat/interlocuteur-' . $user->getUserId()) ?>" class="button-link">
                            <button class="btn transparent-button">Écrire un message</button>
                        </a>
                    <?php else: ?>
                        Connectez-vous pour lui écrire
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
                <?php if($user->getLibrary()->countBooks() != 0){ ?>
                <div class="row">
                    <table class="books-table">
                        <tbody>
                        <tr class="uppercase-text"><th>Photo</th><th>Titre</th><th>Auteur</th><th>Description</th></tr>
                        <?php foreach ($library as $book):
                            $author = $book->getAuthor(); ?>
                            <tr>
                                <td><div class="cell-fixed"><img class='table-book-img' src='<?= \App\Utils\Url::to($book->getBookPicture()) ?>' alt='<?= $book->getTitle()?>'></div></td>
                                <td><div class="cell-fixed"><?= $book->getTitle() ?></div></td>
                                <td><div class="cell-fixed"><?= $author->getFirstname() . " " . $author->getLastname() ?></div></td>
                                <td><div class="italic cell-fixed"><?= $book->getDescription()?></div></td>
                            </tr>
                        <?php endforeach;  ?>
                        </tbody>
                    </table>
                    <?php }?>
            </div>
        </div>
    </div>
</section>


