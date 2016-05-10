<?php

include("common.php");

session_start();


if(isset($_POST['torles']))
{
	clear_kosar();
}

if(isset($_POST['vasarlas']))
{	
	$kiszalitassal = $_POST['kiszalitassal'] == "on" ? 1 : 0;
	
	$szamla_id = -1;
	
	$now = date("Y-m-d");
	
	//számla létrehozása
	$q = "INSERT INTO $table_szamla(KISZALLITASSAL, datum) VALUES($kiszalitassal, TO_DATE('".$now."', 'YYYY-MM-DD'))";
	
	$result_szamla_insert = Query($q);
	
	$result_szamla_get = Query("SELECT szamla_id FROM $table_szamla WHERE ROWNUM = 1 ORDER BY szamla_id DESC");
	
	$szamla_id = $result_szamla_get[0]['SZAMLA_ID'];
	
	
	
	//felhasznalo - szamla_id
	
	
	
	$result_vasarol_insert = Query("INSERT INTO $table_vasarlas (szamla_id, felhasznalo_id) VALUES($szamla_id, ".get_user_id().")");
	
	echo "2 " .get_user_id() . " ";
	
	
	//aruhaz - szamla_id
	$aruhazak_id = array();
	
	$found = false;
	
	foreach(get_kosar() as $kosar) {
		foreach($aruhazak_id as $aruhaz_id)
		{
			if($aruhaz_id == $kosar['A_ID'])
			{
				$found = true;
			}
		}
		
		if($found == false)
		{
			$aruhazak_id[] = $kosar['A_ID'];
		}
		
		$found = false;
	}
	
	foreach($aruhazak_id as $aruhaz_id) {
		$result_vasarol_insert = Query("INSERT INTO $table_szamlazas (aruhaz_id, szamla_id) VALUES ($aruhaz_id, $szamla_id)");
	}
	
	
	echo "3";
	
	
	//SZÁMLATÉTELEK
	foreach(get_kosar() as $kosar) {
		$result_vasarol_insert = Query("INSERT INTO $table_szamlatetelek (szamla_id, termek_id, db) VALUES ($szamla_id, ".$kosar['T_ID'].", ".$kosar['DB'].")");
	}
	
	echo "4";

	
	//Nyilvantartasbol levonni a megvett megnnyiseget
	
	foreach(get_kosar() as $kosar) 
	{
		$update_db = Query("UPDATE $table_nyilvantartas SET db=db-".$kosar['DB']." WHERE aruhaz_id=".$kosar['A_ID']." AND termek_id=".$kosar['T_ID']."");
	}
	
	
	
	clear_kosar();
	Header("Location: index.php");
	exit;

}





if(isset($_POST['add_termek']))
{	
	print_r($_POST);
	
	add_kosar($_POST['termek_id'], $_POST['termek_nev'], $_POST['aruhaz_id'], $_POST['aruhaz_nev'], $_POST['ar'], $_POST['db']);
	
	//print_r(get_kosar());
	
}

$veg_osszeg = 0;

$content = "<h1>Kosar tartalma</h1><ul>";

foreach(get_kosar() as $kosar)
{

	$content .=
	"<li>
		<div class='row'>
		<div>".$kosar['A_NEV']."</div>
		<div>".$kosar['T_NEV']."</div>
		<div>".$kosar['AR']." Forint</div>
		<div>".$kosar['DB']." db</div>
		</div>
	</li>";
	
	$veg_osszeg += $kosar['DB'] * $kosar['AR'];
	
}

$content .= "</ul><br/><b>Végösszeg: $veg_osszeg Forint</b><br/>";

$content .= "<form method='post'>

<input type='checkbox' name='kiszalitassal'> Kiszálítással<br/><br/>

<input type='submit' name='vasarlas' value='Vásárol'>
<input type='submit' name='torles' value='Töröl'></form>";




?>


<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	
	
	
	<body>
		<!-- Nav -->
		<nav id="nav">
			<ul class="container">

			<?php
				
				echo LinkGenerator('');	
			?>	

				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
			</ul>
		</nav>

			
		<!-- Content -->
		
		<div class="wrapper style1 first">
			<article class="container" id="top">
		<?php
			echo $content;
		?>
			</article>
		
		</div>
		
	
	
		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.scrolly.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/skel-viewport.min.js"></script>
		<script src="assets/js/util.js"></script>
		<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
		<script src="assets/js/main.js"></script>

	</body>

</html>