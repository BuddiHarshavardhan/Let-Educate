<?php 	

require_once 'core.php';

//$valid['success'] = array('success' => false, 'messages' => array());
$brandId = $_GET['id'];
//echo $brandId;exit;
if($_POST) {	
//echo "123";exit;
	$name = $_POST['name'];
  $tution = $_POST['tution'];
  $scholarship = $_POST['scholarship'];

  
//echo $brandId;exit;
	$sql = "UPDATE 	`courses` SET `name` = '$name', `tution_fee` = '$tution' , `scholarship`='$scholarship' WHERE id = '$brandId'";
//echo $sql;exit;
	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
		header('location:../courses.php');	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the courses";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST