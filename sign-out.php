<?php

	session_start();
	
	if (isset($_SESSION['login'])) {
		if($_SESSION['usertype'] == 'inst')
			header('Location:instruloginForm.php');
		else
			header('Location:stuLoginForm.php');
	} else {
		header("location: index.php");
	}
		
	session_destroy();
	
	exit;
?>