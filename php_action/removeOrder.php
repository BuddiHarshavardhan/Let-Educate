<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

// $orderId = $_POST['orderId'];
$orderId = $_GET['id'];
if ($orderId) {
    // Prepare the SQL queries
    $sql = "UPDATE orders SET order_status = 2 WHERE order_id = {$orderId}";
    // $orderItem = "UPDATE order_item SET order_status = 2 WHERE order_id = {$orderId}";

    // Execute the queries and check for errors
    if ($connect->query($sql) === TRUE ) {
        $valid['success'] = true;
        $valid['messages'] = "Successfully Removed";
        
        // Close the connection
        $connect->close();
        
        // Redirect to Order.php
        header('Location: ../Order.php');
        exit();
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while removing the order: " . $connect->error;
    }

    // Close the connection
    $connect->close();

    // Output the response in JSON format
    echo json_encode($valid);
}
?>
