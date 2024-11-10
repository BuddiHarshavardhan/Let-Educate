<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$lead_name = $_POST['lead'];
    $phone = $_POST['phone'];
    $email = $_POST['email']; 
    $city = $_POST['city'];
    $interest = $_POST['interest'];
    $source = $_POST['source'];
	$requirement = $_POST['requirement'];

	$date = $_POST['date'];

    
    $status = $_POST['status'];

	$sql = "INSERT INTO `lead`(`lead_name`, `phone`, `email`, `city`,`date`, `interest`, `source`,`requirement`, `status`) VALUES ('$lead_name', '$phone','$email','$city','$date','$interest','$source','$requirement','$status')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
		header('location:../leads.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST