<?php

include("common.php");
include("date_formater.php");

$edit_mode = 0;


if(edit_mode()) {
	
	session_start();
	set_last_page("szerzo.php");
	
	if(isset($_GET['szerzo_edit'])) {
		$edit_mode = 1;
	}
	
}



//DELETE
if(edit_mode() && isset($_POST['szerzo_delete'])) {
	
	$szerzo_id = $_GET['id'];
	
	$delete_studio_result = Query("DELETE FROM $table_szerzo WHERE szerzo_id=".$szerzo_id);
	
	header("Location: szerzo.php");
}

//Update
if(edit_mode() && isset($_POST['szerzo_apply_edit'])) {
	
	$edit_mode = 0;
	
	$szerzo_id = $_GET['id'];
	
	$nev = NVL($_POST['e_nev']);
	//$bio = NVL($_POST['e_bio']);
	//$szuletett = NVL($_POST['e_szuletett']);
	

	if(empty($nev) /*|| empty($szuletett) || empty($bio)*/)
	{
		//Should show error
	}
	else
	{
		
		$update = "UPDATE $table_szerzo SET szerzo_neve='$nev' WHERE szerzo_id=$szerzo_id";
		
		//echo $update;
		//print_r($_POST);
	
		$result_szerzo_update = Query($update);
		
	}
}



//Insert new szerzo
if(isset($_POST['add_szerzo'])) {
	
	$szerzo_nev = NVL($_POST['szerzo_nev']);
	
	if(empty($szerzo_nev)) {
		//Error
	}
	else {
		$insert_szerzo_result = Query("INSERT INTO $table_szerzo(SZERZO_NEVE) VALUES('$szerzo_nev')");
	}
}




//Insert Szerepel
if(isset($_POST['new_szerepel_apply'])) {
	$szerzo_id = NVL($_POST['szerzo_id']);
	
	//$nfilm_id = NVL($_POST['n_film_id']);
	//$karakter_nev = NVL($_POST['n_karakter']);
	//$szerep = NVL($_POST['n_szerep']);
	
	
	if(empty($karakter_nev) || empty($szerep) )
	{
		//error
	}
	else
	{
		Query("INSERT INTO Szerepel SET f_id=".$nfilm_id.", szerzo_id=".$szerzo_id.", karakter_nev='".$karakter_nev."', szerep='".$szerep."' ");
		
		$edit_mode = 0;
	}
	
}

//Update Szerep
if(isset($_POST['szerep_apply_edit'])) {
	$film_id = isset($_POST['f_id']) ? $_POST['f_id'] : -1;
	$szerzo_id = isset($_POST['szerzo_id']) ? $_POST['szerzo_id'] : -1;
	
	$efilm_id = isset($_POST['e_film_id']) ? $_POST['e_film_id'] : -1;
	$karakter_nev = isset($_POST['e_karakter']) ? $_POST['e_karakter'] : -1;
	$szerep = isset($_POST['e_szerep']) ? $_POST['e_szerep'] : -1;
	
	
	if(empty($karakter_nev) || empty($szerep) )
	{
		//error
	}
	else
	{
		Query("UPDATE Szerepel SET f_id=".$efilm_id.", karakter_nev='".$karakter_nev."', szerep='".$szerep."' WHERE f_id=".$film_id." AND szerzo_id=".$szerzo_id);
		
		$edit_mode = 0;
		
	}
	
	
}

//delete szerepel
if(isset($_POST['szerep_delete'])) {
	$film_id = isset($_POST['f_id']) ? $_POST['f_id'] : -1;
	$szerzo_id = isset($_POST['szerzo_id']) ? $_POST['szerzo_id'] : -1;
	
	Query("DELETE FROM Szerepel WHERE f_id=".$film_id." AND szerzo_id=".$szerzo_id);
}





/*
//Insert Rendez
if(isset($_POST['new_rendez_apply']))
{
	$film_id = isset($_POST['n_film_id']) ? $_POST['n_film_id'] : -1;
	$szerzo_id = isset($_POST['szerzo_id']) ? $_POST['szerzo_id'] : -1;
	$studio_id = isset($_POST['n_studio_id']) ? $_POST['n_studio_id'] : -1;
	
	
	if($film_id == -1 ||$szerzo_id == -1 || $studio_id == -1)
	{
		//error
	}
	else
	{
		Query("Insert INTO Rendez SET rendezo_id=".$szerzo_id.", f_id=".$film_id.", studio_id=".$studio_id);
	}
	
	
}

//Delete Rendez
if(isset($_POST['rendez_delete']))
{
	$film_id = isset($_POST['f_id']) ? $_POST['f_id'] : -1;
	$szerzo_id = isset($_POST['szerzo_id']) ? $_POST['szerzo_id'] : -1;
	
	Query("DELETE FROM Rendez WHERE f_id=".$film_id." AND rendezo_id=".$szerzo_id);
}

*/





$szerzo_id = -1;

if(isset($_GET['id']) && $_GET['id'] != null) {
	$szerzo_id = $_GET['id'];
	set_last_page("szerzo.php?id=".$szerzo_id);	
}


function is_sz() {
	global $szerzo_id;
	return $szerzo_id != -1;
}



$elem_row = 3;
$i = 0;
	
	

//Show Specific Szerzo
if(is_sz()) {
		
// ###########################
// #        szerzo        #
// ###########################
	
	$result_szerzo = Query("SELECT * FROM $table_szerzo WHERE szerzo_id=".$szerzo_id);
	//$szerzo = mysql_fetch_assoc($result_szerzo);
	$szerzo = "";
	foreach($result_szerzo as $szerzo);
	
	
// #################################
// #        Szerzett Termékek      #
// #################################
	
	$result_szerez = Query("SELECT * FROM $table_termekek WHERE szerzo_id=".$szerzo_id);
	
	$szerzett_termekek = "";
	
	//$szerzett_muvek_szama = mysql_num_rows($result_szerez);
	$szerzett_muvek_szama = count($result_szerez);
	
	//while($row = mysql_fetch_assoc($result_szerez))
	foreach($result_szerez as $row) {
		
		if($i % $elem_row == 0) {
			
			$szerzett_termekek .= "<div class='row'>";
		}
		
		$szerzett_termekek .= CreateFormatRowFromTermekBasic($row);
		
		$i++;
		
		if($i % $elem_row == 0) {
			
			$szerzett_termekek .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0) {
		$szerzett_termekek .= "</div>";
	}
	
	
}

//Open Just the General List person page
else {
	
	
// ###########################
// #  Get Data from Database #
// ###########################
			
	$elem_row = 3;
	$i = 0;
	

	$szerzoek = "";
	
	$result_szerzo = Query("SELECT * FROM $table_szerzo ORDER by szerzo_id DESC");

	//if (mysql_num_rows($result_szerzo) == 0) {
	if (count($result_szerzo) == 0) {
		echo "No szerzo at all";
		exit;
	}
	
	
	//while($szerzo = mysql_fetch_assoc($result_szerzo)) 
	foreach($result_szerzo as $szerzo) 
	{
		if($i % $elem_row == 0) 
		{
			$szerzoek .= "<div class='row'>";
		}
		
		$szerzoek .= CreateFormatRowFromSzerzoBasic($szerzo);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$szerzoek .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0)
	{
		$szerzoek .= "</div>";
	}
	
	
	$edit_mode_no_szerzo_selected = "";

	if(edit_mode())
	{
		$edit_mode_no_szerzo_selected =  '
		
						<div class="wrapper style4">
						<article class="container" id="film_add">
							<div class="row">
								<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindSzerzoImageById($szerzo_id).'" alt="" /></span>
								</div>

								<form method="post">
		
									<!-- szerzo -->
									<h3>Szerző Hozzáadás</h3>
									Név: <input type="text" name="szerzo_nev">
									
									<input type="hidden" name="add_szerzo">
								
									<input type="submit" value="Hozzáad">
								
								</form>
								
							</div>
						</article>
					</div>	
		';
	}
	
}
	


	
	
//Content
$content = "";
	
//Show specific Szerzo
if(is_sz()) {
	
	//alap nezet
	if($edit_mode == 0) {
		
		$content = '			
		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="top">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindSzerzoImageById($szerzo_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<h1>'.$szerzo['SZERZO_NEVE'].'</h1>
							</header>
							
							'. (edit_mode() ? '<a href="szerzo.php?id='.$szerzo['SZERZO_ID'].'&szerzo_edit" class="button big scrolly">Szerkesztés</a>' : '' ).'
						</div>
					</div>
				</article>
			</div>
			';
		
	
		if($szerzett_muvek_szama > 0)
			$content .= '
				<div class="wrapper style3">
					<article id="portfolio">
						<header>
							<h2>Szerzett művek</h2>
							<p></p>
						</header>
						
						
						
						<div class="container">
						
						'.$szerzett_termekek.'	
							
						</div>
						
					</article>
				</div>';
		
	}
	
	//editor nezet
	else {
		$content = '			
		<!-- Home -->
			<div class="wrapper style1 first">
				<form method="POST">
				<article class="container" id="top">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindszerzoImageById($szerzo_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								<h1><input type="text" name="e_nev" value="'.$szerzo['SZERZO_NEVE'].'" placeholder="'.$szerzo['SZERZO_NEVE'].'"></h1>
								
							</header>
							
							<input type="submit" class="button big scrolly" id="b_apply_edit" name="szerzo_apply_edit" value="Szerkesztés Elfogadás">
								
							<input type="submit" class="button big scrolly" id="b_delete" name="szerzo_delete" value="Törlés">	
						</div>
					</div>
				</article>
				</form>
			</div>
			';
	}	
}
		
//List all szerzo
else {

	$content = ' 
		<div class="wrapper style3">
			<article id="portfolio">
				<header>
					<h2>Szerzők</h2>
					<p></p>
				</header>
				
				<div class="container">
				
				'.$szerzoek.'	
					
				</div>
				
				<footer>
					<p></p>
					<a href="#top" class="button big scrolly">Lap tetejére</a>
				</footer>
			</article>
		</div>
		
		'.$edit_mode_no_szerzo_selected;		
}
		
?>



<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port - <?php if(is_sz()) echo $szerzo['SZERZO_NEVE']; ?></title>
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
			
				echo LinkGenerator('szerzo.php');
			
				if(is_sz()) echo '<li><a href="szerzo.php">Szerző Kereső</a></li>';
				if(edit_mode() && !is_sz()) echo '<li><a href="#szerzo_add"><span style="color:RED">Szerző Hozzáadás</span></a></li>';
				
			?>	
				
				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
			</ul>
		</nav>

			
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