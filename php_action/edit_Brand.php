<?php
include('../constant/connect.php');

if (isset($_GET['id'])) {
    $brandId = $_GET['id'];
    $brandName = $_POST['brandName'];
    $brandActive = $_POST['brandActive'];
    $remarks = $_POST['remarks'];



    // Update query
    $sql = "UPDATE brands SET brand_name='$brandName', brand_active='$brandActive',remarks='$remarks' WHERE brand_id='$brandId'";

    if ($connect->query($sql) === TRUE) {
        // Redirect to call.php after successful update
        header("Location: ../call.php?id=$brandId");
        exit();
    } else {
        echo "Error updating record: " . $connect->error;
    }
}

$connect->close();
?>
