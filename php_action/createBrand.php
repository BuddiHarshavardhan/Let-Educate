<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

$brandName = $_POST['student'];
$brandActive = $_POST['phone'];
$remarks = $_POST['remarks'];



	$sql = "INSERT INTO `calls` (`name`, `phone`,`remarks`) VALUES ('$brandName', '$brandActive','$remarks')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
		header('location:../brand.php');	
	}  
	  
     else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	 	header('location:../brand.php');
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST