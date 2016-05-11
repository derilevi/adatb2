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
        E-mail cím: <?php echo $_SESSION["email"]; ?><br />
        Név: <?php echo $_SESSION["nev"]; ?><br />
        Lakcím: <?php echo $_SESSION["cim"]; ?><br />
        Telefonszám: <?php echo $_SESSION["telefon"]; ?><br />
    </div>
</div>

<?php include("footer.php"); ?>

</body>

</html>