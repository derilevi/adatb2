<?php
session_start();
if($_SESSION["logged_in"]==true) {
    header("Location:index.php");
}
if(count($_POST)>0) {
    include("db.php");
    $db=new DB();
    if($db->checkUser($_POST["email"],$_POST["pass"])) {
        $user = $db->getUser($_POST["email"]);
        $_SESSION["logged_in"]=true;
        $_SESSION["uid"] = $user["FELHASZNALO_ID"];
        $_SESSION["email"] = $user["EMAIL"];
        $_SESSION["nev"] = $user["TELJES_NEV"];
        $_SESSION["cim"] = $user["LAKCIM"];
        $_SESSION["telefon"] = $user["TELSZAM"];
        if ($user["JOGOSULTSAG"] == 0) {
            $_SESSION["admin"] = true;
        } else {
            $_SESSION["admin"] = false;
        }
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include("header.php"); ?>

</head>

<body>

    <?php include("navigation.php"); ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form method="post" action="login.php" role="form">
                    <h3 class="text-center">Bejelentkezés</h3>
                    <div class="form-group">
                        <label>E-mail cím:</label>
                        <input name="email" class="form-control" value="" type="" />
                    </div>
                    <div class="form-group">
                        <label>Jelszó</label>
                        <input name="pass" class="form-control" value="" type="password" />
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="emlekezz" type="checkbox" /> Emlékezz rám
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Bejelentkezés</button>
                </form>
                <a href="register.php">Még nem regisztráltál?</a>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>