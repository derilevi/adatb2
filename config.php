<?php

$localhost = 'localhost';


$dbuser =  'xxxxx';
$dbpass = 'xxxxxxx';



$table_kiadok = "Kiado";
$table_szerzo = "Szerzo";

$table_termekek = "Termekek";
$table_termekMufaj = "TermekMufaj";
$table_Mufaj = "Mufajok";



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
