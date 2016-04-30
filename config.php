<?php

$localhost = 'localhost';


$dbuser_xii =  'h459723';

$dbuser =  'xxxxxxx';
$dbpass = 'xxxxxxxx';


$table_kiadok = $dbuser_xii.".Kiado";
$table_szerzo = $dbuser_xii.".Szerzo";

$table_termekek = $dbuser_xii.".Termekek";
$table_termekMufaj = $dbuser_xii.".TermekMufaj";
$table_Mufaj = $dbuser_xii.".Mufajok";


$table_termekek_filmek = $dbuser_xii.".Filmek";
$table_termekek_ekonyvek = $dbuser_xii.".Ekonyvek";
$table_termekek_konyvek = $dbuser_xii.".Konyvek";
$table_termekek_zenek = $dbuser_xii.".Zenek";


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
