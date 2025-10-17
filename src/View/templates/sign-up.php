<div class="container-fluid log-container">
    <div class="row row-flex">
        <div class="col-xs-12 col-sm-6 col-flex">
           <div class="inner-col">
               <h2 class="playfair-display-title-font">Inscription</h2>
               <form class="form-horizontal" method="post" action="<?= \App\Utils\Url::to('inscription') ?>">
                   <div class='form-group'>
                       <label class='control-label' for="input-pseudo">Pseudo </label>
                       <input class="form-control input-lg white-input" type="text" name="nickname" id="input-pseudo">
                   </div>
                   <div class='form-group'>
                       <label class='control-label' for="input-email">Adresse email </label>
                       <input class="form-control input-lg white-input" type="email" name="email" id="input-email">
                   </div>
                   <div class='form-group'>
                       <label class='control-label' for="input-pwd">Mot de passe </label>
                       <input class="form-control input-lg white-input" type="password" name="password" id="input-pwd">
                   </div>
                   <div class='form-group'>
                       <input class="btn green-button" type="submit" value="S'inscrire">
                   </div>
               </form>
               <span class="link-span">Déjà inscrit? <a href="<?= \App\Utils\Url::to('formulaire-connexion') ?>" >Connectez-vous</a></span>
           </div>
        </div>
        <div class="col-xs-12 col-sm-6 background-img-col">
            <img class="background-img" src="<?= \App\Utils\Url::to('assets/images/library.png') ?>" alt="bibliothèque" >
        </div>
    </div>
</div>


