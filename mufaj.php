<?php

include("common.php");

if(edit_mode())
{
	session_start();
	set_last_page("mufaj.php");
}


if(isset($_POST['add_mufaj'])) {
	
	$mufaj_nev = NVL($_POST['a_mufaj_nev']);
	$mufaj_szulo_id = NVL($_POST['a_mufaj_szulo_id']);	
	$mufaj_szint = NVL($_POST['a_mufaj_szint']);
	
	if(empty($mufaj_nev) /*|| empty($mufaj_szulo_id) || empty($mufaj_szint)*/) {
		//Show Error	
	}
	else
	{
		if($mufaj_szulo_id == -1)
			$mufaj_szulo_id = 'NULL';
		
		
		$already_in_result = Query("SELECT * from $table_Mufaj WHERE mufaj_nev like '".$mufaj_nev."' ");
		
		if(count($already_in_result) == 0)
		{
			
			//$insert = "INSERT INTO $table_Mufaj SET mufaj_nev='".$mufaj_nev."', szulo_id=".$mufaj_szulo_id.", szint=".$mufaj_szint."";
			
			$insert = "INSERT INTO $table_Mufaj(mufaj_nev, szulo_id, szint) VALUES ('$mufaj_nev', $mufaj_szulo_id, $mufaj_szint)";
			//Insert
			echo $insert;
			
			Query($insert);
		}
		else
		{
			//Already in
		}
	}
}





$mufaj_id = -1;
function is_m() {
	global $mufaj_id;
	return $mufaj_id != -1;
}



if(isset($_GET['id']) && $_GET['id'] != null)
{
	$mufaj_id = $_GET['id'];
	set_last_page("mufaj.php?id=".$mufaj_id);
}


if(edit_mode()) 
{
	if(isset($_POST['mufaj_delete']))
	{
		$mufaj_id = NVL($_POST['id']);
		
		Query("DELETE FROM $table_Mufaj WHERE mufaj_id=".$mufaj_id);
		header("Location: mufaj.php");
	}
	else if(isset($_POST['mufaj_apply_edit'])) {
		
		
	$mufaj_id = NVL($_POST['id']);
		
		
		
		
	//Mufaj Update
	$nev = NVL($_POST['e_nev']);
	$szulo_id = NVL($_POST['e_szulo_id']);
	$szint = NVL($_POST['e_szint']);


	print_r($_POST);
	
	
	//IF any Data missing
	if(empty($nev)) {
		//Should drop error
		echo "error something empty";
	}
	else {

		$update = "UPDATE $table_Mufaj SET mufaj_nev='$nev', szulo_id=$szulo_id, szint=$szint WHERE mufaj_id=$mufaj_id";
		
		//echo $insert;
		$update_mufaj = Query($update);
	}
		
		
		
	}
	
	
	
	
	
	
}




//selected
if(is_m())
{

// ###########################
// #  Mufaj #
// ###########################

	$result_mufaj = Query("SELECT * FROM $table_Mufaj WHERE mufaj_id=".$mufaj_id);
	//$mufaj = mysql_fetch_assoc($result_mufaj);
	$mufaj = "";
	foreach($result_mufaj as $mufaj);

// ###########################
// #  Filmhez kapcsoló műfajok #
// ###########################

	$result_TermekIDs = Query("SELECT termek_id FROM $table_termekMufaj WHERE mufaj_id=".$mufaj_id);

// ###########################
// #  Filmek #
// ###########################
			
	$elem_row = 3;
	$i = 0;
	
	//Film Query
	$termekek = "";
		
	//while($termekID = mysql_fetch_assoc($result_TermekIDs))	
	foreach($result_TermekIDs as $termekID)
	{	
		//print_r($termekID);
	
		$result_termek = Query("SELECT * FROM $table_termekek WHERE termek_id=".$termekID['TERMEK_ID']);

		//while($film = mysql_fetch_assoc($result_film))
		foreach($result_termek as $termek)
		{
			if($i % $elem_row == 0)  
			{
				$termekek .= "<div class='row'>";
			}
			
			$termekek .= CreateFormatRowFromTermekBasic($termek, edit_mode());
			 
			$i++;
			
			if($i % $elem_row == 0) 
			{
				$termekek .= "</div>";
			}
		}
	}
}

else
{	
	$mufajok = "";
	$elem_row = 3;
	$i = 0;
	
	$result_mufaj = Query("SELECT * FROM $table_Mufaj");
	
	//while($mufaj = mysql_fetch_assoc($result_mufaj))
	foreach($result_mufaj as $mufaj)
	{
		if($i % $elem_row == 0)  
		{
			$mufajok .= "<div class='row'>";
		}
		
		$mufajok .= CreateFormatRowFromMufaj($mufaj, false);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$mufajok .= "</div>";
		}
	}
	
	
	
	
	
	//Mufaj hozzadas FORM
	$edit_mode_no_mufaj_selected = "";

	if(edit_mode()) {
		
		$edit_mode_no_mufaj_selected =  '
		
		<div class="wrapper style4">
			<article class="container" id="mufaj_add">
			
				<div class="row">

					<form method="post">

						<h3>Műfaj Hozzáadás</h3>

						Megnevezés: <input type="text" name="a_mufaj_nev">	
						Szülő Műfaj: <!--<input type="text" name="a_mufaj_szulo_id">-->
						'.GenerateSelectListFromMufaj('a_mufaj_szulo_id', true).'
						
						Szint:<input type="text" name="a_mufaj_szint">

						
						<input type="hidden" name="add_mufaj">	
						
						<input type="submit" value="Hozzáad">
					
					</form>
					
				</div>
			</article>
		</div>	
		';
	}

}	

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
				
					echo LinkGenerator('mufaj.php');
					if(is_m()) echo '<li><a href="mufaj.php">Műfaj Kereső</a></li>';
					if(edit_mode() && !is_m()) echo '<li><a href="#mufaj_add">Műfaj hozzáadás</a></li>';
					
				?>
				
				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
			</ul>
		</nav>

				
		<?php
			
			//Selected Mufaj & Show Form to EDIT
			if(is_m() && edit_mode()) {
				echo '			
					<!-- Home -->
						<div class="wrapper style1 first">
							<form method="POST">
							<article class="container" id="top">
								<div class="row">
									<div class="8u 12u(mobile)">
										<header>
										
										<h3>Műfaj Szerkesztése</h3>
										
											Megnevezés:
											<input type="text" name="e_nev" value="'.$mufaj['MUFAJ_NEV'].'" placeholder="'.$mufaj['MUFAJ_NEV'].'">
										</header>
										
										<!-- Szulo -->
										Szülő Műfaj: '. GenerateSelectListFromMufaj('e_szulo_id', true, $mufaj['SZULO_ID']) .'
										
										<p>Szint: <input type="text" name="e_szint" value="'.$mufaj['SZINT'].'" placeholder="'.$mufaj['SZINT'].'"></p>
										
										<input type="hidden" name="id" value="'.$mufaj['MUFAJ_ID'].'">
										
										
										<input type="submit" class="button big scrolly" id="b_apply_edit" name="mufaj_apply_edit" value="Szerkesztés Elfogadás">
											
										<input type="submit" class="button big scrolly" id="b_delete" name="mufaj_delete" value="Törlés">	
									</div>
								</div>
							</article>
							</form>
						</div>';
			}
			
		?>
			
		<!-- Termek / Mufaj Lista -->
		<div class="wrapper style3">
			<article id="portfolio">
				<header>
					<h2><?php echo is_m() ? $mufaj['MUFAJ_NEV']." Műfajú Termékek" : "Műfajok"; ?></h2>
				</header>
				
				<div class="container">
				
					<?php echo is_m() ? $termekek : $mufajok; ?>

				</div>
				

			</article>
		</div>
		
			
		<?php 
			
			//Mufaj Insert
			echo is_m() == false ? $edit_mode_no_mufaj_selected : "";
			
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