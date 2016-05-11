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
                <form id="login">
                    <h3 class="text-center">Bejelentkezés</h3>
                    <div class="form-group">
                        <label>Felhasználónév</label>
                        <input name="" class="form-control" id="user" value="" type="" />
                    </div>
                    <div class="form-group">
                        <label>Jelszó</label>
                        <input name="" class="form-control" id="pass" value="" type="password" />
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="emlekezz" type="checkbox" /> Emlékezz rám
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Bejelentkezés</button>
                </form>
                <!-- <a href="register.php">Még nem regisztráltál?</a> -->
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>