<?php
	$title = 'Login Page';
	include "header.php";
	
	if (isset($_SESSION['login'])) {
		if($_SESSION['usertype'] == 'inst')
			header('Location:instructor.php');
		else
			header('Location:student.php');
		exit;
	}
?>

<body class="loginPages" style="margin: 0px">
<header>
<img src="logo2.jpeg" alt="lolgo" width="180" height="150">
<nav>
<div id="navi" >
<a href="index.php"> Home </a> | <a href="instruloginForm.php"> Instructor </a> | <a href="stuLoginForm.php"> Student </a>
</div>
</nav>
</header>
 <main>

	<div class="limiter">
			
			<div class="container-login100">
				<div class="wrap-login100">
<form name="myForm" onsubmit="return validateLoginForm()" method="POST" action="user.php?q=std_login" >
	<h2>	<strong class="mark"> Student Log-in</strong></h2>
  <!--Name:<br><input type="text" name="fname">
  <br>-->
  <br>
  Email<br><br>
  <input type="email" class="form" name="email" placeholder="Maha@gmail.com" value="1@1.com">
  <br>
  <br>
  Password<br><br>
  <input type="password" class="form" name="password" value="1">
  <br>
  <input type="submit" class="btn blue" value="Submit">
  
	<?php
		if(!empty($e_msg)) {
			echo "<div style=\"color: red; \">" . $e_msg . "</div>";
		} else if(!empty($s_msg)) {
			echo "<div style=\"color: green; \">" . $s_msg . "</div>";
		}
	?>
					
</form>
</main>

<?php
	include "footer.php";
?>





