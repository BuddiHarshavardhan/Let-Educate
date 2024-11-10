<?php 	

require_once 'core.php';

//$valid['success'] = array('success' => false, 'messages' => array());
$brandId = $_GET['id'];
//echo $brandId;exit;
if($_POST) {	
//echo "123";exit;
	$name = $_POST['name'];
  $hostel_fee = $_POST['hostel_fee'];

  
//echo $brandId;exit;
	$sql = "UPDATE 	`university` SET `name` = '$name', `hostel_fee` = '$hostel_fee'WHERE id = '$brandId'";
//echo $sql;exit;
	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
		header('location:../universities.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the universities";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST