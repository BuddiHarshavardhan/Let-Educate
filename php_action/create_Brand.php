<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['brandName'];
  $remarks= $_POST['remarks']; 
  $brandActive = $_POST['brandActive'];

	$sql = "INSERT INTO `brands` (`brand_name`, `brand_active`, `remarks`) VALUES ('$brandName', '$brandActive', '$remarks')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
		header('location:fetch_Brand.php');	
	}  
	  
     else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	 	header('location:../call.php');
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST