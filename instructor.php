

<?php
include "header.php"; //
$title = 'Instructor Page';
if (!isset($_SESSION['login']))
	header('Location:index.php');
else if ($_SESSION['usertype'] == 'std')
	header('Location:studnet.php');

$action = 'inst_page';
include "user.php";

$inst_id = $_SESSION['userid'];
$inst = get_user_info('inst', $inst_id);

if (!$inst)
	header('Location:index.php');

$inst_courses = get_inst_courses($inst_id);
?>


<body>
<style>
.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
 /* padding: 18px; */
 /* width: 100%; */
  border: none;
  text-align: left;
 /* outline: none;*/
 /* font-size: 15px; */
}

.active, .collapsible:hover {
  /*background-color: #555;*/
}

.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
}
.container{
	backgrond-color: white;
}
.container div{
	/*border-top: solid 1px;*/
	padding-right: 20px;
	padding-left: 20px;
}
</style>
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
<h1 style="color: black; text-align: center;">Welcome [<?php echo $inst['name']; ?>]!</h1>
<br>
<div class="container">
<div class="info-card">
<p><div class="qu">Name:</div>&nbsp; <?php echo $inst['name']; ?>
<br>
<div class="qu">Email:</div> &nbsp;<?php echo $inst['email']; ?>
<br>
<div class="qu">Speciality:</div> &nbsp;<?php echo $inst['speciality']; ?> 
<br>
<br>
</div>
<?php
	if(!empty($e_msg)) {
		echo "<div style=\"color: red; text-align:center; \">" . $e_msg . "</div>";
	} else if(!empty($s_msg)) {
		echo "<div style=\"color: green; text-align:center; \">" . $s_msg . "</div>";
	}
?>
<br>
<div class="info-cardtwo">
<button onClick="window.location.assign('addCourse.php');" class="btn green">+Add course</button>

</div>
</div>
<br>
<hr>
<br>
<h1 style="color: black; text-align: center;">Available Courses</h1>
<br>
<br>
<aside>
		<?php 
			foreach ($inst_courses as $course) {
		?>
		<table>
		<tr>
		<div class="container">
		<div>
		<th><a href="info.php?id=<?php echo $course['id']; ?>"> <?php echo $course['name']; ?> </a></th>
		</div>
		<br>
		<br>
		<div>
		<th><a style="margin: 2em;"  href="info.php?id=<?php echo $course['id']; ?>&mode=edit"> Edit </a> </th>
		</div>
		<br>
		<br>
		<div>
		<?php echo "<td><a class='collapsible' onclick='return Display(".$course['id'].")'>Display students list</a>" ?>
		<!--<h1><?php// echo $course['id'];?></h1>-->
		<div class="content">
		<br>
			<ul>
			<li id="cl">
			<?php echo "<p id='".$course["id"]."'></p>" ?>
			</ul>
			</div>
			</div>
			</div>
			</tr>
			<table>
		<?php } ?>
</aside>
<br>
<br>
<br>

</main>

<?php
	include "footer.php";
?>
<!--- Library should be inside -->

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --> 
<!-- NOOOOOOOOOOOOOOTE --->

<script> 
//collapsable
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

    
    function Display(id) {

console.log(id);
    if (id.length == 0) {
        document.getElementById(id).innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(id).innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "getStudent.php?view=single&id="+id, true);
        xmlhttp.send();
    }
}
   
</script>


















