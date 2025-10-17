<?php var_dump($user); $library = $user->getLibrary()->getLibrary(); ?>
<div class="main-content container-fluid">
    <h2 class="playfair-display-title-font">Mon compte</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="inner-col white-block">
                <div>
                    <form action="index.php?action=modify-user" method="post" enctype="multipart/form-data" id="uploadForm">
                        <label for="imageUpload">
                            <div class="block-content user-picture-input-div">
                                <img class="profile-picture large-profile-picture" src="<?= $user->getPicture() ?>" alt="<?= $user->getNickname() ?> profile picture" />
                                <span class="grey-text input-file-span">Modifier</span>
                            </div>
                        </label>
                        <input type="hidden" name="userId" value="<?= $user->getUserId() ?>" >
                        <input type="file" name="picture" id="imageUpload" onchange="document.getElementById('uploadForm').submit();">
                    </form>
                </div>
                <div>
                    <img src="pictures/separator.png" alt="separator">
                </div>
                <div>
                    <h3 class="playfair-display-title-font"><?= $user->getNickname() ?></h3>
                    <div><span class="grey-text">Membre depuis <?= Utils::dateInterval($user->getRegistrationDate()) ?></span></div>
                    <div><span class="uppercase-text">Bibliothèque</span></div>
                    <div><img src="pictures/library-icon.png" alt="library icon">&nbsp;<span><?= $user->getLibrary()->countBooks() ?> livres</span></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="inner-col white-block">
                <span class="span-small-title">Vos informations personnelles</span>
                <form class="form-horizontal" method='post' action='index.php?action=modify-user'>
                    <input type="hidden" name="userId" value="<?= $user->getUserId() ?>"/>
                    <div class='form-group'>
                        <label class='control-label' for="input-email" >Adresse email</label>
                        <input class="form-control input-lg blue-input" type="email" id="input-email" name='email' value="<?= $user->getEmail() ?>"/>
                    </div>
                    <div class='form-group'>
                        <label class='control-label' for="input-pwd" >Mot de passe</label>
                        <input class="form-control input-lg blue-input" type="password" id="input-pwd" name="password" value="" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"/>
                    </div>
                    <div class='form-group'>
                        <label class='control-label' for="input-nickname" >Pseudo</label>
                        <input class="form-control input-lg blue-input" type="text" id="input-nickname" name='nickname' value="<?= $user->getNickname() ?>" />
                    </div>
                    <div class='form-group'>
                        <input class="btn transparent-button" type="submit" value="Enregistrer" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if($user->getLibrary()  ->countBooks() != 0){ ?>
    <div class="row">
        <table class="books-table">
            <tbody>
            <tr class="uppercase-text"><th>Photo</th><th>Titre</th><th>Auteur</th><th>Description</th><th>Disponibilité</th><th>Action</th></tr>
            <?php foreach ($library as $book):
                $author = $book->getAuthor();
                $status = $book->getStatus(); ?>
                <tr>
                    <td><div class="cell-fixed"><img class='table-book-img' src='<?= $book->getBookPicture() ?>' alt='<?= $book->getTitle()?>'></div></td>
                    <td><div class="cell-fixed"><?= $book->getTitle() ?></div></td>
                    <td><div class="cell-fixed"><?= $author->getFirstname() . " " . $author->getLastname() ?></div></td>
                    <td><div class="italic cell-fixed"><?= $book->getDescription()?></div></td>
                    <td><div class="book-status cell-fixed"><span class="<?= $status->value ?>"></span></div></td>
                    <td><div class="book-action-links cell-fixed"><a href='index.php?action=book-form&id=<?= $book->getId() ?>' >Editer</a><a href='index.php?action=delete-book&id=<?= $book->getId() ?>' >Supprimer</a></div></td>
                </tr>
            <?php endforeach;  ?>
            </tbody>
        </table>
        <?php }?>
    </div>
</div>

