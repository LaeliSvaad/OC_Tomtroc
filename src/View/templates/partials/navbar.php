<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                <div class="my-navbar-brand">
                    <img class="logo" src="assets/images/logo_tomtroc.png" alt="logo tomtroc">
                    <span class="title playfair-display-title-font">Tom Troc</span>
                </div>
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li>
                <a class="nav-link <?php echo ($current_page === 'home') ? 'active' : ''; ?>" href="/">Accueil</a>
            </li>
            <li>
                <a class="nav-link <?php echo ($current_page === 'our-books') ? 'active' : ''; ?>" href="<?= \App\Utils\Url::to('/nos-livres') ?>">Nos livres</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['user'])): ?>
                <li>
                    <a class="nav-link <?php echo ($current_page === 'conversation') ? 'active' : ''; ?>" id="chat-nav-link" href="<?= \App\Utils\Url::to('/chat') ?>">
                        <img src="assets/images/messaging-icon.png" alt="messaging icon" >
                        &nbsp;<span>Messagerie</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link <?php echo ($current_page === 'user-private-account' || $current_page === 'book-form') ? 'active' : ''; ?>" href="<?= \App\Utils\Url::to('mon-compte') ?>">Mon compte</a>
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
</nav>
</header>