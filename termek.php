<?php

if(isset($_GET['id']))
{
	include('common.php');
	
	
	$id = NVL($_GET['id']);
	
	
	if(!empty($id))
	{
		redirect($id, $table_termekek_filmek, "termek_film.php");
		redirect($id, $table_termekek_zenek, "termek_zene.php");
		redirect($id, $table_termekek_konyvek, "termek_konyv.php");
		redirect($id, $table_termekek_ekonyvek, "termek_ekonyv.php");
		
		
		
		header("Location: index.php");
	}
	
	
}

function redirect($id, $table_name, $file) {
	
	include('config.php');
	
	$result = Query("SELECT termek_id FROM $table_name WHERE termek_id=".$id);
	
	if(count($result) > 0)
	{
		header("Location: $file?id=".$id);
		exit;
	}
}

?>