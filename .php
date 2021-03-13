<?php
$title = 'Course Information Page';
include "header.php"; // for simplicity because we will use it frequently 

if (!isset($_SESSION['login']))
	header('Location:index.php');

if (!isset($_REQUEST['id'])) {
	header('Location:index.php');
}

$action = 'course_page';
include "course.php";
include "user.php";

$c_id = $_REQUEST['id'];
$course = get_course_info($c_id);

if (!$course)
	header('Location:index.php');

$inst_id = $course['instructor_id'];
$inst = get_user_info('inst', $inst_id);

if (!$inst)
	header('Location:index.php');

$students = get_course_students($c_id);

$usertype = $_SESSION['usertype'];

$mode = '';
if (isset($_REQUEST['mode']))
	$mode = $_REQUEST['mode'];

$inst_courses = get_inst_courses($inst_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && $_SESSION['usertype'] == 'inst')
	edit_course($_POST['id']);

?>

<body>
<!--<body onload="decideEdit()">-->
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
<h1 style="color: black; text-align: center;">Welcome to  <?php echo $course['name']; ?>  </h1>
<!-- Our visibility code: we removed it after disscussing with teacher Malak because she said it's from phase 2
<p style="text-align: center;" id="instructorView">[<a href="">Edit</a> | <a href="">Drop</a>]</p>
<p style="text-align: center; color: blue;" id="studentView">[<a href="">Enrolled</a> | <a href="">Drop</a>]</p>
-->
<?php
	if(!empty($e_msg)) {
		echo "<div style=\"color: red; text-align:center; \">" . $e_msg . "</div>";
	} else if(!empty($s_msg)) {
		echo "<div style=\"color: green; text-align:center; \">" . $s_msg . "</div>";
	}
?>
<p style="text-align: center;" id="instructorView">[

<?php if ($usertype == 'inst') { ?>
<a href="info.php?id=<?php echo $c_id; ?>&mode=edit">Edit</a>
<?php } else if ($usertype == 'std') { ?>
<a href="user.php?q=drop&course_id=<?php echo $c_id; ?>">Drop</a> | <a href="user.php?q=enroll&course_id=<?php echo $c_id; ?>">Enroll</a>
<?php } ?>
]</p>
<div class="container">
<div class="info-card">
<p> <strong class="mark">Course Information</strong> 
<p style="margin: 2%; line-hieght: 1.4em;"> <strong>Name</strong>: <?php echo $course['name']; ?>
<br>
<strong>Field:</strong> <?php echo $course['field']; ?> 
<br>
<strong>Description: </strong> <?php echo $course['description']; ?>
<br>
<strong>The Course's instructor</strong>: <?php echo $inst['name']; ?>
<center> <img  src="data:image/jpeg;base64,<?php echo base64_encode($course['book_cover']); ?>" /> </center> 

<?php if ($usertype != 'std' && $mode != 'edit') { ?>
<a name="studentsList">
<p><strong class="mark"> Students List</strong> </p>
<ol>
<?php foreach ($students as $student) { ?>
<li> <pre> <?php echo $student['name']; ?>     |     <?php echo $student['id']; ?> </pre> </li>
<?php } ?>
</ol></p>

<?php } ?>
</div>

<?php if ($usertype == 'inst' && $mode == 'edit') { ?>
<form name="myForm" onsubmit="return validateCourseForm();" action="info.php?q=edit" method="POST" enctype="multipart/form-data">

<div style="background-color:white;">
<br>
<h1 style="color: green; text-align: center;">Edit Course</h1>
<br>
<Br>

	<div class="formContainer">
  	<br>
	<div class="formInner">
	<input type="hidden" name="id" value="<?php echo $c_id; ?>">
   <div class="field">
    The course's title:<br>
    <input type="text" class="form" name="title" placeholder="IT22" value = "<?php echo $course['name']; ?>">
	</div>
    <br>
	<br>
	<div class="field">
    The course's field:<br>
    <input type="text" class="form" name="field" placeholder="Programming" value = "<?php echo $course['field']; ?>">
	</div>
    <br>
	<br>
	<div class="field">
	The course's description:<br>
	<textarea name="description" class="form" placeholder="Tell us about the course!" rows="4" cols="50" ><?php echo $course['description']; ?></textarea>
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
<?php } ?>

<!--
<div class="info-cardtwo">
<p> <strong class="mark">Course Content</strong> 
	<div class="grid-container">
  <div class="grid-item">Referencing skills</div>
  <div class="grid-item">Critical analysis </div>
  <div class="grid-item"> Referencing skills</div>  
  <div class="grid-item">Reading academic texts efficiently and analytically </div>
  <div class="grid-item">Taking part in seminars</div>
  <div class="grid-item">Making effective notes</div>  
  <div class="grid-item">Developing an academic writing style</div>
  <div class="grid-item">Getting the most from lectures</div>
  <div class="grid-item">Academic vocabulary</div>  
</div>
-->
</div>
</div>
<br>
<br>

</main>


<!-- we asked T. Malak if we have to make the student lists unvisible to student user, but she said it is okay to keep it visible for phase 1 -->
<?php
	include "footer.php"; // for simplicity 
?>

