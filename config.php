<?php

$localhost = 'localhost';


$dbuser_xii =  'h459723';

$dbuser =  'xxxxx';
$dbpass = 'xxxxxxx';



$table_kiadok = $dbuser_xii.".Kiado";
$table_szerzo = $dbuser_xii.".Szerzo";

$table_termekek = $dbuser_xii.".Termekek";
$table_termekMufaj = $dbuser_xii.".TermekMufaj";
$table_Mufaj = $dbuser_xii.".Mufajok";



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
