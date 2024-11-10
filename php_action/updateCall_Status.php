<?php
include('../constant/connect.php');

if (isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    // Update the call status to 1 (called)
    $sql = "UPDATE brands SET call_status = 1 WHERE brand_id = '$brand_id'";

    if ($connect->query($sql) === TRUE) {
        echo "Call status updated successfully";
        header('Location: ../brand.php'); // Redirect back to the view page
    } else {
        echo "Error updating record: " . $connect->error;
    }

    $connect->close();
} else {
    echo "Invalid request";
}
?>
