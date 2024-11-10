<?php 	

require_once 'core.php';

//$valid['success'] = array('success' => false, 'messages' => array());
$brandId = $_GET['id'];
//echo $brandId;exit;
if($_POST) {	
//echo "123";exit;
	$name = $_POST['name'];
  $phone = $_POST['phone'];
  $role = $_POST['role'];

  
//echo $brandId;exit;
	$sql = "UPDATE 	`staff` SET `name` = '$name', `phone` = '$phone',`role`='$role' WHERE id = '$brandId'";
//echo $sql;exit;
	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
		header('location:../staff.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST