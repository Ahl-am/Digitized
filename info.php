
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script> 
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideDown("slow").fadeOut().fadeIn();
  });
});
</script>
<style> 
#panel, #flip {
  padding: 5px;
  text-align: center;
  background-color: #E9F7EF;
  border: solid 2px #c3c3c3;
}

#panel {
  padding: 50px;
  display: none;
  background-color: #f2f2f2;

}
</style>
</head>


<?php
include_once 'db_conn.php';
$title = 'Course Information Page';
include "header.php";
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
			$pdo = pdo_dbconn();?>


<body>
 <!-- <script src="plugins/jquery/jquery.min.js"></script> -->

    <script>
	$(document).ready(function(){
	function getFormData($form){
		validateCourseForm();
		event.preventDefault(); 
	var unindexed_array = $form.serializeArray();
	var indexed_array = {};
	$.map(unindexed_array, function(n, i){
		indexed_array[n['name']] =  n['value'];
		});
	return indexed_array;}
///2ajax | sencd path to json*/
$('#editButton').click(function(){
 
	var c_id = $("#c_id").val();
	var imagefields  = $("#editCover")[0].files[0];
	var $form = $("#editForm");
	var formatData = new FormData();
	formatData.append('images', $('#editCover')[0].files[0]);
		formatData.append('action', 'updateimg');///////////////////////////////////////////////////////////////////comeback
		formatData.append('id', c_id);
 	var dataformm = getFormData($form); //json string
 	var stringData = JSON.stringify(dataformm);
	console.log(dataformm);
$.ajax({
			type: 'POST',
			url: "updateimg.php",
			dataType: "text",
			data: formatData,
			contentType: false,
			processData: false,
			success: function(response){
				console.log("Success! image rcieved");
			}
});
		$.ajax({
			type: 'POST',
			url: "updateCourse.php",
			dataType: "text",
			data: stringData,
			contentType: 'application/json;charset=UTF-8',
			success: function(response){	
				console.log("", response);
			var title = document.getElementById("courseTitle").value;
			var field = document.getElementById("courseField").value;
			var desc = document.getElementById("courseDesc").value;
			 if( title == "" || field == "" || desc == ""){
			}
			else{
			$("#editForm :input").prop("disabled", true);
			$("#editButton").attr("disabled", true);
			$("#success").css("display", "block");
			window.location.assign('info.php?id=' + c_id);
			}
			}
	});
	});
	});
	</script>
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

<?php if ($mode != 'edit') { ?>
<p> <strong class="mark">Course Information</strong> 
<p style="margin: 2%; line-hieght: 1.4em;"> <strong>Name</strong>: <?php echo $course['name']; ?>
<br>
<strong>Field:</strong> <?php echo $course['field']; ?> 
<br>
<strong>Description: </strong> <?php echo $course['description']; ?>
<br>
<strong>The Course's instructor</strong>: <?php echo $inst['name']; ?>
<center> <img  src="data:image/jpeg;base64,<?php echo base64_encode($course['book_cover']); ?>" /> </center> 
<?php } ?>

<?php if ($usertype != 'std' && $mode != 'edit') { ?>
<a name="studentsList">
<p><strong id="flip" class="mark"> Students List</strong> </p> <section id="panel">
<ol>
<?php foreach ($students as $student) { ?>
<li> <pre> <?php echo $student['name']; ?>     |     <?php echo $student['id']; ?> </pre> </li>
<?php } ?>
</ol></p></section>

<?php } ?>
</div>

<?php if ($usertype == 'inst' && $mode == 'edit') { ?>
<form name="myForm" id="editForm" method="POST" enctype="multipart/form-data">

<div style="background-color:white;">
<br>
<h1 style="color: green; text-align: center;">Edit Course</h1>
<br>
<Br>

	<div class="formContainer">
  	<br>
	<div class="formInner">
   <div class="field">
    The course's title:<br>
    <input type="text" class="form" name="title" id="courseTitle" placeholder="IT22" value = "<?php echo $course['name']; ?>">
	</div>
    <br>
	<br>
	<div class="field">
    The course's field:<br>
    <input type="text" id="courseField" class="form" name="field" placeholder="Programming" value = "<?php echo $course['field']; ?>">
	</div>
    <br>
	<br>
	<div class="field">
	The course's description:<br>
	<textarea name="description" id="courseDesc" class="form" placeholder="" rows="4" cols="50" ><?php echo $course['description']; ?></textarea>
	</div>
	<br>
	<br>
	<div class="book_cover">
    The course's book cover:<br>
   <input type="file" name="book_cover" id="editCover" />
	</div>
    <input type="hidden" name="c_id" id="c_id" value="<?php echo $c_id; ?>">
	<input type="hidden" name="action" value="edit">
	<button type="button" id="editButton" class="btn blue">Submit</button>
	<div style="display: none;"  id="success" role="alert">Updated Successfully!</div>
	</div>
  	</div>
	</div>
</form>
<?php } ?>


</div>
</div>
<br>
<br>

</main>
</html>

<?php
	include "footer.php";
?>

