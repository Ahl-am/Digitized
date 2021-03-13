<?php
$title = 'Add course Page';
include "header.php";

if (!isset($_SESSION['login']))
	header('Location:index.php');
else if ($_SESSION['usertype'] != 'inst')
	header('Location:index.php');
?>

 <body class="addcourse">
<header>
<a class="si" href="sign-out.php"> Sign Out </a>
<img src="logo2.jpeg" alt="lolgo" width="180" height="150">
<nav>
<div id="navi" >
<a href="index.php"> Home </a> | <a href="instruloginForm.php"> Instructor </a> | <a href="stuLoginForm.php"> Student </a>

</div>
</nav>


</header>
 <main>
<form name="myForm" onsubmit="return validateCourseForm();" action="course.php?q=add" method="POST" enctype="multipart/form-data">

<div style="background-color:white;">
<br>
<h1 style="color: green; text-align: center;">+Add a Course</h1>
<br>
<Br>

	<div class="formContainer">
  	<br>
	<div class="formInner">
   <div class="field">
    The course's title:<br>
    <input type="text" class="form" name="title" placeholder="IT22">
	</div>
    <br>
	<br>
	<div class="field">
    The course's field:<br>
    <input type="text" class="form" name="field" placeholder="Programming">
	</div>
    <br>
	<br>
	<div class="field">
	The course's description:<br>
	<textarea name="description" class="form" placeholder="Tell us about the course!" rows="4" cols="50" ></textarea>
	</div>
	<br>
	<br>
	<div class="book_cover">
    The course's book cover:<br>
    <input type="file" name="book_cover" />
	</div>

	<input type="submit" class="btn blue" name="submit" value="submit">
	</div>
  	</div>
	</div>
</form>
</main>

<?php
	include "footer.php";
?>





