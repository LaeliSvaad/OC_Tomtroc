<?php
/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.
 *
 * Les variables qui doivent impérativement être définie sont :
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page.
 */
$current_page = isset($_GET['action']) ? $_GET['action'] : 'home';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TomTroc - <?= $title ?></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="container-fluid inter-main-font">
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">
                            <div class="my-navbar-brand">
                                <img class="logo" src="pictures/logo_tomtroc.png" alt="logo tomtroc">
                                <span class="title playfair-display-title-font">Tom Troc</span>
                            </div>
                        </a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="nav-link <?php echo ($current_page === 'home') ? 'active' : ''; ?>" href="index.php">Accueil</a>
                        </li>
                        <li>
                            <a class="nav-link <?php echo ($current_page === 'our-books') ? 'active' : ''; ?>" href="/nos-livres">Nos livres</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['user'])): ?>
                            <li>
                                <a class="nav-link <?php echo ($current_page === 'conversation') ? 'active' : ''; ?>" id="chat-nav-link" href="index.php?action=conversation">
                                    <img src="pictures/messaging-icon.png" alt="messaging icon" >
                                    &nbsp;<span>Messagerie</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link <?php echo ($current_page === 'user-private-account' || $current_page === 'book-form') ? 'active' : ''; ?>" href="index.php?action=user-private-account">Mon compte</a>
                            </li>
                            <li>
                                <a class="nav-link <?php echo ($current_page === 'logout') ? 'active' : ''; ?>" href="index.php?action=logout">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a class="nav-link <?php echo ($current_page === 'connexion' || $current_page === 'registration-form') ? 'active' : ''; ?>" href="index.php?action=connexion">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
        </header>

        <main>
            <?= $content ?>
        </main>

        <footer>
            <div class="footer">
                <div class="footer-content"><a href="#">Politique de confidentialité</a></div>
                <div class="footer-content"><a href="#">Mentions légales</a></div>
                <div class="footer-content"><a href="#">Tom Troc©</a></div>
                <div class="footer-content"><img src="pictures/logo_tomtroc_green.png"></div>
            </div>
        </footer>
    </div>
    <script src="scripts/script.js"></script>
</body>
</html>