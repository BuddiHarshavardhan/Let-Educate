<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


if($_POST) {	

  $productName 		= $_POST['productName'];
 

				$sql = "INSERT INTO `product` (`product_name`) 
				VALUES ('$productName')";
//echo $sql;exit;
				if($connect->query($sql) === TRUE) { //echo "sdafsf";exit;
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
					header('location:../product.php');	
				} 
				
			// /else	
		// if
	// if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST