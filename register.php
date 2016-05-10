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
            <form id="register">
                <h3 class="text-center">Regisztráció</h3>
                <div class="form-group">
                    <label>Felhasználónév</label>
                    <input name="" class="form-control" id="user" value="" type="" />
                </div>
                <div class="form-group">
                    <label>E-mail cím</label>
                    <input name="" class="form-control" id="email" value="" type="email" />
                </div>
                <div class="form-group">
                    <label>Jelszó</label>
                    <input name="" class="form-control" id="pass" value="" type="password" />
                </div>
                <div class="form-group">
                    <label>Jelszó újra</label>
                    <input name="" class="form-control" id="pass2" value="" type="password" />
                </div>
                <button class="btn btn-primary" type="submit">Regisztráció</button>
            </form>
        </div>
    </div>
</div>

</body>

</html>