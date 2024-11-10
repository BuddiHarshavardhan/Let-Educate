<?php 	
require_once 'core.php';

$valid = ['success' => false, 'messages' => '', 'data' => []];

if ($_POST) {	
    $course = $_POST['name'];
    $tution = $_POST['tution_fee'];
    $scholarship = $_POST['scholarship'];

    // Insert course data
    $sql = "INSERT INTO courses (name, tution_fee, scholarship) VALUES ('$course', '$tution', '$scholarship')";

    if ($connect->query($sql) === TRUE) {
        $valid['success'] = true;
        $valid['messages'] = "Successfully Added";

        // Fetch last inserted data to append to table without refresh
        $last_id = $connect->insert_id;
        $valid['data'] = [
            'id' => $last_id,
            'name' => $course,
            'tution_fee' => $tution,
            'scholarship' => $scholarship
        ];
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while adding the course";
    }

    $connect->close();

    echo json_encode($valid);
}
?>
