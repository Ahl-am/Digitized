<?php
	include_once 'db_conn.php';
	//$id = isset($_GET['id'])?$_GET['id']:0;
	header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: access");
//header("Access-Control-Allow-Methods: GET");
header("Cache-Control: public; max-age=3431901");


$view = "";
if(isset($_GET["view"]))
	$view = $_GET["view"];
	
	switch($view){

	case "all":
		// to handle REST Url /students/list/
		print getAllStudents();
		break;
		
	case "single":
		// to handle REST Url /students/show/<id>/
		print getStudentBYID($_GET['id']);
		break;

	case "" :
		//404 - not found;
		break;
}

/**
Get all students
*/

function getAllStudents(){
		
		$qry="select s.id, s.name,s.email,c.name as courseName,c.field from student as s inner join enrolment as e on s.id=e.student_id inner join course as c on e.course_id=c.id;";
		
	$pdo = pdo_dbconn();
	$stmt = $pdo->prepare($qry);
	$stmt->execute();
	if($stmt->rowCount()>0){
	$xml = '<?xml version="1.0" encoding="utf-8"?>';
	$xml .= '<StudentsInfo>';
	 while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$xml .= '<student>';

        $xml .= '<ID>' .$row['id']. '</ID>';
        $xml .= '<Name>' .$row['name']. '</Name>';
        $xml .= '<Email>' . $row['email']. '</Email>';
		$xml .= '<Course>' . $row['courseName']. '</Course>';
		$xml .= '<Field>' . $row['field']. '</Field>';

        $xml .= '</student>';
    }
	$xml .= '</StudentsInfo>';
	return $xml; 
	}else{
		return "Error".errorInfo();
	}
}
/**
Get a student by ID
*/	
function getStudentBYID($id){
		
	$qry="select c.name as courseName,c.field,s.id,s.name,s.email from course as c inner join enrolment as e on c.id=e.course_id inner join student as s on e.student_id=s.id  and c.id='$id'";
	$pdo = pdo_dbconn();
	$stmt = $pdo->prepare($qry);
	$stmt->execute();
	
	if($stmt->rowCount()>0){
	$xml = '<?xml version="1.0" encoding="utf-8"?>';
	$xml .= '<StudentsInfo>';
	 while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$xml .= '<student>';

        $xml .= '<ID>' .$row['id']. '</ID>';
        $xml .= '<Name>' .$row['name']. '</Name>';
        $xml .= '<Email>' . $row['email']. '</Email>';
		$xml .= '<Course>' . $row['courseName']. '</Course>';
		$xml .= '<Field>' . $row['field']. '</Field>';

        $xml .= '</student>';
    }
	$xml .= '</StudentsInfo>';
	return $xml; 
	}else{
		return "There are no students for this course";
	}
	
}
?>




