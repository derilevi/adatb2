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
        $termekek=$db->getTermekek("konyvek");
        break;
    case 2:
        $termekek=$db->getTermekek("ekonyvek");
        break;
    case 3:
        $termekek=$db->getTermekek("filmek");
        break;
    case 4:
        $termekek=$db->getTermekek("zenek");
        break;
    default:
        $termekek=$db->getTermekekRandom();
}
//print_r($termekek);

print ("<div class=\"col-md-9\">
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
                    </div>
                    ");
}

print ("</div>
        </div>");

?>