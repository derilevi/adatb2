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
            <?php
            if (!isset($_SESSION["cart"])||count($_SESSION["cart"])) {
                print("Nincs termék a kosárban");
            } else {
                
            }
            ?>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>