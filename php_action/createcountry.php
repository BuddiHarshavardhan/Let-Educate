<?php 	
require_once 'core.php';

$valid = ['success' => false, 'messages' => '', 'data' => []];

if ($_POST) {	
    $country = $_POST['country'];
    $visa_fee = $_POST['visa_fee'];

    // Insert course data
    $sql = "INSERT INTO country (name, visa_fee) VALUES ('$country', '$visa_fee')";

    if ($connect->query($sql) === TRUE) {
        $valid['success'] = true;
        $valid['messages'] = "Successfully Added";

        // Fetch last inserted data to append to table without refresh
        $last_id = $connect->insert_id;
        $valid['data'] = [
            'id' => $last_id,
            'name' => $country,
            'tution_fee' => $visa_fee,
        ];
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while adding the country";
    }

    $connect->close();

    echo json_encode($valid);
}
?>
