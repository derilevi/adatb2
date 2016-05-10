<?php

include("common.php");
include("date_formater.php");

$edit_aruhaz = 0;

if(edit_mode()) {
	session_start();
	set_last_page("aruhaz.php");
}



//Update form
if(edit_mode() && isset($_GET['aruhaz_edit'])) {
	$edit_aruhaz = 1;
}

//Delete
if(edit_mode() && isset($_POST['aruhaz_delete'])) {
	$aruhaz_id = $_GET['id'];
	
	$delete_kiado_result = Query("DELETE FROM $table_aruhazak WHERE aruhaz_id=".$aruhaz_id);
	
	header("Location: aruhaz.php");
}


//Apply Update
if(edit_mode() && isset($_POST['aruhaz_apply_edit'])) {
	$edit_aruhaz = 0;
	
	$aruhaz_id = $_GET['id'];
	
	
	
	$tel_szam = NVL($_POST['e_telszam']);
	$cim = NVL($_POST['e_cim']);
	
	print_r($_POST);
	
	if(empty($tel_szam) || empty($cim)) {
		
		//Should show error
	}
	
	else{	
	
		$insert = "UPDATE $table_aruhazak SET telszam='".$tel_szam."', cim='".$cim."' WHERE aruhaz_id=".$aruhaz_id;
		//echo $insert;
		$result_aruhaz_update = Query($insert);	
	}
	
}


//Insert
if(isset($_POST['add_aruhaz'])) {
	$telszam = NVL($_POST['telszam']);
	$cim = NVL($_POST['cim']);
	
	//$rendezo_id = -1;
	
	if(empty($telszam) || empty($cim)) {
		
		//Error
	}
	
	else {
		
		$insert_kiado_result = Query("INSERT INTO $table_aruhazak (telszam,cim) VALUES('$telszam','$cim')");
	}
}





$aruhaz_id = -1;

if(isset($_GET['id']) && $_GET['id'] != null) {
	
	$aruhaz_id = $_GET['id'];
	set_last_page("aruhaz.php?id=".$aruhaz_id);
	
	if(isset($_GET['del'])) {
		Query("DELETE FROM $table_aruhazak WHERE aruhaz_id=".$mufaj_id);
		header("Location: aruhaz.php");
	}
	
}

function is_aruhaz() {
	global $aruhaz_id;
	return $aruhaz_id != -1;
}



$elem_row = 3;
$i = 0;
	
	
//Specific
if(is_aruhaz()) {
		
// ###########################
// #        kiado        #
// ###########################
	
	$result_aruhaz = Query("SELECT * FROM $table_aruhazak WHERE aruhaz_id=".$aruhaz_id);
	//$aruhaz = mysql_fetch_assoc($result_aruhaz);
	$aruhaz = "";
	foreach($result_aruhaz as $aruhaz);
	

// ###########################
// #        Szereplések      #
// ###########################

	$szereplok = "";	
}

//General
else {
	//Open Just the General List person page
	
// ###########################
// #  Get Data from Database #
// ###########################
			
	$elem_row = 3;
	$i = 0;
	

	$aruhazk = "";
	
	$result_aruhaz = Query("SELECT * FROM $table_aruhazak ORDER by aruhaz_id DESC");

	//if (mysql_num_rows($result_aruhaz) == 0) {
	if (count($result_aruhaz) == 0) {
		echo "No aruhaz at all";
		//exit;
	}
	
	
	//while($aruhaz = mysql_fetch_assoc($result_aruhaz)) 
	foreach($result_aruhaz as $aruhaz) 
	{
		if($i % $elem_row == 0) 
		{
			$aruhazk .= "<div class='row'>";
		}
		
		$aruhazk .= CreateFormatRowFromAruhazBasic($aruhaz);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$aruhazk .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0)
	{
		$aruhazk .= "</div>";
	}
	
	
	
	
	
	$edit_mode_no_aruhaz_selected = "";

	//Show the new Kiado Form
	if(edit_mode())
	{
		$edit_mode_no_aruhaz_selected =  '
		
						<div class="wrapper style4">
						<article class="container" id="add_aruhaz">
							<div class="row">
								
								<h2>Áruház Hozzáadás</h2><br/>
								
								<!--<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindKiadoImageById($aruhaz_id).'" alt="" /></span>
								</div>-->

								<form method="post">
		
									<!-- kiado -->
									<h3>Aruhaz adatai</h3>
									Cim: <input type="text" name="cim">
									Tel.: <input type="text" name="telszam">
									
								
									<input type="hidden" name="add_aruhaz">
								
									<input type="submit" value="Hozzáad">
								
								</form>
								
							</div>
						</article>
					</div>	
		';
	}
	
	
	
}
	

//Final Content
$content = "";

		
//Selected Aruhaz
if(is_aruhaz()) {
	
	if($edit_aruhaz == 0) {
		
		$content = '<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="top">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindkiadoImageById($aruhaz_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<h1>'.$aruhaz['CIM'].'</h1>
								<p>Telefonszám: '.$aruhaz['TELSZAM'].'</p>
								<p>Bevétel: '.Rand(1,999). ' ' .Rand(0,999). ' ' .Rand(0,999) .' $</p>
							</header>
							
							'. (edit_mode() ? '<a href="aruhaz.php?id='.$aruhaz['ARUHAZ_ID'].'&aruhaz_edit" class="button big scrolly">Szerkesztés</a>' : '' ).'
						</div>
					</div>
				</article>
			</div>
			';
	}
	
	else {
		
		$content = '<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="top">
				<form method="POST">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindkiadoImageById($aruhaz_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<p>Név: <input type="text" name="e_telszam" value="'.$aruhaz['TELSZAM'].'" placeholder="'.$aruhaz['TELSZAM'].'"></p>
								
								<p>Cim: <input type="text" name="e_cim" value="'.$aruhaz['CIM'].'" placeholder="'.$aruhaz['CIM'].'"></p>
							</header>
							
							<input type="submit" class="button big scrolly" id="b_apply_edit" name="aruhaz_apply_edit" value="Szerkesztés Elfogadás">
							
							<input type="submit" class="button big scrolly" id="b_delete" name="aruhaz_delete" value="Törlés">
						</div>
					</div>
					</form>
				</article>
			</div>';
	}			
}

//No Selected Kiado
else {
	//echo "General Page";
	$content = '<div class="wrapper style3">
			<article id="portfolio">
				<header>
					<h2>Aruházak Listája</h2>
					<p></p>
				</header>
				
				<div class="container">
				
				'.$aruhazk.'	
					
				</div>
				
				<footer>
					<p></p>
					<a href="#top" class="button big scrolly">Lap tetejére</a>
				</footer>
			</article>
		</div>'.$edit_mode_no_aruhaz_selected;			
}
			



?>
<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port - <?php if(is_aruhaz()) echo $aruhaz['telszam']; ?></title>
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
				
				echo LinkGenerator('aruhaz.php');
				if(is_aruhaz()) echo '<li><a href="aruhaz.php">Aruház Kereső</a></li>';
				if(edit_mode() && !is_aruhaz()) echo '<li><a href="#add_aruhaz"><span style="color:RED">Áruház Hozzáadás</span></a></li>';
				
			?>	

				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
			</ul>
		</nav>

			
		<!-- Content -->
		<?php
			echo $content;
		?>
		
	
	
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