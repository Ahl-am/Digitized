<?php
	header("Content-Type: : text/plain");
	session_start();
	
	$e_msg = "";
	$s_msg = "";
	
	if(isset($_SESSION['e_msg'])) {
		$e_msg = $_SESSION['e_msg'];
		unset($_SESSION['e_msg']);
	} else if (isset($_SESSION['s_msg'])) {
		$s_msg = $_SESSION['s_msg'];
		unset($_SESSION['s_msg']);
	}
?>

<!DOCTYPE html>
<html>

<head> 
<title> <?php echo $title;?></title> 
<link rel="stylesheet" href="stylesheet.css" type="text/css">
<!--<link rel="stylesheet" href="style.css" type="text/css">-->
<script src="javascript.js"></script>

</head>

