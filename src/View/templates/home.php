<section>
    <div class="container-fluid intro-container">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="inner-col">
                    <strong class="span-title playfair-display-title-font">Rejoignez nos lecteurs passionnés</strong>
                    <p class="intro-content">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
                    <a class="button-link" href="<?= \App\Utils\Url::to('/nos-livres') ?>" ><button class="btn green-button">Découvrir</button></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <figure>
                    <img class="intro-img" src="assets/images/hamza-nouasria.png" alt="photo d'Hamza Nouasria">
                    <figcaption>Hamza</figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid intro-container library">
        <div class="row">
            <div class="col-xs-12">
                <span class="span-title playfair-display-title-font">Les derniers livres ajoutés</span>
            </div>
        </div>
        <div class="row">
            <?php foreach ($library as $book): ?>
                <div class='col-xs-6 col-sm-3'>
                    <div class='inner-col book-card'>
                        <a href='<?= \App\Utils\Url::to('/nos-livres/' . $book->getId()) ?>'>
                            <div class='book-img'>
                                <img src='<?= $book->getBookPicture() ?>' alt='<?= $book->getTitle() ?>'>
                            </div>
                            <div class='book-info'>
                                <h3><?= $book->getTitle() ?></h3>
                                <span><?= $book->getAuthor()->getFirstname() . " " . $book->getAuthor()->getLastname()?></span>
                                <span class='italic'>Vendu par:<?= $book->getUser()->getNickname() ?></span>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach;  ?>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a class="button-link" href="<?= \App\Utils\Url::to('/nos-livres') ?>" >
                    <button class="btn green-button">Voir tous les livres</button>
                </a>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid intro-container">
        <div class="row">
            <div class="col-xs-12">
                <span class="span-title playfair-display-title-font">Comment ça marche ?</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="inner-col">
                    <span>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</span>
                    <div>
                        <div>Inscrivez-vous gratuitement sur notre plateforme.</div>
                        <div >Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
                        <div>Parcourez les livres disponibles chez d'autres membres.</div>
                        <div>Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
                    </div>
                    <a class="button-link" href="<?= \App\Utils\Url::to('/nos-livres') ?>" ><button class="btn transparent-button">Voir tous les livres</button></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid intro-row">
        <div class="row background-img-container"><img class="background-img" src="assets/images/banner.png" alt="banner"></div>
        <div class="row">
            <div class="col-xs-12">
                <span class="span-title playfair-display-title-font">Nos valeurs</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
                <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
                <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
                <div class="signature"><span>L’équipe Tom Troc</span><img src="assets/imagesheart_signature.svg" alt="heart signature"></div>
            </div>
        </div>
    </div>
</section>




