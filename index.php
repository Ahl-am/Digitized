<?php
	$title = 'Home Page';
	include "header.php";
?>

<body class="homepage" style="margin: 0px" onload="refresh();">
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
				<section style="display:flex; justify: content: row">
				<section style="align-items: row;">
						<img src="team.png" alt="team guy" width="290" height="260">
						</section>
				<section style="margin-top:10px; margin-right: 1%; text-align: center; margin-left: 10%; align-items:row;">
				<h2>	<strong class="mark"> Member Login</strong> </h2>
					
							  <button onclick="login_instr()" class="btn green">Instructor Login</button>
							  
							  <button id="studentClicked" onclick="login_stu();" class="btn red">Student Login</button>

							  <br>
							  <br>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New student? <a href="sign-up.php" class="btn blue" style="border-radius: 15px;">Sign Up</a> 
							 </section>
						</section>
					</form>
				</div>
				
			</div>


	</div>
</main>

<button class="open-button" onclick="openForm()">Chat</button>

<div class="chat-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Chat</h1>

    <label for="msg"><b>Message</b></label>
    <textarea placeholder="Type message.." name="msg" required></textarea>

    <button type="submit" class="btn">Send</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
<?php
	include "footer.php";
?>















