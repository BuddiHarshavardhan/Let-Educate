<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


if($_POST) {	

  $productName 		= $_POST['productName'];
  //echo $productName ;exit;
  
  $rate 			= $_POST['rate'];
//   $brandName 		= $_POST['brandName'];
  $categoryName 	= $_POST['categoryName'];
  $quantity	        = $_POST['quantity'];
  
  
  $productStatus 	= $_POST['productStatus'];
	//$type = explode('.', $_FILES['productImage']['name']);
	
	$orderDate=date('Y-m-d');
				$sql = "INSERT INTO `product` (`product_name`, `categories_id`, `rate`, `mrp`,`added_date`,`active`, `status`) 
				VALUES ('$productName', '$categoryName', '$rate', '$quantity', '$orderDate', '$productStatus', 1)";
//echo $sql;exit;
				if($connect->query($sql) === TRUE) { //echo "sdafsf";exit;
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
					header('location:../products.php');	
				} 
				
			// /else	
		// if
	// if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST