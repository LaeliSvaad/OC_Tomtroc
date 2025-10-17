<div class="main-content container-fluid">
    <a class="back-link" href="index.php?action=user-private-account">&larr; Retour</a>
    <h2 class="playfair-display-title-font">Modifier les informations</h2>
    <div class="row admin-row">
        <div class="col-sm-6">
            <form action="<?= \App\Utils\Url::to('editer-livre') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                <label for="imageUpload">
                    <div class="block-content">
                        <span>Photo</span>
                        <img class='book-form-img' src='<?= \App\Utils\Url::to($book->getBookPicture()) ?>' alt='<?= $book->getTitle() ?>'>
                        <span class="input-file-span">Modifier la photo</span>
                    </div>
                </label>
                <input type="file" name="picture" id="imageUpload" onchange="document.getElementById('uploadForm').submit();">
            </form>
        </div>
        <div class="col-sm-6">
            <form class="form-horizontal admin-form" method='post' action='<?= \App\Utils\Url::to('editer-livre') ?>'>
                <div class='form-group'>
                   <label class='control-label' for='input-title' >Titre </label>
                    <input class='form-control input-lg blue-input' type='text' id='input-title' name='title' value='<?= $book->getTitle() ?>'/>
                    <input type='hidden' name='bookId' value='<?= $book->getId() ?>'/>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-author' >Auteur </label>
                    <input class='form-control input-lg blue-input' type='text' id='input-author' name='author' value='<?= $book->getAuthor()->getFirstname() . " " . $book->getAuthor()->getLastname() ?>'/>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-authorPseudo' >Pseudo de l'auteur: </label>
                    <input class='form-control input-lg blue-input' type='text' id='input-authorPseudo' name='authorPseudo' value='<?= $book->getAuthor()->getPseudo() ?>'/>
                    <input type='hidden' name='authorId' value='<?= $book->getAuthor()->getAuthorId() ?>'/>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-description' >Commentaire </label>
                    <textarea id='input-description' class='form-control input-lg blue-input' name='description'><?= $book->getDescription() ?></textarea>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-disponibilite' >Disponibilité </label>
                    <select class='form-control input-lg blue-input' name='disponibilite' id='input-disponibilite'>
                        <?php foreach (App\enum\BookStatus::cases() as $status) : ?>
                        <option value="<?= $status->value ?>"><?= $status->getLabel() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class='form-group'>
                <input class='btn green-button' type='submit' value='Valider' />
                </div>
            </form>
        </div>
    </div>
</div>
