<div class="main-content container-fluid">
    <a class="back-link" href="/mon-compte">&larr; Retour</a>
    <h2 class="playfair-display-title-font">Ajouter un livre</h2>
    <div class="row admin-row">
        <div class="col-sm-6">
            <form action="<?= \App\Utils\Url::to('ajouter-livre') ?>" method="post" enctype="multipart/form-data">
                <label for="imageUpload">
                    <div class="block-content">
                        <span>Photo</span>
                        <img id="imgPreview" class='book-form-img' src='<?= \App\Utils\Url::to('assets/images/books/default-book-picture.png') ?>' alt='default-book-picture.png'>
                        <span class="input-file-span">Modifier la photo</span>
                    </div>
                </label>
                <input type="file" name="picture" id="imageUpload" >
        </div>
        <div class="col-sm-6">
                <div class='form-group'>
                    <label class='control-label' for='input-title'>Titre </label>
                    <input class='form-control input-lg blue-input' type='text' id='input-title' name='title' value='' autocomplete="off"/>
                    <div class="title-container"><ul id="title-results" class="dropdown"></ul></div>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-author' >Auteur </label>
                    <input class='form-control input-lg blue-input' type='text' id='input-author' name='authorName' value='' autocomplete="off"/>
                    <div class="author-container"><ul id="author-results" class="dropdown"></ul></div>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-description' >Commentaire </label>
                    <textarea id='input-description' class='form-control input-lg blue-input' name='description'></textarea>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='input-disponibilite' >Disponibilité </label>
                    <select class='form-control input-lg blue-input' name='status' id='input-disponibilite'>
                        <?php foreach (App\enum\BookStatus::cases() as $status) : ?>
                            <option <?= ($status->value === 'not-available') ? 'selected' : '' ?> value="<?= $status->value ?>">
                                <?= $status->getLabel() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="hidden-form-group">
                    <input type="hidden" value="" id="input-book-id" name="bookId">
                    <input type="hidden" value="" id="input-author-id" name="authorId">
                    <input type="hidden" value="<?= $this->session->get("userId") ?>" name="userId">
                </div>
                <div class='form-group'>
                    <input class='btn green-button' type='submit' value='Valider' />
                </div>
            </form>
        </div>
    </div>
</div>
