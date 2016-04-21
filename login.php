<?php

include("common.php");

	if(edit_mode())
	{
		session_start();
	}


	if(isset($_POST['pw'])) {
		echo "GetPW   ". $_POST['pw'] . " ";
		
		if($_POST['pw'] == "admin") {
			open_session();
			
			echo "Open session";
			
			header('Location: '.get_last_page());
			exit;
		}
		else {
			
			echo "Close session _ 1";
			
			if(session_is_open())
			{
				close_session();
			}
		}
	}



	if(!edit_mode() && session_is_open() == false) {
		
		echo '
		<body align="center" style="background-color: GREY; margin-top: 200px">
		<div>
		
		<form method="post">
		
			Password:<input type=password id="pw" name="pw" autofocus>
			<input type="submit" value="Submit">
		
		</form>
		</body>
		
		</div>
		';	
	}
	else {
		echo "Close session _ 2";
		
		close_session();
		header('Location: '.get_last_page());	
	}



?>