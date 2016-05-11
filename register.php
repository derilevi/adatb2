<?php
session_start();
if($_SESSION["logged_in"]==true) {
    header("Location:index.php");
}
if(count($_POST)>0) {
    include("db.php");
    $db=new DB();
    $success=$db->register($_POST["email"],$_POST["pass"],$_POST["nev"],$_POST["cim"],$_POST["telszam"]);
    if($success) {
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
                <form method="post" action="register.php" role="form">
                    <h3 class="text-center">Regisztráció</h3>
                    <div class="form-group">
                        <label>Név</label>
                        <input name="nev" class="form-control" value="" type="" />
                    </div>
                    <div class="form-group">
                        <label>Lakcím</label>
                        <input name="cim" class="form-control" value="" type="" />
                    </div>
                    <div class="form-group">
                        <label>Telefonszám</label>
                        <input name="telszam" class="form-control" value="" type="" />
                    </div>
                    <div class="form-group">
                        <label>E-mail cím</label>
                        <input name="email" class="form-control" value="" type="email" />
                    </div>
                    <div class="form-group">
                        <label>Jelszó</label>
                        <input name="pass" class="form-control"  value="" type="password" />
                    </div>
                    <div class="form-group">
                        <label>Jelszó újra</label>
                        <input name="pass2" class="form-control" value="" type="password" />
                    </div>
                    <button class="btn btn-primary" type="submit">Regisztráció</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>