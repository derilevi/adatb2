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
            include("db.php");
            $db=new DB();
            print("<div class=\"col-md-3\">
                <p class=\"lead\">Kiadók</p>
                <div class=\"list-group\">");
            $kiadok=$db->getAllKiado();
            for ($i=0;$i<count($kiadok);$i++) {
                print("<a href=\"kiado.php?id=".$kiadok[$i]["KIADO_ID"]."\" class=\"list-group-item\">".$kiadok[$i]["KIADO_NEVE"]."</a>");
            }
                print("</div>
                    </div>");
            if(isset($_GET["id"])) {
                $termekek=$db->getTermekekByKiado($_GET["id"]);
            } else {
                $termekek=$db->getTermekekRandom();
            }
            print("<div class=\"col-md-9\">
                    <div class=\"row\">");
            for ($i=0;$i<count($termekek);$i++) {
                print("<div class=\"col-sm-4 col-lg-4 col-md-4\">
                        <div class=\"thumbnail\">
                            <!-- <img src=\"img/".$termekek[$i]["TERMEK_ID"].".jpg\" alt=\"".$termekek[$i]["CIM"]."\"> -->
                            <div class=\"caption\">
                                <h4 class=\"pull-right\">".$termekek[$i]["AR"]." Ft</h4>
                                <h4><a href=\"termek.php?id=".$termekek[$i]["TERMEK_ID"]."\">".$termekek[$i]["CIM"]."</a>
                                </h4>
                                <p>".$termekek[$i]["LEIRAS"]."</p>
                            </div>
                        </div>
                    </div>");
            }
            print("</div>
                    </div>");
            ?>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>