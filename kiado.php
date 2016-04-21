<?php

include("common.php");
include("date_formater.php");

$edit_kiado = 0;

if(edit_mode()) {
	session_start();
	set_last_page("kiado.php");
}



//Update form
if(edit_mode() && isset($_GET['kiado_edit'])) {
	$edit_kiado = 1;
}

//Delete
if(edit_mode() && isset($_POST['kiado_delete'])) {
	$kiado_id = $_GET['id'];
	
	$delete_kiado_result = Query("DELETE FROM $table_kiadok WHERE kiado_id=".$kiado_id);
	
	header("Location: kiado.php");
}


//Apply Update
if(edit_mode() && isset($_POST['kiado_apply_edit'])) {
	$edit_kiado = 0;
	
	$kiado_id = $_GET['id'];
	
	$nev = NVL($_POST['e_nev']);
	$cim = NVL($_POST['e_cim']);
	
	print_r($_POST);
	
	if(empty($nev) || empty($cim)) {
		
		//Should show error
	}
	
	else{	
	
		$insert = "UPDATE $table_kiadok SET kiado_neve='".$nev."', kiado_cime='".$cim."' WHERE kiado_id=".$kiado_id;
		//echo $insert;
		$result_kiado_update = Query($insert);	
	}
	
}


//Insert
if(isset($_POST['add_kiado'])) {
	$kiado_nev = NVL($_POST['kiado_nev']);
	$kiado_cim = NVL($_POST['kiado_cim']);
	
	//$rendezo_id = -1;
	
	if(empty($kiado_nev) || empty($kiado_cim)) {
		
		//Error
	}
	
	else {
		
		$insert_kiado_result = Query("INSERT INTO $table_kiadok (kiado_neve,kiado_cime) VALUES('$kiado_nev','$kiado_cim')");
	}
}





$kiado_id = -1;

if(isset($_GET['id']) && $_GET['id'] != null) {
	
	$kiado_id = $_GET['id'];
	set_last_page("kiado.php?id=".$kiado_id);
	
	if(isset($_GET['del'])) {
		Query("DELETE FROM $table_kiadok WHERE kiado_id=".$mufaj_id);
		header("Location: kiado.php");
	}
	
}

function is_kiado() {
	global $kiado_id;
	return $kiado_id != -1;
}



$elem_row = 3;
$i = 0;
	
	
//Specific
if(is_kiado()) {
		
// ###########################
// #        kiado        #
// ###########################
	
	$result_kiado = Query("SELECT * FROM $table_kiadok WHERE kiado_id=".$kiado_id);
	//$kiado = mysql_fetch_assoc($result_kiado);
	$kiado = "";
	foreach($result_kiado as $kiado);
	

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
	

	$kiadok = "";
	
	$result_kiado = Query("SELECT * FROM $table_kiadok ORDER by kiado_id DESC");

	//if (mysql_num_rows($result_kiado) == 0) {
	if (count($result_kiado) == 0) {
		echo "No kiado at all";
		//exit;
	}
	
	
	//while($kiado = mysql_fetch_assoc($result_kiado)) 
	foreach($result_kiado as $kiado) 
	{
		if($i % $elem_row == 0) 
		{
			$kiadok .= "<div class='row'>";
		}
		
		$kiadok .= CreateFormatRowFromKiadoBasic($kiado);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$kiadok .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0)
	{
		$kiadok .= "</div>";
	}
	
	
	
	
	
	$edit_mode_no_kiado_selected = "";

	//Show the new Kiado Form
	if(edit_mode())
	{
		$edit_mode_no_kiado_selected =  '
		
						<div class="wrapper style4">
						<article class="container" id="add_kiado">
							<div class="row">
								
								<h2>Kiadó Hozzáadás</h2><br/>
								
								<!--<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindKiadoImageById($kiado_id).'" alt="" /></span>
								</div>-->

								<form method="post">
		
									<!-- kiado -->
									<h3>kiado adatai</h3>
									Név: <input type="text" name="kiado_nev">
									Cim: <input type="text" name="kiado_cim">
								
									<input type="hidden" name="add_kiado">
								
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

		
//Selected Kiado
if(is_kiado()) {
	
	if($edit_kiado == 0) {
		
		$content = '<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="top">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindkiadoImageById($kiado_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<h1>'.$kiado['KIADO_NEVE'].'</h1>
								<p>Cime: '.$kiado['KIADO_CIME'].'</p>
								<p>Bevétel: '.Rand(1,999). ' ' .Rand(0,999). ' ' .Rand(0,999) .' $</p>
							</header>
							
							'. (edit_mode() ? '<a href="kiado.php?id='.$kiado['KIADO_ID'].'&kiado_edit" class="button big scrolly">Szerkesztés</a>' : '' ).'
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
							<span class="image fit"><img src="'.FindkiadoImageById($kiado_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<p>Név: <input type="text" name="e_nev" value="'.$kiado['KIADO_NEVE'].'" placeholder="'.$kiado['KIADO_NEVE'].'"></p>
								
								<p>Cim: <input type="text" name="e_cim" value="'.$kiado['KIADO_CIME'].'" placeholder="'.$kiado['KIADO_CIME'].'"></p>
							</header>
							
							<input type="submit" class="button big scrolly" id="b_apply_edit" name="kiado_apply_edit" value="Szerkesztés Elfogadás">
							
							<input type="submit" class="button big scrolly" id="b_delete" name="kiado_delete" value="Törlés">
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
					<h2>Kiadók Listája</h2>
					<p></p>
				</header>
				
				<div class="container">
				
				'.$kiadok.'	
					
				</div>
				
				<footer>
					<p></p>
					<a href="#top" class="button big scrolly">Lap tetejére</a>
				</footer>
			</article>
		</div>'.$edit_mode_no_kiado_selected;			
}
			



?>
<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port - <?php if(is_kiado()) echo $kiado['KIADO_NEVE']; ?></title>
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
				
				echo LinkGenerator('kiado.php');
				if(is_kiado()) echo '<li><a href="kiado.php">Kiadó Kereső</a></li>';
				if(edit_mode() && !is_kiado()) echo '<li><a href="#add_kiado"><span style="color:RED">Kiadó Hozzáadás</span></a></li>';
				
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