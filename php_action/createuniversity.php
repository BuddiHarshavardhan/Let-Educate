<?php 	
require_once 'core.php';

$valid = ['success' => false, 'messages' => '', 'data' => []];

if ($_POST) {	
    $name = $_POST['name'];
    $hostel_fee = $_POST['hostel_fee'];

    // Insert course data
    $sql = "INSERT INTO university (name, hostel_fee) VALUES ('$name', '$hostel_fee')";

    if ($connect->query($sql) === TRUE) {
        $valid['success'] = true;
        $valid['messages'] = "Successfully Added";

        // Fetch last inserted data to append to table without refresh
        $last_id = $connect->insert_id;
        $valid['data'] = [
            'id' => $last_id,
            'name' => $name,
            'hostel_fee' => $hostel_fee,
        ];
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while adding the country";
    }

    $connect->close();

    echo json_encode($valid);
}
?>
