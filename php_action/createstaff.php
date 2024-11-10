<?php
include('../constant/connect.php');

$response = array('success' => false, 'messages' => '', 'data' => null);

if ($_POST) {
    // Generate new Staff ID
    $sql = "SELECT count(*) AS cnt FROM staff";
    $row = $connect->query($sql)->fetch_assoc();
    $staff_id = 'S' . sprintf('%05d', intval($row['cnt']) + 1); // New Staff ID

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Insert new staff record
    $sql = "INSERT INTO staff (staff_id, name, phone, role) VALUES ('$staff_id', '$name', '$phone', '$role')";

    if ($connect->query($sql) === TRUE) {
        $response['success'] = true;
        $response['messages'] = "Staff successfully added!";
        $response['data'] = array(
            'staff_id' => $staff_id, // Use the newly generated staff_id
            'name' => $name,
            'phone' => $phone,
            'role' => $role
        );
    } else {
        $response['messages'] = "Error while adding staff: " . $connect->error;
    }
}

echo json_encode($response); // Return JSON response
?>
