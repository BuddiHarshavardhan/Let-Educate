<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


if($_POST) {	

  $insurer_name 		= $_POST['insurer'];
 

				$sql = "INSERT INTO `insurer` (`insurer_name`) 
				VALUES ('$insurer_name')";
//echo $sql;exit;
				if($connect->query($sql) === TRUE) { //echo "sdafsf";exit;
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
					header('location:../insurer.php');	
				} 
				
			// /else	
		// if
	// if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST