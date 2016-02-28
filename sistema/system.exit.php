<?php

	if (!isset($_SESSION)) {
		session_start();	
	}

		if (isset($_SESSION[' YROSS_token '])) {
		    unset($_SESSION[' YROSS_token ']);
		}
		
		unset($_COOKIE["PHPSESSID"]);
		
		unset($_COOKIE);
		
		session_unregister("usuario");
		
		session_destroy();
				
		header('location: index.php');

?>