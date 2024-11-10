<?php 

require_once 'core.php';

$Id = $_GET['id'];
if($Id) { 
    // Prepare the DELETE statement
    $sql = "DELETE FROM lead WHERE id = ?";

    // Initialize the prepared statement
    $stmt = $connect->prepare($sql);
    if ($stmt) {
        // Bind the parameter to the statement
        $stmt->bind_param("i", $Id);

        // Execute the statement
        if ($stmt->execute()) {
            $valid['success'] = true;
            $valid['messages'] = "Successfully Removed";
            header('Location: ../leads.php');
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Error while removing the lead";
        }

        // Close the statement
        $stmt->close();
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while preparing the statement";
    }

    // Close the database connection
    $connect->close();

    // Return the response in JSON format
    echo json_encode($valid);
}
?>
