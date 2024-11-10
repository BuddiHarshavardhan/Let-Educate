<?php 	

require_once 'core.php';

//$valid['success'] = array('success' => false, 'messages' => array());
$brandId = $_GET['id'];
//echo $brandId;exit;
if($_POST) {	
//echo "123";exit;
	$name = $_POST['name'];
  $visa_fee = $_POST['visa_fee'];

  
//echo $brandId;exit;
	$sql = "UPDATE 	`country` SET `name` = '$name', `visa_fee` = '$visa_fee'  WHERE id = '$brandId'";
//echo $sql;exit;
	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
		header('location:../countries.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the countries";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST