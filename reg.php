<?php

	$content = "";
	
	include("common.php");
	
	if(isset($_POST['apply'])) {
		
		$email = NVL($_POST['e_email']);
		$jelszo = NVL($_POST['e_jelszo']);
		$teljes_nev = NVL($_POST['e_teljes_nev']);
		$lakcim = NVL($_POST['e_lakcim']);
		$telszam = NVL($_POST['e_telszam']);	
		
		$jogosultsag = 0;
		
		if(empty($email) || empty($jelszo) || empty($teljes_nev) || empty($lakcim) || empty($telszam))
		{
			echo "error";
		}
		else	
		{
			
			Query("INSERT INTO $table_felhasznalok(email, jelszo, teljes_nev, lakcim, telszam, jogosultsag) VALUES ('$email', '$jelszo', '$teljes_nev', '$lakcim', '$telszam', $jogosultsag)");
			
			Header("Location: index.php");
			exit;
		}
		
	}
	else
	{
		$content = '
		
				<h3>Regisztráció</h3>

				<form method="post">

				E-mail: <input type="text" name="e_email">						
				Jelszó: <input type="text" name="e_jelszo">
				Teljes Név: <input type="text" name="e_teljes_nev">
				Lakcím:<input type="text" name="e_lakcim">
				Telefon Szám: <input type="text" name="e_telszam">
				
				<input type="submit" name="apply" value="Regisztráció">
				
				</form>
		';
	}


?>


<!DOCTYPE HTML>

<html>
	
	<head>
		<title>Főoldal Port -</title>
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

				<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Bejelentkezés</span></a></li>
			</ul>
		</nav>

			
		<!-- Content -->
		
		
		<div class="wrapper style1 first">
		
		
		<?php	
			echo $content;
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