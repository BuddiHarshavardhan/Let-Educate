<?php 	

require_once 'core.php';

//$valid['success'] = array('success' => false, 'messages' => array());
$brandId = $_GET['id'];
//echo $brandId;exit;
if($_POST) {	
//echo "123";exit;
	$brandName = $_POST['name'];
  $brandActive = $_POST['phone'];
  $remarks = $_POST['remarks'];

  
//echo $brandId;exit;
	$sql = "UPDATE 	`calls` SET `name` = '$brandName', `phone` = '$brandActive' , `remarks`='$remarks' WHERE id = '$brandId'";
//echo $sql;exit;
	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
		header('location:../brand.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST