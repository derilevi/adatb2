<?php

include_once("config.php");

function Query($statement) {
	global $localhost;
	
	global $dbtns;

	global $dbuser;
	global $dbpass;

	error_reporting(E_ALL ^ E_DEPRECATED);

	$result = null;
	
	//return 'Oracle Query';

	try
	{
		$conn = new PDO("oci:dbname=".$dbtns, $dbuser, $dbpass);
		
		$qry = $conn->query($statement);
		
		if($qry != false)
		{
			$result = $qry->fetchAll();
		}
		else
		{
			echo print_r($conn->errorInfo());
		}
		
		//echo 'Dual table records: '.$result['CNT'].'<br>';	
		//var_dump($rec);
	}
	catch(PDOException $e)
	{
		echo ("Exception: " . $e->getMessage());
	}

	return $result;
}


$pages = array(
    "index.php" => "Főoldal",
	
	"termek_zene.php" => "Zene Kereső",
	"termek_film.php" => "Film Kereső",
	"termek_ekonyv.php" => "E-konyv Kereső",
	"termek_konyv.php" => "Könyv Kereső",
	
    "szerzo.php" => "Szerző Kereső",
    "kiado.php" => "Kiadó Kereső",
	"mufaj.php" => "Műfaj Kereső",
	"aruhaz.php" => "Áruház Kereső"
);


//Helper Functions

//Navigator Link Generator
function LinkGenerator($exception) {
	$output = "";
	
	global $pages;
	
	foreach($pages as $key => $value) {
		if($key == $exception || $value == $exception) {
			continue;
		}
		
		$output .= "<li><a href='$key'>$value</a></li>";
	}
	
	
	return $output;
}



//PHP
function NVL($v) {
	return isset($v) ? $v : "";
}



//HTML Select LIST
function GenerateSelectListFromSzerzo($selected_id=-1) {
	global $table_szerzo;
	
	$result_szerzok = Query("SELECT * FROM $table_szerzo");
	
	$output = "<select name='e_szerzo_id'>";
	
	foreach($result_szerzok as $szerzo)
	{
		$output .= "<option ".($szerzo['SZERZO_ID'] == $selected_id ? "selected" : "" )."  value='".$szerzo['SZERZO_ID']."'>".$szerzo['SZERZO_NEVE']."</option>";
	}
	
	$output .= "</select>";	
	
	return $output;
}

function GenerateSelectListFromKiado($selected_id=-1) {
	global $table_kiadok;
	
	$result_kiadok = Query("SELECT * FROM $table_kiadok");
	
	$output = "<select name='e_kiado_id'>";
	
	foreach($result_kiadok as $kiado)
	{
		$output .= "<option ".($kiado['KIADO_ID'] == $selected_id ? "selected" : "" )."  value='".$kiado['KIADO_ID']."'>".$kiado['KIADO_NEVE']."</option>";
	}
	
	$output .= "</select>";	
	
	return $output;
}

function GenerateSelectListFromMufaj($name, $include_null=false, $selected_id=-1) {
	global $table_Mufaj;
	
	$result_mufajok = Query("SELECT * FROM $table_Mufaj");
	
	$output = "<select name='$name'>";
	
	if($include_null==true)
	{
		$output .= "<option value='-1'>NULL</option>";
	}
	
	foreach($result_mufajok as $mufaj)
	{
		$output .= "<option ".($mufaj['MUFAJ_ID'] == $selected_id ? "selected" : "" )."  value='".$mufaj['MUFAJ_ID']."'>".$mufaj['MUFAJ_NEV']."</option>";
	}
	
	$output .= "</select>";	
	
	return $output;
}



//HTML Checkbox LIST
function GenerateCheckboxesFromMufajok($checked_arr_ids=null) {
	global $table_Mufaj;
	
	$result_mufajok = Query("SELECT * FROM $table_Mufaj");
	
	$output = "";
	
	foreach($result_mufajok as $mufaj)
	{
		$checked = "";
		if($checked_arr_ids != null)
			foreach($checked_arr_ids as $c_id)
			{
				if($c_id == $mufaj['MUFAJ_ID'])
				{
					$checked = "checked";
				}
			}
		
		$output .= "<input type='checkbox' name='e_mufajok[]' value='".$mufaj['MUFAJ_ID']."' $checked/>".$mufaj['MUFAJ_NEV']."<br>";
	}
	
	$output .= "";	
	
	return $output;
}




//GOOD
function CreateFormatRowFromTermekBasic($termek) {
	$hyper = "termek.php?id=".$termek['TERMEK_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($termek['TERMEK_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$termek['CIM'].'</a></h3>
				</article>
			</div>';
}


//GOOD
function CreateFormatRowFromKiadoBasic($kiado) {
	$hyper = "kiado.php?id=".$kiado['KIADO_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindKiadoImageById($kiado['KIADO_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$kiado['KIADO_NEVE'].'</a></h3>
				</article>
			</div>';
}


//GOOD
function FindKiadoImageById($id, $name = "cover.jpg") {	
	$cover = "images/Studio/cover.jpg";		//default
	
	if(is_file("images/Studio/".$id."/".$name))
	{
		$cover = "images/Studio/".$id."/".$name;
	}
	
	return $cover;
}


//GOOD
function CreateFormatRowFromSzerzoBasic($szerzo) {
	$hyper = "szerzo.php?id=".$szerzo['SZERZO_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindSzerzoImageById($szerzo['SZERZO_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$szerzo['SZERZO_NEVE'].'</a></h3>
				</article>
			</div>';
}




function CreateFormatRowFromFilmBasic($termek, $film) {
		$hyper = "termek_film.php?id=".$termek['TERMEK_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($termek['TERMEK_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$film['CIM'].'</a></h3>
				</article>
			</div>';
}

function CreateFormatRowFromEkonyvBasic($termek, $ekonyv) {
		$hyper = "termek_ekonyv.php?id=".$termek['TERMEK_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($termek['TERMEK_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$ekonyv['CIM'].'</a></h3>
				</article>
			</div>';
}

function CreateFormatRowFromKonyvBasic($termek, $konyv) {
		$hyper = "termek_konyv.php?id=".$termek['TERMEK_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($termek['TERMEK_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$konyv['CIM'].'</a></h3>
				</article>
			</div>';
}

function CreateFormatRowFromZeneBasic($termek, $zene) {
		$hyper = "termek_zene.php?id=".$termek['TERMEK_ID']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($termek['TERMEK_ID']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$zene['CIM'].'</a></h3>
				</article>
			</div>';
}






////////////////////////////////////////////////////////


function FindSzerzoImageById($id, $name="cover.jpg") {	
	$cover = "images/Szemely/cover.jpg";	//default
	
	if(is_file("images/Szemely/".$id."/".$name))
	{
		$cover = "images/Szemely/".$id."/".$name;
	}
	
	return $cover;
}

function FindFilmImageById($id, $name = "cover.jpg") {	
	$cover = "images/Film/cover.jpg";		//default
	
	if(is_file("images/Film/".$id."/".$name))
	{
		$cover = "images/Film/".$id."/".$name;
	}
	
	return $cover;
}












function CreateFormatRowFromFilm($film) {
	$hyper = "film.php?id=".$film['f_id']."";

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindFilmImageById($film['f_id']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$film['cim'].'</a></h3>
					<p>Rendező</p>
				</article>
			</div>';
}


function CreateFormatRowFromSzerepel($szerepel) {
	$hyper = "szemely.php?id=".$szerepel['sz_id']."";

	$result_szemely = Query("SELECT * FROM Szemely WHERE sz_id=".$szerepel['sz_id']);
	$szemely = mysql_fetch_assoc($result_szemely);

	//print_r($szemely);
	
	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindSzerzoImageById($szemely['sz_id']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$szemely['nev'].'</a></h3>
					<h3>'.$szerepel['karakter_nev'].'</h3>
				<p>Karakter: '.$szerepel['szerep'].'</p>
				</article>
			</div>';
}




function CreateFormatRowFromTermek($termek) {
	$hyper = "termek.php?id=".$termek['TERMEK_ID']."";

	$result_film = Query("SELECT * FROM $table_termekek WHERE termek_id=".$szerepel['f_id']);

	$film = "";
	foreach($result_film as $film);

	return '<div class="4u 12u(mobile)">
				<article class="box style2">
					<a href="'.$hyper.'" class="image featured"><img src="'.FindTermekImageById($film['f_id']).'" alt="" /></a>
					<h3><a href="'.$hyper.'">'.$film['nev'].'</a></h3>
					<h3>'.$szerepel['karakter_nev'].'</h3>
					<p>Karakter: '.$szerepel['szerep'].'</p>
				</article>
			</div>';
}



function CreateFormatRowFromMufaj($mufaj, $editMode=0) {
	$hyper = "mufaj.php?id=".$mufaj['MUFAJ_ID']."";
	
	
	$hyperDel = "";
	
	if($editMode == 1)
	{
		$hyperDel = "mufaj.php?id=".$mufaj['MUFAJ_ID']."&del";
	}
	
	
	
	return '<div class="4u 12u(mobile)">
			<article class="box style2">
				<h3><a href="'.$hyper.'">'.$mufaj['MUFAJ_NEV'].'</a></h3>
				
				'.($editMode == 1 ? '<span><a href="'.$hyperDel.'">Törlés</a></span>' : '').'
				
			</article>
		</div>';
}





function CreateFormatRowFromSzerepelEdit($szemelyID, $filmID, $filmek, $szerepel) {
	$selectFilm = "<select name='e_film_id'>";	
	foreach($filmek as $film)
	{
		//print_r($film);
		
		$selectFilm .= "<option ".($film['f_id'] == $filmID ? "selected" : "" )."  value='".$film['f_id']."'>".$film['cim']."</option>";
	}
	$selectFilm .= "</select>";	
	
	
	return '<div class="4u 12u(mobile)">
			<form method="POST">
				<article class="box style2">
				
					'.$selectFilm.'
				
					<h3>Karakter: <input type="text" name="e_karakter" value="'.$szerepel['karakter_nev'].'" placeholder="'.$szerepel['karakter_nev'].'"></h3>
					<p>Szerep: <input type="text" name="e_szerep" value="'.$szerepel['szerep'].'" placeholder="'.$szerepel['szerep'].'"></p>
					
					
					
					<input type="hidden" name="sz_id" value='.$szemelyID.'>
					<input type="hidden" name="f_id" value='.$filmID.'>
					<input type="hidden" name="edit_apply">
					
					<input type="submit" class="button big scrolly" id="b_apply_edit" name="szerep_apply_edit" value="Szerkesztés Elfogadás">
									
					<input type="submit" class="button big scrolly" id="b_delete" name="szerep_delete" value="Törlés">
					
					
				</article>
			</form>
			</div>';
}



function CreateFormatRowFromSzerepelNew($szemelyID, $filmek) {
	$selectFilm = "<h3>Új Szereplés hozzáadás</h3><select name='n_film_id'>";	
	foreach($filmek as $film)
	{
		$selectFilm .= "<option value='".$film['f_id']."'>".$film['cim']."</option>";
	}
	$selectFilm .= "</select>";	
	
	
	return '<div class="4u 12u(mobile)">
			<form method="POST">
				<article class="box style2">
				
					'.$selectFilm.'
				
					<h3>Karakter név: <input type="text" name="n_karakter" value="" placeholder=""></h3>
					<p>Szerep: <input type="text" name="n_szerep" value="" placeholder=""></p>
					
					<input type="hidden" name="sz_id" value='.$szemelyID.'>
					<input type="hidden" name="new_szerepel_apply">
					
					<input type="submit" class="button big scrolly" id="b_apply_new" name="szerep_apply_edit" value="Hozzáadás">
									
					
				</article>
			</form>
			</div>';
}



function CreateFormatRowFromRendezNew($szemelyID, $filmek, $studiok) {
	$selectFilm = "<h3>Új Rendezés hozzáadás</h3><select name='n_film_id'>";	
	foreach($filmek as $film)
	{
		$selectFilm .= "<option value='".$film['f_id']."'>".$film['cim']."</option>";
	}
	$selectFilm .= "</select>";	
	
	
	$selectStudio = "<select name='n_studio_id'>";
	foreach($studiok as $studio)
	{
		//print_r($studio);
		
		$selectStudio .= "<option value='".$studio['studio_id']."'>".$studio['nev']."</option>";
	}
	$selectStudio .= "</select>";	
	
	
	return '<div class="4u 12u(mobile)">
			<form method="POST">
				<article class="box style2">
				
					'.$selectFilm.'
					
					'.$selectStudio.'
					
					<input type="hidden" name="sz_id" value='.$szemelyID.'>
					<input type="hidden" name="new_rendez_apply">
					
					<input type="submit" class="button big scrolly" id="b_apply_new" name="szerep_apply_edit" value="Hozzáadás">
									
					
				</article>
			</form>
			</div>';
}


function CreateFormatRowFromRendezEdit($szemelyID, $rendez) {
		return '<div class="4u 12u(mobile)">
			<form method="POST">
				<article class="box style2">

				
					<h3>'.$rendez['f_id'].'</h3>
				
					<input type="hidden" name="sz_id" value='.$szemelyID.'>
					<input type="hidden" name="f_id" value='.$rendez['f_id'].'>
					<input type="hidden" name="edit_apply">
								
					<input type="submit" class="button big scrolly" id="b_delete" name="rendez_delete" value="Törlés">		
					
				</article>
			</form>
			</div>';
}













//Sessions

function open_session() {
     
	session_start(['cookie_lifetime' => (10*60),]);
	 
	setcookie("edit", 1, time()+(10*60));  /* expire in 10 minutes */
	 
	 
	global $_SESSION;
    $_SESSION['is_open'] = TRUE;
}

function close_session() {
   session_write_close();
   
   global $_COOKIE;
   
   setcookie("edit", 0, 0);
   
   global $_SESSION;
   $_SESSION['is_open'] = FALSE;
}

function destroy_session() {
   session_destroy();
   
   global $_COOKIE;
   
   setcookie("edit", 0, 0);
   
   global $_SESSION;
   $_SESSION['is_open'] = FALSE;
}

function session_is_open() {
	
	global $_SESSION;
	return(isset($_SESSION['is_open']) && $_SESSION['is_open']);
}


//LoggedIN And User access level gt 1

function edit_mode() {
	global $_COOKIE;
	return (isset($_COOKIE['edit']) && $_COOKIE['edit'] == 1);
}



//automatic page redirect

function get_last_page() {
	global $_SESSION;
	return isset($_SESSION['last_page']) ? $_SESSION['last_page'] : "index.php";
}

function set_last_page($l) {
	global $_SESSION;
	$_SESSION['last_page'] = $l;
}



//kosar

function get_kosar() {
	global $_SESSION;
	return $_SESSION['kosar'];
}

//kosar Item
// - ID
// - NEV
// - ar
// - mennyiseg
function add_kosar($id, $nev, $ar, $menny) {
	global $_SESSION;
	
	$item = array(
		"ID" => $id,
		"NEV" => $nev,
		"AR" => $ar,
		"MENNY" => $menny
	);
	
	if($_SESSION['kosar'] == null)
	{
		$_SESSION['kosar'] = array();
	}
	
	$_SESSION['kosar'][] = $item;
}


function clear_kosar() {
	global $_SESSION;
	
	$_SESSION['kosar'] = null;
}


//SQL HERE








?>