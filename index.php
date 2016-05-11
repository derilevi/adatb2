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

            <div class="col-md-3">
                <p class="lead">Kategóriák</p>
                <div class="list-group">
                    <a href="index.php?cat=1" class="list-group-item">Könyv</a>
                    <a href="index.php?cat=2" class="list-group-item">E-könyv</a>
                    <a href="index.php?cat=3" class="list-group-item">Film</a>
                    <a href="index.php?cat=4" class="list-group-item">Zene</a>
                </div>
            </div>

            <?php include("category.php"); ?>

        </div>

    </div>
    <!-- /.container -->

    <?php include("footer.php"); ?>

</body>

</html>
