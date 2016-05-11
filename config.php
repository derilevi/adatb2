<?php

$host = "localhost";

$ocidsn = "oci:dbname=
(DESCRIPTION =
(ADDRESS = (PROTOCOL = TCP)(HOST = ".$host.")(PORT = 1521))
(CONNECT_DATA = (SID = kabinet))
)";

$dbuser_xii = "h459723";

$dbuser = "";
$dbpass = "";


$table_kiadok = $dbuser_xii.".Kiado";
$table_szerzo = $dbuser_xii.".Szerzo";
$table_termekek = $dbuser_xii.".Termekek";
$table_termekMufaj = $dbuser_xii.".TermekMufaj";
$table_mufaj = $dbuser_xii.".Mufajok";
$table_termekek_filmek = $dbuser_xii.".Filmek";
$table_termekek_ekonyvek = $dbuser_xii.".Ekonyvek";
$table_termekek_konyvek = $dbuser_xii.".Konyvek";
$table_termekek_zenek = $dbuser_xii.".Zenek";
$table_aruhazak = $dbuser_xii.".Aruhazak";
$table_nyilvantartas = $dbuser_xii.".Nyilvantartas";
$table_felhasznalok = $dbuser_xii.".Felhasznalok";
$table_szamla = $dbuser_xii.".Szamla";
$table_szamlatetelek = $dbuser_xii.".Szamlatetelek";
$table_szamlazas = $dbuser_xii.".Szamlazas";
$table_vasarlas = $dbuser_xii.".Vasarlas";

?>
