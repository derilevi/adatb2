<?php

include("common.php");

	$aruhaz_list = 0;
	$content = "";
	
	$aruhaz_id = 0;


	//sql stuff here
	if(isset($_POST['apply_from'])) {	
	
		$aruhaz_id = NVL($_POST['aruhaz_id']);
		$termek_id = $_POST['termek_id'];
		//$termek_db = $_POST['termek_db'];
		
		print_r($_POST);
		
		$error = 0;
		
		
		for($i=0; $i<count($termek_id); $i++)
		{
			if($_POST['termek_db_'.$termek_id[$i]] == '0')
			{
				$error = 1;
				break;
			}
		}
		
		
		if($error == 0)
		{
			//sql
			
			for($i=0; $i<count($termek_id); $i++)
			{
				$t_id = $termek_id[$i];
				$db = $_POST['termek_db_'.$termek_id[$i]];
				
				Query("INSERT INTO $table_nyilvantartas(aruhaz_id, termek_id, db) VALUES($aruhaz_id, $t_id, $db)");
			}
			
			
		}
		else
		{
			echo "hiba";
		}
		
		
		
	}

	
	if(isset($_GET['aruhaz_id'])) {
		$aruhaz_id = NVL($_GET['aruhaz_id']);
		
		if(!empty($aruhaz_id))
		{
			$aruhaz_list = 1;
		}


		//delete
		
		if(isset($_POST['update'])) 
		{
			$t_id = $_POST['termek_id'];
			$db = $_POST['db'];
			
			$result = Query("UPDATE $table_nyilvantartas SET db=$db WHERE aruhaz_id=$aruhaz_id AND termek_id=$t_id");
			
		}
		else if(isset($_POST['delete'])) {
			
			$t_id = $_POST['termek_id'];
			
			$result = Query("DELETE FROM $table_nyilvantartas WHERE aruhaz_id=$aruhaz_id AND termek_id=$t_id");
			
		}
		

		
	}
	
	
	
//Insert
if($aruhaz_list == 0) {
	
	$result_aruhaz = Query("SELECT * FROM $table_aruhazak ORDER by aruhaz_id DESC");

	if (count($result_aruhaz) == 0) {
		//echo "No aruhaz at all";
		//exit;
	}
	
	$content = " 

	<div class='8u 12u(mobile)'>
	
	<h1>Termék Aruházhoz valód hozzáadása</h1>
	
	<p>Áruház választó</p>
	<form method='post'>";
	
	
	//while($aruhaz = mysql_fetch_assoc($result_aruhaz)) 
	foreach($result_aruhaz as $aruhaz) {
		//$aruhazk .= CreateFormatRowFromAruhazBasic($aruhaz);
		$content .= 
		"
			<input type='radio' name='aruhaz_id' value='".$aruhaz['ARUHAZ_ID']."'><a href='nyilvantartas.php?aruhaz_id=".$aruhaz['ARUHAZ_ID']."'>".$aruhaz['CIM']."</a><br>
		";
		
	}
	
	
	////////////////////////////////////////////////////

	//termékek
	$result_termek = Query("SELECT * FROM $table_termekek");

	if (count($result_termek) == 0) 
	{
		//echo "No aruhaz at all";
		//exit;
	}
	
	$content .= "<div class='8u 12u(mobile)'>
	<p>Termék választó</p>";
	
	
	//while($aruhaz = mysql_fetch_assoc($result_termek)) 
	foreach($result_termek as $termek) {
		//$aruhazk .= CreateFormatRowFromAruhazBasic($aruhaz);
		$content .= 
		"
			<input type='checkbox' name='termek_id[]' value='".$termek['TERMEK_ID']."'><a href='termek.php?id=".$termek['TERMEK_ID']."'>".$termek['CIM']."</a>
			<input type='text' name='termek_db_".$termek['TERMEK_ID']."' value='0'><br>
			
		";
		
	}
	
	///////////////////////////////////////////////////
	
	
	$content .= "
	
	
	<input type='submit' value='Végrehajt'>
	
	<input type='hidden' name='apply_from'>
	
	</form></div>";
	

}

//List update delete		
else {
	
	$result = Query("SELECT * FROM $table_nyilvantartas WHERE aruhaz_id=$aruhaz_id");
	
	if(count($result) == 0)
	{
		echo "Nincs a nyilvantartasban semmi.";
		exit;
	}
	
	
	$content .= "<h1>Termék Aruházhoz valód hozzáadása</h1>";
	
	foreach($result as $ny)
	{
		$t_id = $ny['TERMEK_ID'];
		$db = $ny['DB'];
		
		
		$result_termek = Query("SELECT * FROM $table_termekek WHERE termek_id=$t_id");
		
		$termek = "";
		foreach($result_termek as $termek);
		
		$termek_nev = $termek['CIM'];  
		
	
		$content .= "<form method='post'><div>";
		
		$content .= "<p>Név: <b>".$termek_nev."</b><br/>";
		$content .= "Darab: <input type='text' name='db' value='$db'>";
		
		$content .= "<input type='submit' id='b_apply_edit' name='update' value='Módosít'>";
		$content .= "<input type='submit' id='b_delete' name='delete' value='Törlés'>";
		
		$content .= "<input type='hidden' name='termek_id' value='$t_id'></p>";
		
		$content .= "</div></form>";
		
	}
	
	$content .= "</form>";
}	
	
	
	
	
	
?>




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
				echo LinkGenerator('nyilvantartas.php');			
			?>	

				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
			</ul>
		</nav>

			
		<!-- Content -->
		
		
		<div class="wrapper style1 first">
		
		
		<?php
		
		if(edit_mode()) {
			session_start();
			set_last_page("nyilvantartas.php");
			
			echo $content;
		}
		else
		{
			
		}
		
		
			
		?>
		
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
