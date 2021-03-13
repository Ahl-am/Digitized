<?php
	$title = 'Sign-up Page';
	include "header.php";
?>

<body>
<header>
<img src="logo2.jpeg" alt="lolgo" width="180" height="150">
<nav>
<div id="navi" >
<a href="index.php"> Home </a> | <a href="instruloginForm.php"> Instructor </a> | <a href="stuLoginForm.php"> Student </a>
</div>
</nav>
 </header>


<main>
<body>
<form  name="myForm" method="POST" action="user.php?q=std_signup">
  <fieldset>
    <legend><strong>Student Sign-Up</strong></legend>
    <br>
    <hr>
	Full Name:
	<div id="names">
    <input type="text" class="form" id="FName" name="FName" placeholder="Ahmed" oninput='letterinputFunction(this)' required>
    <input type="text" class="form" id="MName" name="MName" placeholder="Saad" oninput='letterinputFunction(this)' required>
    <input type="text" class="form" id="LName" name="LName" placeholder="AlNasser" oninput='letterinputFunction(this)' required>
	<br>
	</div>
	Username:<br>
    <input type="text" class="form" id="username" name="username" placeholder="username">
    <br>
	ID:<br>
    <input type="text" class="form" id="id" name="id" placeholder="id">
    <br>
    Email:<br>
    <input type="email" class="form" id="email" name="email" placeholder="Ahmed@gmail.com">
    <br>
	Password: <br>
    <input type="password" class="form" id="psw" name="psw" value="Teach">
    <br>
	<button type="button" class="btn green" onclick="signup()"> Sign-Up </button>
	<button type="button" class="btn red" onclick="cancel()">Cancel</button>

	<?php
	if(!empty($e_msg)) {
		echo "<div style=\"color: red; \">" . $e_msg . "</div>";
	} else if(!empty($s_msg)) {
		echo "<div style=\"color: green; \">" . $s_msg . "</div>";
	}
	?>
  </fieldset>
</form>
</body>

</main>




<?php
	include "footer.php";
?>