<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Könyvesbolt</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="szerzo.php">Szerző</a>
                </li>
                <li>
                    <a href="kiado.php">Kiadó</a>
                </li>
                <li>
                    <a href="mufaj.php">Műfaj</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_SESSION["admin"]==true) { ?>
                <li>
                    <a href="editor.php">Szerkesztő</a>
                </li>
                <?php } ?>
                <?php if ($_SESSION["logged_in"]==true) { ?>
                <li>
                    <a href="profile.php">Saját adatok</a>
                </li>
                <?php } ?>
                <li>
                    <a href="cart.php">Kosár</a>
                </li>
                <li>
                    <?php if ($_SESSION["logged_in"]==false) { ?>
                        <a href="login.php">Bejelentkezés</a>
                    <?php } else { ?>
                        <a href="logout.php">Kijelentkezés</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>