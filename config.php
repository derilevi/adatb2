<?php

$localhost = 'localhost';


$dbuser_xii =  'h459723';

$dbuser =  '';
$dbpass = '';











$table_kiadok = $dbuser_xii.".Kiado";
$table_szerzo = $dbuser_xii.".Szerzo";

$table_termekek = $dbuser_xii.".Termekek";
$table_termekMufaj = $dbuser_xii.".TermekMufaj";
$table_Mufaj = $dbuser_xii.".Mufajok";


$table_termekek_filmek = $dbuser_xii.".Filmek";
$table_termekek_ekonyvek = $dbuser_xii.".Ekonyvek";
$table_termekek_konyvek = $dbuser_xii.".Konyvek";
$table_termekek_zenek = $dbuser_xii.".Zenek";

$table_aruhazak = $dbuser_xii.".Aruhazak";

$table_nyilvantartas = $dbuser_xii.".NYILVANTARTAS";

$table_felhasznalok = $dbuser_xii.".felhasznalok";



$table_szamla = $dbuser_xii.".szamla";
$table_szamlatetelek = $dbuser_xii.".szamlatetelek";

$table_szamlazas = $dbuser_xii.".szamlazas";
$table_vasarlas = $dbuser_xii.".vasarlas";







$dbtns = "  
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
	  (SERVER = DEDICATED)
      (SID = kabinet)
    )
  )";


?>
