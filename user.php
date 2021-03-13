<?php
include_once 'db_conn.php'; 


if(!isset($_SESSION)) //No one is logged in(guest)
session_start(); //enable sessions-he doesn't have session

if (!isset($action) || empty($action)) {//if there is no action
if (isset($_REQUEST['q']))//checks query string
$action = $_REQUEST['q'];
else  //if there's nothing
header('Location:' . $_SERVER['HTTP_REFERER']);
//refer user to the previous page home
}
//call the appropriate function, based on the form action
if ($action == 'std_login') {
user_login('std');}
else if ($action == 'inst_login') {
user_login('inst');} 
else if ($action == 'std_signup') {
user_signup('std');}
//send the arguement if student choses to drop/enroll a course
else if ($action == 'enroll') {
if (isset($_SESSION['userid']) && isset($_REQUEST['course_id'])){
$uID=$_SESSION['userid']; $cID=$_REQUEST['course_id'];
std_enroll_course($uID, $cID);}
} 
else if ($action == 'drop') {
if (isset($_SESSION['userid']) && isset($_REQUEST['course_id'])){
$uID=$_SESSION['userid']; $cID=$_REQUEST['course_id'];
std_drop_course($uID, $cID);
}
}
function user_login($usertype) {
if (isset($_SESSION['login'])) {//If user logged in ppreviously
if($usertype == 'inst')
header('Location:instructor.php');
else
header('Location:student.php');
exit;
}	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['email']) && isset($_POST['password'])) {
$email = $_POST['email']; $psw = $_POST['password'];
login($usertype, $email, $psw);
}
else{
$_SESSION['e_msg'] = "Wrong entrey!! try again"; //إذا ما وجد البيانات في الداتابيس
header('Location:' . $_SERVER['HTTP_REFERER']); //يرجعني للصفحة نفسها
exit;
}
}
}
function login($usertype, $email, $password) {
$pdo = pdo_dbconn();
//prepared statements for sql queries
if ($usertype == 'std')
$stmt = $pdo->prepare("SELECT * FROM student WHERE email=? AND password=?;");
else
$stmt = $pdo->prepare("SELECT * FROM instructor WHERE email=? AND password=?;");
$stmt->bindValue(1, $email);
$stmt->bindValue(2, md5($password));//hashing password MD5 
$stmt->execute();
$user = $stmt->fetch(); //all the info in the $stmt will go to $user
if($user){//if the database returned info
//setting session vars
$_SESSION['login'] = true;
$_SESSION['userid'] = $user['id'];
$_SESSION['usertype'] = $usertype;
//if the entred type is:
if($usertype == 'std')
header('Location:student.php');
else
header('Location:instructor.php');
exit;
} 
else{
$_SESSION['e_msg'] = "Wrong entery!! try again";
header('Location:' . $_SERVER['HTTP_REFERER']);//refre user to previouse page-login-
exit;
}
}
function user_exists($usertype, $username, $email) {
$pdo = pdo_dbconn();
if ($usertype == 'std')
$stmt = $pdo->prepare("SELECT * FROM student WHERE username=? OR email=?;");
else
$stmt = $pdo->prepare("SELECT * FROM instructor WHERE username=? OR email=?;");
$stmt->bindValue(1, $username);
$stmt->bindValue(2, $email);
$stmt->execute();
$user = $stmt->fetch();
if($user)//if the database returned info
return true;//user exists
else
return false;//user doen't exist
}
function user_signup($usertype){
if (isset($_SESSION['login'])){//if he is already logged in
if($usertype == 'inst')
header('Location:instructor.php');
else
header('Location:student.php');
exit;
}
//fetch info user entered
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset($_POST['FName']) && isset($_POST['MName']) && isset($_POST['LName']) && isset($_POST['username']) && isset($_POST['id']) && isset($_POST['email']) && isset($_POST['psw'])) {
if (user_exists($usertype, $_POST['username'], $_POST['email'])){
$_SESSION['e_msg'] = "Email or Username already exists.";
header('Location:' . $_SERVER['HTTP_REFERER']);//stay in this page
exit;
}
//if info is complete insert new student
$pdo = pdo_dbconn();
if ($usertype == 'std')
$stmt = $pdo->prepare("INSERT INTO student (id, name, username, email, password) VALUES (?, ?, ?, ?, ?);");
$stmt->bindValue(1, $_POST['id']);
$stmt->bindValue(2, $_POST['FName'] . ' ' . $_POST['MName'] . ' ' . $_POST['LName']);
$stmt->bindValue(3, $_POST['username']);
$stmt->bindValue(4, $_POST['email']);
$stmt->bindValue(5, md5($_POST['psw']));
$result = $stmt->execute();
if($result){//if database returned something(not null)
$_SESSION['s_msg'] = "Success!! you are now a member.";
login($usertype, $_POST['email'], $_POST['psw']);
}else
{//something went wrong
$_SESSION['e_msg'] = "ERROR!! re-enter";
header('Location:' . $_SERVER['HTTP_REFERER']);
exit;
}
}
else
{//if fields are not complete
$_SESSION['e_msg'] = "Missing fields! re-enter.";
header('Location:' . $_SERVER['HTTP_REFERER']);
exit;
}
}
}
function get_user_info($usertype, $id) { //نسترجع المعلومات 

$pdo = pdo_dbconn();
	
if ($usertype == 'std')
$stmt = $pdo->prepare("SELECT * FROM student WHERE id=?;"); //إذا كان طالب
else // إذا كان انستركتر
$stmt = $pdo->prepare("SELECT * FROM instructor WHERE id=?;");
	
$stmt->bindValue(1, $id);

$stmt->execute();
$user = $stmt->fetch();

if($user) //إذا رجع 
return $user;
else return null;
}

function get_inst_courses($id) { /*Retrieves all the courses in the Course table that belong to the current
                                 instructor and prints a list of these courses فقرة رقم 6 */

$pdo = pdo_dbconn();
$stmt = $pdo->prepare("SELECT * FROM course WHERE instructor_id=?;");
$stmt->bindValue(1, $id);
$stmt->execute();
	
$courses = array(); 
	
while ($course = $stmt->fetch())
$courses[] = $course;
return $courses; }

function get_std_enrolld_courses($id)  // الكورسات الي مسجل فيها الطالب
{
$pdo = pdo_dbconn();
$stmt = $pdo->prepare("SELECT * FROM course WHERE id IN (SELECT course_id FROM enrolment WHERE student_id=?);");
$stmt->bindValue(1, $id);

$stmt->execute();
$courses = array();
	
while ($course = $stmt->fetch())
$courses[] = $course;

return $courses;
}

function get_std_other_courses($id) { // الكورسات الي ما سجل فيها الطالب
$pdo = pdo_dbconn();
$stmt = $pdo->prepare("SELECT * FROM course WHERE id NOT IN (SELECT course_id FROM enrolment WHERE student_id=?);");
$stmt->bindValue(1, $id);

$stmt->execute();
	
$courses = array();
	
while ($course = $stmt->fetch())
$courses[] = $course;

return $courses;
}

function std_enroll_course($student_id, $course_id) {
$pdo = pdo_dbconn();
$stmt = $pdo->prepare("SELECT * FROM enrolment WHERE student_id=? AND course_id=?;");
$stmt->bindValue(1, $student_id);
$stmt->bindValue(2, $course_id);
$stmt->execute();
$result = $stmt->fetch();
	
if ($result)
$_SESSION['e_msg'] = "You have this course before"; else { //already exists
	//OTHERWISE
$stmt = $pdo->prepare("INSERT INTO enrolment (student_id, course_id) VALUES (?, ?);");
$stmt->bindValue(1, $student_id);
$stmt->bindValue(2, $course_id);

$result = $stmt->execute();
				
if($result){  $_SESSION['s_msg'] = "Successfull enrolment to the course";

} else { $_SESSION['e_msg'] = "Course enrolment was not successfull"; }
}
	
header('Location:' . $_SERVER['HTTP_REFERER']); exit;
}

function std_drop_course($student_id, $course_id) {
$pdo = pdo_dbconn();
$stmt = $pdo->prepare("SELECT * FROM enrolment WHERE student_id=? AND course_id=?;"); 
$stmt->bindValue(1, $student_id);
$stmt->bindValue(2, $course_id);

$stmt->execute();
$result = $stmt->fetch();
	
if (!$result)
$_SESSION['e_msg'] = "Course not found!";
else
{
$stmt = $pdo->prepare("DELETE FROM enrolment WHERE student_id=? AND course_id=?;"); //DELETE ROW
$stmt->bindValue(1, $student_id);
$stmt->bindValue(2, $course_id);

$result = $stmt->execute();
				
if($result){
$_SESSION['s_msg'] = "Dropping the course was successfully done";
} else
{
$_SESSION['e_msg'] = "Dropping the course unsuccessfull!";
}}
	
header('Location:' . $_SERVER['HTTP_REFERER']);   exit;
}

?>