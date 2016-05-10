<?php
/*
 * 0. Random 9 termek
 * 1. Konyv
 * 2. E-konyv
 * 3. Film
 * 4. Zene
*/
include "db.php";
$db=new DB();

if (isset($_GET["cat"])) {
    $category=$_GET["cat"];
} else {
    $category=0;
}
switch ($category) {
    case 1:
        $termekek=$db->getTermekek();
        break;
    case 2:
        $termekek=$db->getTermekek();
        break;
    case 3:
        $termekek=$db->getTermekek();
        break;
    case 4:
        $termekek=$db->getTermekek();
        break;
    default:
        $termekek=$db->getTermekek();
}

print ("<div class=\"col-md-9\">
        <div class=\"row\">");

for ($i=0;$i<9;$i++) {
                    print("<div class=\"col-sm-4 col-lg-4 col-md-4\">
                        <div class=\"thumbnail\">
                            <img src=\"img/1.jpg\" alt=\"\">
                            <div class=\"caption\">
                                <h4 class=\"pull-right\">5000 Ft</h4>
                                <h4><a href=\"#\">Tüskevár</a>
                                </h4>
                                <p>Fekete István</p>
                            </div>
                        </div>
                    </div>
                    ");
}

print ("</div>
        </div>");

?>