<<<<<<< HEAD
﻿<?php

include("common.php");

if(edit_mode())
{
	session_start();
	set_last_page("index.php");
}



// ###########################
// #  Get Data from Database #
// ###########################
			
	$count = Rand(3,10);
	$elem_row = 3;
	$i = 0;
	
	$termekek = "";
	
	$result_termekek = Query("SELECT * FROM $table_termekek WHERE ROWNUM <= ".$count." ORDER by termek_id DESC");

	//if (mysql_num_rows($result_film) == 0) {
	if (count($result_termekek) == 0) {
		echo "No termek in the Database";
		exit;
	}
	
	
	//while($termek = mysql_fetch_assoc($result_termekek)) 
	foreach($result_termekek as $termek) {
		
		if($i % $elem_row == 0) {
			$termekek .= "<div class='row'>";
		}
		
		$termekek .= CreateFormatRowFromTermekBasic($termek);
		
		$i++;
		
		if($i % $elem_row == 0) {
			$termekek .= "</div>";
		}
	}

	if($i % $elem_row != 0) {
		$termekek .= "</div>";
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
				
					<?php echo LinkGenerator('index.php'); ?>
					
					<li><a href="login.php"><span style="color:<?php echo (session_is_open() ? "GREEN" : "RED"); ?>">Szerkesztés</span></a></li>
				</ul>
			</nav>

		
			
		<!-- Szereplok -->
			<div class="wrapper style3">
				<article id="portfolio">
					<header>
						<h2>Nemrég hozzáadott termékek</h2>
					</header>
							
					<div class="container">
					
						<?php echo $termekek; ?>
									
					</div>

				</article>
			</div>
		
			
		
		<!-- Contact -->
		
		<!--
		
			<div class="wrapper style4">
				<article id="contact" class="container 75%">
					<header>
						<h2>Szeretne Vásárolni?</h2>
						<p>Ornare nulla proin odio consequat sapien vestibulum ipsum sed lorem.</p>
					</header>
					
					<div>
						<div class="row">
							<div class="12u">
								<hr />
								<h3>Find me on ...</h3>
								<ul class="social">
									<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
									<li><a href="#" class="icon fa-linkedin"><span class="label">LinkedIn</span></a></li>
									<li><a href="#" class="icon fa-tumblr"><span class="label">Tumblr</span></a></li>
									<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
									<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
									
								</ul>
								<hr />
							</div>
						</div>
					</div>
					<footer>
						<ul id="copyright">
							<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>
				</article>
			</div>

		 
		-->
		 
			
		
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
=======
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            echo "adatb";
        ?>
    </body>
</html>
>>>>>>> 019349b8229d8a87651969260f947e4b8ceb5500
