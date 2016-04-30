<?php

include("common.php");



//Last Page in editor mode
if(edit_mode()) {
	session_start();
	set_last_page("termek_ekonyv.php");
}

//Insert new 
if(isset($_POST['add_termek'])) {	
	//Termek
	$cim = NVL($_POST['cim']);
	$kiadas_eve = NVL($_POST['kiadas_eve']);
	$leiras = NVL($_POST['leiras']);
	$ar = NVL($_POST['ar']);
	
	$kiado_id = NVL($_POST['e_kiado_id']);	
	$szerzo_id = NVL($_POST['e_szerzo_id']);
	
	$e_mufajok_ids =  NVL($_POST['e_mufajok']);

	
	//ekonyv
	$e_meret = NVL($_POST['e_meret']);
	
	$e_oldal = NVL($_POST['e_oldal']);
	
	$e_kit = NVL($_POST['e_kit']);
	
	
	
	//print_r($_POST);
	
	///Add new Rendezo if needed
	/*
	if(!empty($rendezo_NEW))
	{
		if(empty($rendezo_nev) || empty($rendezo_bio) || empty($rendezo_date))
		{
			//Error
		}
		else
		{
			$insert_rendezo_result = Query("INSERT INTO Szemely(nev,bio,szul_datum) VALUES('$rendezo_nev','$rendezo_bio','$rendezo_date')");
			
			$rendezo_id_result = Query("SELECT sz_id FROM Szemely ORDER BY sz_id DESC LIMIT 1");
			$rendezo_id = mysql_fetch_assoc($rendezo_id_result);
		}
	}
	else
	{
		//Find Rendezo
		$select_rendezo_result = Query("SELECT sz_id FROM Szemely WHERE nev='".$rendezo_nev."'");
		$rendezo_id = mysql_fetch_assoc($select_rendezo_result);
	}
	
	*/
	
	
	//IF any Data missing
	if(empty($cim) || empty($kiadas_eve) || empty($leiras) || empty($ar) || empty($kiado_id) || empty($kiado_id) || empty($e_mufajok_ids) || empty($e_hossz) 
		|| empty($e_meret) || empty($e_oldal) || empty($e_kit) ) {
		//Should drop error
		
		echo "error something empty";
	}
	else {
		
		$insert = "INSERT INTO $table_termekek(cim, kiadas_eve, leiras, ar, kiado_id, szerzo_id) VALUES ('$cim', $kiadas_eve, '$leiras', $ar, $kiado_id, $szerzo_id)";
		
		//echo $insert;
		$insert_termek_result = Query($insert);
		
		
		
		//Mufaj termek kapocs
		$last_insert_ID = Query("SELECT termek_id FROM $table_termekek WHERE ROWNUM = 1 ORDER BY termek_id DESC;");

		echo "MufajokIDS: ";
		foreach($e_mufajok_ids as $mufajID)
		{
			$termek_id = $last_insert_ID[0]['TERMEK_ID'];
			
			$insert = "INSERT INTO $table_termekMufaj (termek_id, mufaj_id) VALUES ($termek_id, $get_mufaj_ID)";
		
			Query($insert);
			
			echo "INSERT_ZERO: ". $m ."<br/> " . $insert;
			
		}
		
		
		//Insert  data
		//$insert = "INSERT INTO $table_termekek_filmek(termek_id, idotartam) VALUES ($last_insert_ID, $hossz)";
		//echo $insert;
		//$insert_termek_result = Query($insert);
		
		
		
		
		//Ekoeny
		$insert = "INSERT INTO $table_termek_ekonyvek(termek_id, meret, oldalszam, kiterjesztes) VALUES ($last_insert_ID, $e_meret, $e_oldal, $e_kit)";
		
		//echo $insert;
		$insert_termek_result = Query($insert);
		
		
		
		
		
		
		//echo "success isnert";
		
		//$insert_filmID_result = Query("SELECT f_id FROM Film ORDER BY f_id DESC LIMIT 1");
		//$termek_id = mysql_fetch_assoc($insert_filmID_result);	
		
	}
	
}




//Boolean
$edit_termek = 0;


//Content 
$content = "";
		
$edit_mode_no_ekonyv_selected = "";
	


//Update - Update Form - Delete
if(edit_mode()) {
	
	//DELETE
	if(isset($_POST['termek_delete'])) {
		$edit_termek = 0;
		$termek_id = $_GET['id'];
		
	
		$delete_ekonyv_result = Query("DELETE FROM $table_termekek WHERE termek_id=".$termek_id);
		
		$delete_ekonyv_result = Query("DELETE FROM $table_termekek_ekonyvek WHERE termek_id=".$termek_id);
		
		
		header("Location: termek_ekonyv.php");
	}
	
	//Edit Termek
	else if(isset($_GET['termek_edit'])) {
		$edit_termek = 1;
	}
	
	//Apply Edit Termek
	if(isset($_POST['termek_apply_edit'])) {
		$edit_termek = 0;
		
		$termek_id = NVL($_POST['e_id']);
		
		$cim = NVL($_POST['e_cim']);
		
		$szerzo_id = NVL($_POST['e_szerzo_id']);	
		$kiado_id = NVL($_POST['e_kiado_id']);
		
		$u_mufajok = NVL($_POST['e_mufajok']);
		$kiadas_eve = NVL($_POST['e_kiadas_eve']);
		
		$ar = NVL($_POST['e_ar']);
		
		$leiras = NVL($_POST['e_leiras']);
		
		
		//ekonyvek
		$e_meret = NVL($_POST['e_meret']);
	
		$e_oldal = NVL($_POST['e_oldal']);
		
		$e_kit = NVL($_POST['e_kit']);
		
			
		//print_r($_POST);
		
		if(empty($cim) || empty($szerzo_id) || empty($kiado_id) || empty($u_mufajok) || empty($kiadas_eve) || empty($ar) || empty($leiras) 
			|| empty($e_meret) || empty($e_oldal) || empty($e_kit) )
		{
			//ERROR
			echo 'err Valami ures';
			
			
			echo $cim ."<br/>";
			echo $szerzo_id ."<br/>";
			echo $kiado_id ."<br/>";
			
			echo $u_mufajok ."<br/>";
			echo $kiadas_eve ."<br/>";
			echo $ar ."<br/>";
			
			echo $leiras ."<br/>";
			
			//ekonyv
			echo $e_meret . "<br/>";	
			echo $e_oldal . "<br/>";
			echo $e_kit . "<br/>";
			
		}
		else
		{
			$qry = "UPDATE $table_termekek SET cim='".$cim."', kiadas_eve=".$kiadas_eve.", leiras='".$leiras."', ar=".$ar.", kiado_id=".$kiado_id.", szerzo_id=".$szerzo_id." WHERE termek_id=".$termek_id;
		
			//update Termek Data
			$result_update = Query($qry);
				
			//print_r($_POST);
			
			
			//update ebook
			$qry = "UPDATE $table_termekek_ekonyvek SET kiterjesztes='".$e_kit."', oldalszam=".$e_oldal.", meret=".$e_meret." WHERE termek_id=".$termek_id;
			
			//echo $qry;
			
			Query($qry);
			

			//update Szerzo
			//$result_rendezo = Query("SELECT * FROM Szerzo WHERE nev like '".$rendezo_nev."'");
			
			
			
/*			
			//Rendezo benne van az adatbazisban
			if(mysql_num_rows($result_rendezo) > 0)
			{
				$rendezo_edit = mysql_fetch_assoc($result_rendezo);
				
				//here
				$result_rendez = Query("UPDATE Rendez SET rendezo_id=".$rendezo_edit['sz_id']." WHERE f_id=".$termek_id);
						
				//Should Notify the user
				if(mysql_affected_rows() > 0)
				{
					echo "<br/> update Rendezo";
				}
				else
				{
					//echo "<br/>ERR update Rendezo, Insert New";
					//Query("INSERT INTO Rendez SET rendezo_id=".$rendezo_edit['sz_id'].", f_id=".$termek_id);
				}
			}
*/
			
			
			
			
			
			//update mufaj
			
			$select_already_mufajok_id = Query("SELECT mufaj_id FROM $table_termekMufaj WHERE termek_id=".$termek_id);
			
			$already_mufajok = array();
			
			//while($sor = mysql_fetch_assoc($select_already_mufajok_id))
			foreach($select_already_mufajok_id as $sor)
			{
				$already_mufajok[] = $sor['MUFAJ_ID'];
			}
			
			
			
			//echo "Meglevo mufajok";
			//print_r($already_mufajok);
			
			
			//echo "<br/>Kapott mufajok";
			//print_r($u_mufajok);
			
			
			
			
			//jelenleg nincs mufaj hozzaadva
			if(count($already_mufajok) == 0)
			{
				foreach($u_mufajok as $u_mufajID)
				{
					$insert = "INSERT INTO $table_termekMufaj (termek_id, mufaj_id) VALUES ($termek_id, $u_mufajID)";
					Query($insert);
					
					echo "INSERT_ZERO: ". $u_mufajID ."<br/> ";
				}
			}
			else
			{
				//Van mar hozzarandelve mufaj
				
				
				//Azt kell kitorolni, ami nincs benne az ujban
				foreach($already_mufajok as $old_mufajID)
				{
					//A kapott ID nincs benne a update listaban --> TORLES
					if(in_array($old_mufajID, $u_mufajok) == false)
					{
						echo "DEL(".$old_mufajID.")\n";
						Query("DELETE FROM $table_termekMufaj WHERE termek_id=".$termek_id." AND mufaj_id=".$old_mufajID);	
					}
				}
				
				
				//Azt kell berakni, ami nincs benne a regiben
				foreach($u_mufajok as $newMufajID)
				{
					if(in_array($newMufajID, $already_mufajok) == false)
					{
						echo "ADD(".$newMufajID.")\n";
						Query("INSERT INTO $table_termekMufaj(mufaj_id,termek_id) VALUES($newMufajID, $termek_id)");
					}
				}
				
			}
			
		
		
		
		
		
			
		}
				
	}

}



function is_termek() {
	global $termek_id;
	return $termek_id != -1;
}

$termek_id = -1;



//View Specific termek
if(isset($_GET['id']) && $_GET['id'] != null) {
	$termek_id = $_GET['id'];
	set_last_page("termek_ekonyv.php?id=".$termek_id);
}



//Date formater include
include("date_formater.php");



//Selected Have Specific termek
if(is_termek()) {

// ###########################
// #  	Termek Adatai		 #
// ###########################
		
	$result_ekonyvek = Query("SELECT * FROM $table_termekek_ekonyvek WHERE termek_id=".$termek_id);
	
	//if (mysql_num_rows($result_ekonyvek) == 0)
	if($result_ekonyvek == null) {
		echo "NO Termek in the Database";
		exit;
	}
	
	//$ekonyv = mysql_fetch_assoc($result_ekonyvek);
	$ekonyvek = "";
	foreach($result_ekonyvek as $ekonyvek);
	
	
// ##############################
// # Termékhez kapcsoló mufajok #
// ##############################

	$mufajok = "";
	
	$i=0;

	$result_mufajID = Query("SELECT mufaj_id FROM $table_termekMufaj WHERE termek_id=".$termek_id);
	
	//while($mufajID = mysql_fetch_assoc($result_mufajID))
	foreach($result_mufajID as $mufajID){
		
		$result_mufaj = Query("SELECT * FROM $table_Mufaj where mufaj_id=".$mufajID['MUFAJ_ID']);
				
		//$max_mufaj = mysql_num_rows($result_mufaj);
		$max_mufaj = count($result_mufaj);
		
		//while ($mufaj = mysql_fetch_assoc($result_mufaj)) 
		foreach ($result_mufaj as $mufaj) {
			
			$mufajok .= "<a href='mufaj.php?id=".$mufaj['MUFAJ_ID']."'>".$mufaj['MUFAJ_NEV']."</a>";
			
			$i++;
			
			if($i+1 != $max_mufaj) {
				$mufajok .= " | ";
			}
		}
	}
	
	
}

else {
// ###########################
// # List Data from Database #
// ###########################
			
	$elem_row = 3;
	$i = 0;
	
	
	//output string
	$termekek = "";

	$result_termek = Query("SELECT * FROM $table_termekek_ekonyvek");

	
	if ($result_termek == null) {
		echo "No Termek at all";
		exit;
	}
	
	//print_r($result_termek);
	
	//while($termek = mysql_fetch_assoc($result_termek)) 	
	foreach($result_termek as $termek) {
		
		$result_ekonyv = Query("SELECT * FROM $table_termekek WHERE termek_id=".$termek['TERMEK_ID']);
		
		$ekonyv = "";
		foreach($result_ekonyv as $ekonyv);
		
		
		if($i % $elem_row == 0) {
			$termekek .= "<div class='row'>";
		}
		
		$termekek .= CreateFormatRowFromEkonyvBasic($termek, $ekonyv);
		
		$i++;
		
		if($i % $elem_row == 0) {
			$termekek .= "</div>";
		}
		
		//echo $i;	
	}
	
	
	if($i % $elem_row != 0) {
		$termekek .= "</div>";
	}


}



//Edit it
//Only one termek selected 
if(edit_mode()) {	

	$edit_mode_no_ekonyv_selected =  '
	
		<div class="wrapper style4">
		<article class="container" id="termek_add">
			<div class="row">
				<div class="4u 12u(mobile)">
					<span class="image fit"><img src="'.FindFilmImageById($termek_id).'" alt="" /></span>
				</div>

				<form method="post">

					<h3>Termek adatai</h3>

					Cím: <input type="text" name="cim">						
					Kiadás éve: <input type="text" name="kiadas_eve">
					Leírás: <input type="text" name="leiras">
					Ár:<input type="text" name="ar">
					
					Kiadó: '.GenerateSelectListFromKiado().'
					
					<br/>Szerző: '.GenerateSelectListFromSzerzo().'<br/>
					
					Műfajok: <br/>'.GenerateCheckboxesFromMufajok().'
				
				
					Méret:<input type="text" name="e_meret">
					
					Oldal:<input type="text" name="e_oldal">
					
					Kiterjesztés:<input type="text" name="e_kit">

					<input type="hidden" name="add_termek">

					<input type="submit" value="Hozzáad">
				
				</form>
				
			</div>
		</article>
	</div>	
	';
}



//Speicifikusan egy termék jelenik meg
if(is_termek()) {	

	//NO személy
	$szemelyek_edit = "";
	
	
	$result_termek = Query("SELECT * FROM $table_termekek WHERE termek_id=".$termek_id);
	
	$termek = "";
	foreach($result_termek as $termek);
	
	
	//Normal Display
	if($edit_termek == 0) {		
	
		$kiado = Query("SELECT * FROM $table_kiadok WHERE kiado_id=".$termek['KIADO_ID']);
		$szerzo = Query("SELECT * FROM $table_szerzo WHERE szerzo_id=".$termek['SZERZO_ID']);
		
		echo '
			<!-- Home -->
				<div class="wrapper style1 first">
					<article class="container" id="top">
						<div class="row">
							<div class="4u 12u(mobile)">
								<span class="image fit"><img src="'.FindFilmImageById($termek_id).'" alt="" /></span>
							</div>
							<div class="8u 12u(mobile)">
								<header>
									<h1>'.$termek['CIM'].'</h1>
								</header>
								
								<p>Szerző: <a href="szerzo.php?id='.$szerzo[0]['SZERZO_ID'].'">'.$szerzo[0]['SZERZO_NEVE'].'</a></p>
								
								<p>Kiadó: <a href="kiado.php?id='.$kiado[0]['KIADO_ID'].'">'.$kiado[0]['KIADO_NEVE'].'</a></p>
								
								<p>Kiadás éve: '.$termek['KIADAS_EVE'].'</p>
								
								<p>Műfajok: '.$mufajok.'</p>
								
								<p>Ár: '.$termek['AR'].'</p>
								
								<p>Leírás: '.$termek['LEIRAS'].'</p>
								
								
								
								<p>Méret: '.$ekonyvek['MERET'].'</p>
								
								<p>Oldalszám: '.$ekonyvek['OLDALSZAM'].'</p>
								
								<p>Kiterjesztés: '.$ekonyvek['KITERJESZTES'].'</p>
								
								
								

								
								'. (edit_mode() ? '<a href="termek_ekonyv.php?id='.$termek['TERMEK_ID'].'&termek_edit" class="button big scrolly">Szerkesztés</a>' : '' ).'
								
							</div>
						</div>
					</article>
				</div>	
			';
	}
	
	else {
		
		$mufajok_already_id = array();
		
		$result_mufajok = Query("SELECT mufaj_id FROM $table_termekMufaj WHERE termek_id=".$termek['TERMEK_ID']);

		foreach($result_mufajok as $mufaj_id) {
			$mufajok_already_id[] = $mufaj_id['MUFAJ_ID'];
		}


		//Edit mode Display
		$content = '	
		<!-- Home -->
		<form method="post">
			<div class="wrapper style1 first">
				<article class="container" id="top">
					<div class="row">
						<div class="4u 12u(mobile)">
							<span class="image fit"><img src="'.FindFilmImageById($termek_id).'" alt="" /></span>
						</div>
						<div class="8u 12u(mobile)">
							<header>
								Cím:
								<h1><input type="text" name="e_cim" value="'.$termek['CIM'].'" placeholder="'.$termek['CIM'].'"></h1>
							</header>
							
							<p>Kiadás Éve: 
							<input type="text" name="e_kiadas_eve" value="'.$termek['KIADAS_EVE'].'" placeholder="'.$termek['KIADAS_EVE'].'">
							
							<p>Műfajok: 
							<!--<input type="text" name="e_mufaj" value="'. ""
							//$mufajok_edit
							.'" placeholder="'.""
							//$mufajok_edit
							.'">--><br/>
							
							'.GenerateCheckboxesFromMufajok($mufajok_already_id).'
							
							</p>
							
							<p>
							Szerző:
							<!--<input type="text" name="e_szerzo_id" value="1" placeholder="Emberke">-->
							'.GenerateSelectListFromSzerzo($termek['SZERZO_ID']).'
							</p>
							
							<p>
							Kiadó:
							<!--<input type="text" name="e_kiado_id" value="1" placeholder="Kiado">-->
							'.GenerateSelectListFromKiado($termek['KIADO_ID']).'
							</p>
							
							
							
							<p>
							Cselekmény:
							<input type="text" name="e_leiras" value="'.$termek['LEIRAS'].'"></p>
							</p>
							
							
							<p>Ár: 
							<input type="text" name="e_ar" value="'.$termek['AR'].'"></p>
							
							
							<p>Méret: 
							<input type="text" name="e_meret" value="'.$ekonyvek['MERET'].'"></p>
							
							<p>Oldalszám: 
							<input type="text" name="e_oldal" value="'.$ekonyvek['OLDALSZAM'].'"></p>
							
							<p>Kiterjesztés: 
							<input type="text" name="e_kit" value="'.$ekonyvek['KITERJESZTES'].'"></p>
							
							
							
							
							<input type="hidden" name="e_id" value="'.$termek['TERMEK_ID'].'"> 
							
							
							
							
							<input type="submit" class="button big scrolly" id="b_apply_edit" name="termek_apply_edit" value="Szerkesztés Elfogadás">
							
							<input type="submit" class="button big scrolly" id="b_delete" name="termek_delete" value="Törlés">
							
						</div>
					</div>
				</article>
			</div>	
			</form>';
	}
}

//Minden Termék Kilistázása
else {
	
	$content = '
	
	<!-- Termekek -->
	<div class="wrapper style3">
		<article id="portfolio">
			<header>
				<h2>E-Könyv Lista</h2>
			</header>
					
			<div class="container">		
				'.
				$termekek
				.'			
			</div>

		</article>
	</div>
	
	'.
	$edit_mode_no_ekonyv_selected;
}



?>


<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port - <?php if(is_termek()) echo $termek['CIM']; ?></title>
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
				
					echo LinkGenerator('termek_ekonyv.php');
					if(is_termek()) echo '<li><a href="termek_ekonyv.php">E-Könyv Kereső</a></li>'; 
					if(edit_mode() && !is_termek()) echo '<li><a href="#termek_add"><span style="color:RED">Termék Hozzáadás</span></a></li>'; 
					
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
		<script src="assets/js/film.js"></script>

	</body>

</html>