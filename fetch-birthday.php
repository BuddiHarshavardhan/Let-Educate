<?php
// Include database connection
// Include database connection
include('./constant/connect.php');

// Query to fetch customers with today's birthday
$currentDate = date('Y-m-d');
$sqlCustomers = "SELECT * FROM customers WHERE DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$currentDate', '%m-%d')";
$resultCustomers = $connect->query($sqlCustomers);

// Query to fetch agents with today's birthday
$sqlAgents = "SELECT * FROM agents WHERE DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$currentDate', '%m-%d')";
$resultAgents = $connect->query($sqlAgents);

// Combine results into a single array
$data = array();
if ($resultCustomers->num_rows > 0) {
    while ($row = $resultCustomers->fetch_assoc()) {
        $data[] = $row;
    }
}
if ($resultAgents->num_rows > 0) {
    while ($row = $resultAgents->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data); // Send combined data as JSON response

$connect->close();

?>
