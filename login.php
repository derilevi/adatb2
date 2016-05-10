<?php

include("common.php");

	if(edit_mode())
	{
		session_start();
	}


	if(isset($_POST['pw']) && isset($_POST['email'])) 
	{
		echo "GetPW   ". $_POST['pw'] . " ";
		
		$email = $_POST['email'];
		$pw = $_POST['pw'];
		
		if(empty($pw))
		{
			echo "invalid adat";
		}
		else
		{	
			//include("common.php");
			
			$result = Query("SELECT * FROM $table_felhasznalok WHERE email like '$email' AND jelszo like '$pw'");
			
			if(count($result) > 0)
			{
				open_session();
			
				set_right_session(0);
				
				set_user_id_session($result[0]['FELHASZNALO_ID']);
			
				echo "Open session";
				
				header('Location: '.get_last_page());
				exit;
			}	
		}
		
		
		
		
		
		
		
		if($pw == "admin" && $email == "admin") 
		{
			open_session();
			set_right_session(1);
			
			set_user_id_session(0);
			
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
		
			Email:<input type="text" name="email" autofocus>
			Jelszo:<input type="password" name="pw">
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