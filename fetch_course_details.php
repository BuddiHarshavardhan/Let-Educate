<?php
include 'db_connection.php'; // Include your database connection file

if(isset($_POST['course'])) {
    $course = $_POST['course'];
    
    $sql = "SELECT tution_fee, scholarship FROM courses WHERE name = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'tution_fee' => $row['tution_fee'],
            'scholarship' => $row['scholarship']
        ]);
    } else {
        echo json_encode(['tution_fee' => '', 'scholarship' => '']);
    }

    $stmt->close();
}
?>
