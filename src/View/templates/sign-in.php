<div class="container-fluid log-container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-flex">
            <div class="inner-col">
                <h2 class="playfair-display-title-font">Connexion</h2>
                <form class="form-horizontal" method="post" action="index.php?action=sign-in" >
                    <div class='form-group'>
                        <label class='control-label' for="pseudo">Pseudo </label>
                        <input class="form-control input-lg white-input" type="text" name="nickname" id="pseudo">
                    </div>
                    <div class='form-group'>
                        <label class='control-label' for="email">Adresse email </label>
                        <input class="form-control input-lg white-input" type="email" name="email" id="mail">
                    </div>
                    <div class='form-group'>
                        <label class='control-label' for="pwd">Mot de passe </label>
                        <input class="form-control input-lg white-input" type="password" name="password" id="pwd">
                    </div>
                    <div class='form-group'>
                        <input class="btn green-button" type="submit" value="Se connecter">
                    </div>
                </form>
                <span class="link-span">Pas encore inscrit? <a href="index.php?action=registration-form" >Créer un compte</a></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 background-img-col">
            <img class="background-img" src="pictures/library.png" alt="bibliothèque" >
        </div>
    </div>
</div>