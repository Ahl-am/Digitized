<?php
include_once 'db_conn.php';
//require_once('db_conn.php');
$action=isset($_POST['action'])?$_POST['action']:'';
//only allow post requests
if($action=="updateimg"){
}
if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST'){ }
//throw new Exception(message: 'Only POST requests are allowed'); 

//check content type
$content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
if(stripos($content_type,'application/json') === false){ 
	//throw new Exception('Content type must be json');
}
//Read the input stream
$body = file_get_contents("php://input"); ////*********** syntax error, unexpected ':', expecting ',' or ')'
//decode the json object
$object = json_decode($body, true);
//Throw an exception if decoding fails
if(!is_Array($object))
{	
//throw new Exception('Faild in decoding json object!');
}
//echo "print:".$object['courseTitle'];
if($object['title'] != null && $object['field'] != null && $object['description'] != null &&isset($object['c_id']) ){
		$pdo  =  pdo_dbconn();
	$stmt = $pdo->prepare("UPDATE course SET name = ?, field=?, description=? WHERE id = ?;");
			$stmt->bindValue(1, $object['title']);
			$stmt->bindValue(2, $object['field']);
			$stmt->bindValue(3, $object['description']);
			$stmt->bindValue(4, $object['c_id']);
						$result = $stmt->execute();
						echo $result;
			header('Location:info.php?id=' . $course_id);
}
else{
				echo "Please fill all required fields.";
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
}

?>
	










zzz