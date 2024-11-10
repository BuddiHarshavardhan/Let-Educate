<?php
include('../constant/connect.php');

if (isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    // Delete the brand record
    $sql = "DELETE FROM `staff` WHERE id = '$brand_id'";

    if ($connect->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header('Location: ../staff.php'); // Redirect back to the view page
    } else {
        echo "Error deleting record: " . $connect->error;
    }

    $connect->close();
} else {
    echo "Invalid request";
}
?>
