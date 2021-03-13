

<?php
	include_once 'db_conn.php';
	//$id = isset($_GET['id'])?$_GET['id']:0;
	$id = $_GET['id'];
	$pdo = pdo_dbconn();
	$stmt = $pdo->prepare("SELECT s.* FROM student s, enrolment e WHERE s.id=e.student_id and e.course_id=?;");
	$stmt->bindValue(1, $id);

	$stmt->execute();
	
	$students = array();
	
	$stmt->execute();
	while ($su = $stmt->fetch())
	$students[] = $su;
	//do i need this? what does stmt returns?
	
	$Myxml ='<? xml version="1.0" encoding="utf-8" ?>';
	$Myxml.='<Course>';
	if($stmt != null){
		foreach ($students as $key => $student){ //???
			$key2 = $key+1; //keye -> key2 change this 
	$Myxml.='<student><name>'.$student["name"].'</name><email>'.$student["email"].'</email></student>';
		}
		$Myxml.='</Course>';
			}
	echo $Myxml;
?>




