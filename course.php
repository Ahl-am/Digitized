
<?php
include_once 'db_conn.php';


if(!isset($_SESSION)) 
	session_start();

if (!isset($action) || empty($action)) {
if (isset($_REQUEST['q']))
$action = $_REQUEST['q'];
else
		header('Location:' . $_SERVER['HTTP_REFERER']);
}

if ($action == 'add') {
	if (isset($_SESSION['userid']) && $_SESSION['usertype'] == 'inst')
		add_course($_SESSION['userid']);
    } if ($action == 'edit') {
     	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && $_SESSION['usertype'] == 'inst')
		edit_course($_POST['id']);
       }

    function add_course($instructor_id) {
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['title']) && isset($_POST['field'])) {
		
	if (is_uploaded_file($_FILES["book_cover"]["tmp_name"])) {
				$tmpName  = $_FILES['book_cover']['tmp_name'];  
				$fp = fopen($tmpName, 'rb');
			}
	
			$pdo = pdo_dbconn();
			
			$stmt = $pdo->prepare("INSERT INTO course (instructor_id, name, field, description, book_cover) VALUES (?, ?, ?, ?, ?);");
			
			$stmt->bindValue(1, $instructor_id);
			$stmt->bindValue(2, $_POST['title']);
			$stmt->bindValue(3, $_POST['field']);
			$stmt->bindValue(4, $_POST['description']);
			if ($fp)
				$stmt->bindParam(5, $fp, PDO::PARAM_LOB);
			else
				$stmt->bindParam(5, '', PDO::PARAM_LOB);
			
			$result = $stmt->execute();
					
			if($result) {
			$_SESSION['s_msg'] = "The course: " . $_POST['title'] ." \n has been added successfully";
			header('Location:info.php?id=' . $pdo->lastInsertId());
			exit;
			} else {
			$_SESSION['e_msg'] = "Error while adding the course.";
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
			}
		    } else {
			$_SESSION['e_msg'] = "Please fill all required fields.";
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
		}
	    }
 }

/*
function edit_course($course_id) {
	
	  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		   if (isset($_POST['title']) && isset($_POST['field'])) {
		
			$pdo = pdo_dbconn();
			
			if (is_uploaded_file($_FILES["book_cover"]["tmp_name"])) {
				$tmpName  = $_FILES['book_cover']['tmp_name'];  
				$fp = fopen($tmpName, 'rb');
				$stmt = $pdo->prepare("UPDATE course SET name = ?, field = ?, description = ?, book_cover = ? WHERE id = ?;");
			} else {
				$stmt = $pdo->prepare("UPDATE course SET name = ?, field = ?, description = ? WHERE id = ?;");
			}

			$stmt->bindValue(1, $_POST['title']);
			$stmt->bindValue(2, $_POST['field']);
			$stmt->bindValue(3, $_POST['description']);
			if ($fp) {
				$stmt->bindParam(4, $fp, PDO::PARAM_LOB);
				$stmt->bindValue(5, $course_id);
			} else {
				$stmt->bindValue(4, $course_id);
			}
			
			$result = $stmt->execute();
					
			if($result) {
				$_SESSION['s_msg'] = "The course: " . $_POST['title'] ." \n has been edit successfully";
				header('Location:info.php?id=' . $course_id);
				exit;
			} else {
				$_SESSION['e_msg'] = "Error while edit the course.";
				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}
	     	} else {
			$_SESSION['e_msg'] = "Please fill all required fields.";
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
		}
	    }
      }
	  */
	  

function get_course_info($id) {
	$pdo = pdo_dbconn();
	$stmt = $pdo->prepare("SELECT * FROM course WHERE id=?;");
	$stmt->bindValue(1, $id);

	$stmt->execute();
	$course = $stmt->fetch();

	if($course)
	return $course;
	else
	return null;
}




function get_course_students($id) {
	$pdo = pdo_dbconn();
	$stmt = $pdo->prepare("SELECT s.* FROM student s, enrolment e WHERE s.id=e.student_id and e.course_id=?;");
	$stmt->bindValue(1, $id);

	$stmt->execute();
	
	$students = array();
	
	while ($student = $stmt->fetch())
	$students[] = $student;

	return $students;
}

?>