<?php 
require_once 'core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandId = $_POST['brand_id'];

    if ($brandId) { 
        // Prepare a DELETE statement
        $sql = "DELETE FROM brands WHERE brand_id = ?";

        // Prepare and bind parameters
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $brandId);

        // Execute the statement
        if ($stmt->execute()) {
            $valid['success'] = true;
            $valid['messages'] = "Brand deleted successfully";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Error deleting the brand";
        }

        // Close the statement
        $stmt->close();

        // Close the database connection
        $connect->close();

        // Redirect back to the referring page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>
