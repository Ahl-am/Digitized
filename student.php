
<?php
$title = 'Student Page';
include "header.php";

if (!isset($_SESSION['login']))
	header('Location:index.php');
else if ($_SESSION['usertype'] == 'inst')
	header('Location:instructor.php');

$action = 'std_page';
include "user.php";

$std_id = $_SESSION['userid'];
$std = get_user_info('std', $std_id);

if (!$std)
	header('Location:index.php');

$enrolld_courses = get_std_enrolld_courses($std_id); 
$other_courses = get_std_other_courses($std_id); 

?>

<body>
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
<h1 style="color: black; text-align: center;">Welcome [<?php echo $std['name']; ?>]!</h1>
<br>
<div class="container">
<div class="info-card">
<p><div class="qu">Name:</div>&nbsp; <?php echo $std['name']; ?>
<br>
<div class="qu">Email:</div> &nbsp;<?php echo $std['email']; ?>
<br>
<br>
</div>
</div>
	<?php
		if(!empty($e_msg)) {
			echo "<div style=\"color: red; text-align:center; \">" . $e_msg . "</div>";
		} else if(!empty($s_msg)) {
			echo "<div style=\"color: green; text-align:center; \">" . $s_msg . "</div>";
		}
	?>

<br>
<hr>
<br>
<h1 style="color: black; text-align: center;">Available Courses</h1>
<br>
<aside>
<table id="myTable">
<caption></caption>
		<tr>
		<th>Course</th>
		<th colspan="2" >Status</th>
		</tr>
		
		<?php 
			foreach ($enrolld_courses as $course) { //عشان يطبع الكورسات الي سجل فيها الطالب أول
		?>
			<tr id="star1">
			<td><a href="info.php?id=<?php echo $course['id']; ?>"> <?php echo $course['name']; ?> </a></td>
			<td><a href="info.php?id=<?php echo $course['id']; ?>">  Enrolled </a></td>
			<td><a href="user.php?q=drop&course_id=<?php echo $course['id']; ?>"> Drop </a></td>
			<td> <img src ="filled.png" alt = "star" width = "22" height ="27" onClick="color()"></td>
			</tr>
		<?php } ?>
		
		<?php 
			foreach ($other_courses as $course) { 
		?>
			<tr id="star2">
			<td><a href="info.php?id=<?php echo $course['id']; ?>"> <?php echo $course['name']; ?> </a></td>
			<td><a href="user.php?q=enroll&course_id=<?php echo $course['id']; ?>"> Enroll </a></td>
			<td><a href="info.php"></a></td>
			<td><img  src="filled.png" alt="star"  height="22" width="27" onClick="color()"></td>
			</tr>
		<?php } ?>
		
</table>
</aside>
</main>

<?php
	include "footer.php";
?>
