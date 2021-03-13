




<?php 
include_once 'db_conn.php';
//require_once('db_conn.php');
$action=isset($_POST['action'])?$_POST['action']:'';
$id=isset($_POST['id'])?$_POST['id']:0;
//only post requests
if($action=="updateimg"){} 

if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST'){
//throw new Exception('Only POST requests are allowed');
}
//read input stream
$body = file_get_contents("php://input");

if(!empty($_FILES['images']['name'])){
$image = addslashes(file_get_contents($_FILES['images']['tmp_name']));} 

// Define the Base64 value you need to save as an image
// Obtain the original content (usually binary data)
$bin = base64_decode($image); //maybe json

// Load GD resource from binary data
$im = imageCreateFromString($bin);

// Make sure that the GD library was able to load the image
if (!$im) {
  die('Base64 value is not a valid image');
}
					imagepng($im, $img_file, 0);
// Specify the location where you want to save the image GO TO ->[DATABASE];
$pdo  =  pdo_dbconn();
	$stmt = $pdo->prepare("UPDATE course SET book_cover = ? WHERE id = ?;");
			$stmt->bindValue(1, $image);
			$stmt->bindValue(2, $id);
						$result = $stmt->execute();
						if($result)
						echo $image;
?>