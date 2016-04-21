<?php

include("common.php");

if(edit_mode())
{
	session_start();
	set_last_page("film.php");
}

//Insert new Movie AND/OR Director
if(isset($_POST['add_film']))
{
	//Film
	$cim = $_POST['cim'];
	$cselekmeny = $_POST['cselekmeny'];
	$ido = $_POST['ido'];
	$premier = $_POST['premier'];
	$besorolas = $_POST['besorolas'];
	
	//Rendezo
	$rendezo_nev = $_POST['rendezo_nev'];
	$rendezo_bio = $_POST['rendezo_bio'];
	$rendezo_date = $_POST['rendezo_date'];
	$rendezo_NEW = isset($_POST['rendezo_new']) ? $_POST['rendezo_new'] : "";
	
	//studio
	$studio_id = $_POST['studio_id'];
	
	$rendezo_id = -1;
	$film_id = -1;
	
	///Add new Rendezo
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
	

	
	if(empty($cim) || empty($cselekmeny) || empty($ido) || empty($premier) || empty($besorolas))
	{
		//Should drop error
	}
	else
	{
		$insert_film_result = Query("INSERT INTO Film(cim,cselekmeny,ido_tartam,megjelent,besorolas) VALUES('$cim','$cselekmeny','$ido','$premier',$besorolas)");
		
		$insert_filmID_result = Query("SELECT f_id FROM Film ORDER BY f_id DESC LIMIT 1");
		$film_id = mysql_fetch_assoc($insert_filmID_result);	
	}
	
	
	
	//Succes Film and Rendezo
	if($film_id != -1 && $rendezo_id != -1 && $studio_id != -1)
	{
		$f_id = $film_id['f_id'];
		$r_id = $rendezo_id['sz_id'];
		
		$insert_connection = Query("INSERT INTO Rendez(studio_id,f_id,rendezo_id) VALUES($studio_id,$f_id,$r_id)");
	}
}


$edit_film = 0;

if(edit_mode() && isset($_GET['film_edit']))
{
	$edit_film = 1;
}


if(edit_mode() && isset($_POST['film_delete']))
{
	$film_id = $_GET['id'];
	
	$delete_film_result = Query("DELETE FROM Film WHERE f_id=".$film_id);
	
	header("Location: film.php");
}

if(edit_mode() && isset($_POST['film_apply_edit']))
{
	$edit_film = 0;
	
	$film_id = $_GET['id'];
	
	$cim = isset($_POST['e_cim']) ? $_POST['e_cim'] : "";
	$rendezo_nev = isset($_POST['e_rendezo']) ? $_POST['e_rendezo'] : "";
	$mufajok = isset($_POST['e_mufaj']) ? $_POST['e_mufaj'] : "";
	$e_megjelent = isset($_POST['e_megjelent']) ? $_POST['e_megjelent'] : "";
	$ido = isset($_POST['e_ido']) ? $_POST['e_ido'] : "";
	$besorolas = isset($_POST['e_besorolas']) ? $_POST['e_besorolas'] : "";
	$cselekmeny = isset($_POST['e_cselekmeny']) ? $_POST['e_cselekmeny'] : "";
	
	//print_r($_POST);
	
	
	if(empty($cim) || empty($rendezo_nev) || empty($mufajok) || empty($e_megjelent) || empty($ido) || empty($besorolas) || empty($cselekmeny))
	{
		//ERROR
		echo 'err Valami ures';
		/*
		echo $cim ."<br/>";
		echo $rendezo_nev ."<br/>";
		echo $mufajok ."<br/>";
		echo $e_megjelent ."<br/>";
		echo $ido ."<br/>";
		echo $besorolas ."<br/>";
		echo $cselekmeny ."<br/>";
		*/
	}
	else
	{
		//print_r($_POST);
		
		//update FILM Data
		$result_film_update = Query("UPDATE Film SET cim='".$cim."', megjelent='".$e_megjelent."', ido_tartam='".$ido."', besorolas='".$besorolas."', cselekmeny='".$cselekmeny."' WHERE f_id=".$film_id);
		
		
		//update rendezo
		$result_rendezo = Query("SELECT * FROM Szemely WHERE nev like '".$rendezo_nev."'");
		
		//Rendezo benne van az adatbazisban
		if(mysql_num_rows($result_rendezo) > 0)
		{
			$rendezo_edit = mysql_fetch_assoc($result_rendezo);
			
			//here
			$result_rendez = Query("UPDATE Rendez SET rendezo_id=".$rendezo_edit['sz_id']." WHERE f_id=".$film_id);
					
			//Should Notify the user
			if(mysql_affected_rows() > 0)
			{
				echo "<br/> update Rendezo";
			}
			else
			{
				//echo "<br/>ERR update Rendezo, Insert New";
				//Query("INSERT INTO Rendez SET rendezo_id=".$rendezo_edit['sz_id'].", f_id=".$film_id);
			}
			
		}

		//update mufaj
		
		$select_already_mufajok_id = Query("SELECT mufaj_id FROM FilmMufajok WHERE f_id=".$film_id);
		
		$already_mufajok = array();
		
		while($sor = mysql_fetch_assoc($select_already_mufajok_id))
		{
			$already_mufajok[] = $sor['mufaj_id'];
		}
		
		//echo "Meglevo";
		//print_r($already_mufajok);
		
		
		
		//szetszedjuk a megadottakat
		$mufajSep = explode(" ", $mufajok);
			
		//jelenleg nincs mufaj hozzaadva
		if(mysql_num_rows($select_already_mufajok_id) == 0)
		{
			foreach($mufajSep as $m)
			{
				Query("INSERT INTO FilmMufajok SET f_id=".$film_id.", mufaj_id=(SELECT id FROM Mufaj WHERE mufaj like '".$m."')");
				
				echo "INSERT_ZERO: ". $m ." ";
			}
		}
		else
		{
			$edit_mufajok_id = array();
			foreach($mufajSep as $eMufajNev)
			{
				//echo  $eMufajNev."\n";
				
				$select_edit_mufaj = Query("SELECT * FROM Mufaj WHERE mufaj like '".$eMufajNev."'");

				while($sor = mysql_fetch_assoc($select_edit_mufaj))
				{
					$edit_mufajok_id[] = $sor['id'];
				}
			}
			
			//echo "Edit: \n";
			//print_r($edit_mufajok_id);
			//Delete Not in edited
			foreach($already_mufajok as $alreadyMufajID)
			{
				if(in_array($alreadyMufajID, $edit_mufajok_id) == false)
				{
					echo "DEL(".$alreadyMufajID.")\n";
					Query("DELETE FROM FilmMufajok WHERE f_id=".$film_id." AND mufaj_id=".$alreadyMufajID);
					
				}
			}
			
			//Add Not in Old
			foreach($edit_mufajok_id as $edit_id)
			{
				if(in_array($edit_id, $already_mufajok) == false)
				{
					echo "ADD(".$edit_id.")\n";
					Query("INSERT INTO FilmMufajok SET mufaj_id=".$edit_id.", f_id=".$film_id);
				}
			}
		}
		
	
		
	}
	
	
}



//studio
if(isset($_POST['apply_edit_studio']))
{
	//echo "UPDATED RENDEz";
	
	$f_id = $_POST['f_id'];
	$e_studio_id = $_POST['e_studio_id'];
	
	
	Query("UPDATE Rendez SET studio_id=".$e_studio_id." WHERE f_id=".$f_id);
	
	$edit_mode = 0;
}


if(edit_mode() && isset($_GET['edit_studio']))
{
	$film_id = $_GET['id'];
	
	$studio_id = -1;
	
	$result_find_studio_id = Query("SELECT studio_id FROM Rendez WHERE f_id=".$studio_id);
	$studio_id = mysql_fetch_assoc($result_find_studio_id);
	$studio_id = $studio_id['studio_id'];
	
	
	//All studiok
	$allStudio = array();
	$studiok_result = Query("SELECT * FROM Studio");
	while($sor = mysql_fetch_assoc($studiok_result))
	{
		$allStudio[] = $sor;
	}
	
	$selectStudio = "<select name='e_studio_id'>";
	foreach($allStudio as $studio)
	{
		//print_r($studio);
		
		$selectStudio .= "<option  ".($studio['studio_id'] == $studio_id ? "selected" : ""  )."  value='".$studio['studio_id']."'>".$studio['nev']."</option>";
	}
	$selectStudio .= "</select>";	
	
	echo 
	'
	<form action="film.php?id='.$film_id.'" method="post">
	
		'.$selectStudio.'
		
		<input type="hidden" name="f_id" value="'.$film_id.'">
		<input type="hidden" name="apply_edit_studio">
		<input type="submit" value="Szerkeszt">
	
	</from>
	
	
	';
	
	exit;
}








function is_f()
{
	global $film_id;
	return $film_id != -1;
}

$film_id = -1;

if(isset($_GET['id']) && $_GET['id'] != null)
{
	$film_id = $_GET['id'];
	set_last_page("film.php?id=".$film_id);
}
else
{
	//exit;
}

include("date_formater.php");


if(is_f())
{

// ###########################
// #  	Film Adatai			 #
// ###########################
		
	$result_film = Query("SELECT * FROM Film WHERE f_id=".$film_id);
	
	if (mysql_num_rows($result_film) == 0)
	{
		echo "NO Film";
		exit;
	}
	
	$film = mysql_fetch_assoc($result_film);
	
	
// ###########################
// # Filmhez kapcsoló műfajok #
// ###########################

	$mufajok = "";
	$mufajok_edit = "";
	
	$i=0;

	$result_mufajID = Query("SELECT mufaj_id FROM FilmMufajok WHERE f_id=".$film_id);
	
	while($mufajID = mysql_fetch_assoc($result_mufajID))
	{
		$result_mufaj = Query("SELECT * from Mufaj where id=".$mufajID['mufaj_id']);
		$max_mufaj = mysql_num_rows($result_mufaj);
		
		while ($mufaj = mysql_fetch_assoc($result_mufaj)) 
		{
			$mufajok .= "<a href='mufaj.php?id=".$mufaj['id']."'>".$mufaj['mufaj']."</a>";
			
			$mufajok_edit .= $mufaj['mufaj']." ";
			
			$i++;
			
						
			if($i+1 != $max_mufaj)
			{
				$mufajok .= " | ";
			}
			

		}
	}
	
	
// ###########################
// #        Szereplők        #
// ###########################
	
	$result_szereplo = Query("SELECT * FROM Szerepel WHERE f_id=".$film_id);
	
	
	if (mysql_num_rows($result_szereplo) == 0)
	{
		echo "No Szereplo";
	}
	
	
	$szereplok = "";
	$elem_row = 3;
	$i = 0;
	
	
	while($row = mysql_fetch_assoc($result_szereplo))
	{
		if($i % $elem_row == 0) 
		{
			$szereplok .= "<div class='row'>";
		}
		
		$szereplok .= CreateFormatRowFromSzerepel($row);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$szereplok .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0)
	{
		$szereplok .= "</div>";
	}
	
	
// ###########################
// #        Rendezés        #
// ###########################

$rendezes = "";

	$result_rendez = Query("SELECT * FROM Rendez WHERE f_id=".$film_id);
	$rendezes = mysql_fetch_assoc($result_rendez);
	
	
// ###########################
// #        Rendező        #
// ###########################

$rendezo = "";
$rendezo_id = "";
$rendezo_nev = "";


// ###########################
// #        Studio           #
// ###########################

$studio = "";
$studio_nev = "";
$studio_alapitas = "";
$studio_id = "";

	if (!empty($rendezes) && mysql_num_rows($result_rendez) > 0)
	{
		$result_rendezo = Query("SELECT * FROM Szemely WHERE sz_id=".$rendezes['rendezo_id']);
		$rendezo = mysql_fetch_assoc($result_rendezo);
		
		$rendezo_id = $rendezo['sz_id'];
		$rendezo_nev = $rendezo['nev'];

		
		
		if($rendezes['studio_id'] != null)
		{
			$result_studio = Query("SELECT * FROM Studio WHERE studio_id=".$rendezes['studio_id']);
			$studio = mysql_fetch_assoc($result_studio);
			
			$studio_nev =  $studio['nev'];
			$studio_alapitas = $studio['alapitas_ev'];
		}
		else	
		{
			$studio_nev =  "Nincs beallitva";
			$studio_alapitas = "Nincs beallitva";
		}
	}
	
	
}
else
{
// ###########################
// #  Get Data from Database #
// ###########################
			
	$elem_row = 3;
	$i = 0;
	

	$filmek = "";
	
	$result_film = Query("SELECT * FROM Film ORDER by f_id DESC");

	if (mysql_num_rows($result_film) == 0) {
		echo "No Film at all";
		exit;
	}
	
	
	while($film = mysql_fetch_assoc($result_film)) 
	{
		if($i % $elem_row == 0) 
		{
			$filmek .= "<div class='row'>";
		}
		
		$filmek .= CreateFormatRowFromFilmBasic($film);
		
		$i++;
		
		if($i % $elem_row == 0) 
		{
			$filmek .= "</div>";
		}
	}
	
	
	if($i % $elem_row != 0)
	{
		$filmek .= "</div>";
	}
	
	
	$edit_mode_no_film_selected = "";

	if(edit_mode())
	{
		$allStudio = array();
		$studiok_result = Query("SELECT * FROM Studio");
		while($sor = mysql_fetch_assoc($studiok_result))
		{
			$allStudio[] = $sor;
		}
		
		$selectStudio = "Studió választás<select name='studio_id'>";
		foreach($allStudio as $studio)
		{
			$selectStudio .= "<option value='".$studio['studio_id']."'>".$studio['nev']."</option>";
		}
		$selectStudio .= "</select>";
		
		
		
		$edit_mode_no_film_selected =  '
		
						<div class="wrapper style4">
						<article class="container" id="film_add">
							<div class="row">
								<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindFilmImageById($film_id).'" alt="" /></span>
								</div>

								<form method="post">
		
									<h3>Film adatai</h3>
		
									Cím: <input type="text" name="cim">						
									Cselekmény: <input type="text" name="cselekmeny">
									Besorolás: <input type="text" name="besorolas">
									Játék idő:<input type="time" name="ido">
									Premier dátum: <input type="date" name="premier"><br/>
								
									<input type="hidden" name="add_film">
								
									Új hozzáadása? <input id="AddNewRendezo" type="checkbox" name="rendezo_new">	
									Rendező Név: <input type="text" name="rendezo_nev">	
									
									
									<!-- Rendezo -->
									<div id="cNewRendezo">
										<h3>Rendező adatai</h3>
										<span>Rendező Bio: <input type="text" name="rendezo_bio"></span>
										<span>Rendező Szuletés: <input type="date" name="rendezo_date"></span>
									</div>
								
									<!-- Studio -->
									'.$selectStudio.'
								
								
								
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
		<title>IMDB Port - <?php if(is_f()) echo $film['cim']; ?></title>
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
				<ul 
				class="container">
					<li><a href="index.php">IMDB</a></li>
				
					<?php if(is_f()) echo '<li><a href="film.php">Film</a></li>'; ?>	
					<?php if(edit_mode() && !is_f()) echo '<li><a href="#film_add">Film hozzáadás</a></li>'; ?>	
					<?php if(is_f()) echo '<li><a href="#portfolio">Szereplők</a></li>'; else  echo '<li><a href="szemely.php">Személy Kereső</a></li>'; ?>
					<?php if(is_f()) echo '<li><a href="#work">Studió</a></li>'; else echo '<li><a href="studio.php">Studió Kereső</a></li>'; ?>
					
					<li><a href="mufaj.php">Műfaj Kereső</a></li>
					
					<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
				</ul>
			</nav>
		
		
		
		<?php
		if(is_f())
		{	
	
			$szemelyek_edit = "<select name='e_rendezo'>";
			
			$result_szemelyek = Query("SELECT * FROM Szemely");
			while($szemely = mysql_fetch_assoc($result_szemelyek))
			{
				$szemelyek_edit .= "<option " . ($rendezo_nev == $szemely['nev'] ? "selected='selected'" : "") . "   VALUE='".$szemely['nev']."'>".$szemely['nev']."</option>";
			}
	
	
			$szemelyek_edit .= "</select>";
	
	
			if($edit_film == 0)
			echo '
				<!-- Home -->
					<div class="wrapper style1 first">
						<article class="container" id="top">
							<div class="row">
								<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindFilmImageById($film_id).'" alt="" /></span>
								</div>
								<div class="8u 12u(mobile)">
									<header>
										<h1>'.$film['cim'].'</h1>
									</header>
									
									<p>Műfajok: '.$mufajok.'</p>
									
									<p>Rendezte: <a href=szemely.php?id='.$rendezo_id.'>'.$rendezo_nev.'</a></p>
									
									<p>Játék idő: '.$film['ido_tartam'].'</p>
									
									<p>Premier: '.FormatDate($film['megjelent']).'</p>
									
									<p>Besorolás: '.$film['besorolas'].'</p>
									
									
									
									
									<p>Celekmény: '.$film['cselekmeny'].'</p>
									

									'. (edit_mode() ? '<a href="film.php?id='.$film['f_id'].'&film_edit" class="button big scrolly">Szerkesztés</a>' : '' ).'
								</div>
							</div>
						</article>
					</div>	
				';
				else
					echo 
					'
					
				<!-- Home -->
				<form method="post">
					<div class="wrapper style1 first">
						<article class="container" id="top">
							<div class="row">
								<div class="4u 12u(mobile)">
									<span class="image fit"><img src="'.FindFilmImageById($film_id).'" alt="" /></span>
								</div>
								<div class="8u 12u(mobile)">
									<header>
										<h1><input type="text" name="e_cim" value="'.$film['cim'].'" placeholder="'.$film['cim'].'"></h1>
									</header>
									
									<p>Műfajok: 
									<input type="text" name="e_mufaj" value="'.$mufajok_edit.'" placeholder="'.$mufajok_edit.'">
									
									
									
									'.$szemelyek_edit.'
									
									
									<!--<input type="text" name="e_rendezo" value="'.$rendezo_nev.'" placeholder="'.$rendezo_nev.'">-->
									
									
									
									<p>Játék idő: <input type="time" name="e_ido" value="'.$film['ido_tartam'].'">
									
									</p>
									
									
									<p>
									Cselekmény:
									<input type="text" name="e_cselekmeny" value="'.$film['cselekmeny'].'"></p>
									</p>
									
									<p>Premier: 
									<input type="date" name="e_megjelent" value="'.$film['megjelent'].'"></p>
									
									<p>Besorolás: 
									<input type="text" name="e_besorolas" value="'.$film['besorolas'].'"></p>
									
									
									<input type="submit" class="button big scrolly" id="b_apply_edit" name="film_apply_edit" value="Szerkesztés Elfogadás">
									
									<input type="submit" class="button big scrolly" id="b_delete" name="film_delete" value="Törlés">
									
								</div>
							</div>
						</article>
					</div>	
					</form>
					
					';
				
				
				
				echo '				
				<!-- Szereplok -->
					<div class="wrapper style3">
						<article id="portfolio">
							<header>
								<h2>Szereplők</h2>
								<p></p>
							</header>
							
							
							<div class="container">	
								'.$szereplok.'
							</div>
							
							
							<footer>
								<p></p>
							</footer>
						</article>
					</div>
				
					
					
					
					
				<!-- Studio -->
					<div class="wrapper style2">
						<article id="work">
							<header>
								<h2>Studio</h2>
							</header>
							<div class="container">
							
								<div class="row">
									<div class="4u 12u(mobile)">
										<section class="box style1">
											<span class="icon featured fa-industry"></span>
											<h3>'.$studio_nev.'</h3>
										</section>
									</div>
									
									<div class="4u 12u(mobile)">
										<section class="box style1">
											<span class="icon featured fa-calendar-plus-o"></span>
											<h3>Alapítva: '.$studio_alapitas.'</h3>
										</section>
									</div>
									
									<div class="4u 12u(mobile)">
										<section class="box style1">
											<span class="icon featured fa-usd"></span>
											<h3>Bevétel: '.Rand(1,999). ' ' .Rand(0,999). ' ' .Rand(0,999) .' $</h3>
										</section>
									</div>
									
								</div>
							</div>
							
							<footer>
							
								'. (edit_mode() ? '<a href="film.php?id='.$film_id.'&edit_studio" class="button big scrolly">Szerekesztés</a>' : '<a href="studio.php?id='.$studio_id.'" class="button big scrolly">Studio berkeiben készített filmek</a>' ).'
							
							</footer>
							
						</article>
					</div>

				';
		}
		
		else
		{
			echo '
			
			<!-- Filmek -->
			<div class="wrapper style3">
				<article id="portfolio">
					<header>
						<h2>Film Lista</h2>
					</header>
							
					<div class="container">		
						'.$filmek.'			
					</div>

				</article>
			</div>
			
			'.$edit_mode_no_film_selected.'
			
			
			';
		}
		
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