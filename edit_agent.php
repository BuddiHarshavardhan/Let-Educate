<?php
ob_start(); // Start output buffering

// Include necessary files
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./side.php');
include('./constant/connect.php'); // Corrected file inclusion with .php extension

// Check if agent ID is provided in the URL
if(isset($_GET['id'])) {
    $agent_id = $_GET['id'];

    // Fetch agent data from the database based on ID using prepared statement
    $sql = "SELECT * FROM agents WHERE id = ?";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        die('Error preparing statement: ' . htmlspecialchars($connect->error));
    }
    $stmt->bind_param("i", $agent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $agent = $result->fetch_assoc();

    // Check if agent exists
    if($agent) {
        // Agent found, proceed with editing
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submission for updating agent details
            $agentCode = $_POST['agentCode'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $alt_phone = $_POST['alt_phone'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $doj = $_POST['doj'];
            $address = $_POST['address'];
            $companyName = $_POST['companyName'];

            // Handle file uploads for Aadhar
            $aadhar = $agent['aadhar'];
            if ($_FILES['aadhar']['error'] === UPLOAD_ERR_OK) {
                $aadhar_tmp = $_FILES['aadhar']['tmp_name'];
                $aadhar_name = basename($_FILES['aadhar']['name']);
                $aadhar_destination = 'uploads/' . $aadhar_name;
                if (move_uploaded_file($aadhar_tmp, $aadhar_destination)) {
                    $aadhar = $aadhar_destination;
                } else {
                    echo "Error uploading Aadhar file.";
                }
            }

            // Handle file uploads for PAN
            $pan = $agent['pan'];
            if ($_FILES['pan']['error'] === UPLOAD_ERR_OK) {
                $pan_tmp = $_FILES['pan']['tmp_name'];
                $pan_name = basename($_FILES['pan']['name']);
                $pan_destination = 'uploads/' . $pan_name;
                if (move_uploaded_file($pan_tmp, $pan_destination)) {
                    $pan = $pan_destination;
                } else {
                    echo "Error uploading PAN file.";
                }
            }

            // Handle file uploads for Photo
            $photo = $agent['photo'];
            if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photo_tmp = $_FILES['photo']['tmp_name'];
                $photo_name = basename($_FILES['photo']['name']);
                $photo_destination = 'uploads/' . $photo_name;
                if (move_uploaded_file($photo_tmp, $photo_destination)) {
                    $photo = $photo_destination;
                } else {
                    echo "Error uploading Photo file.";
                }
            }

            // Handle file uploads for Bank
            $bank = $agent['bank'];
            if ($_FILES['bank']['error'] === UPLOAD_ERR_OK) {
                $bank_tmp = $_FILES['bank']['tmp_name'];
                $bank_name = basename($_FILES['bank']['name']);
                $bank_destination = 'uploads/' . $bank_name;
                if (move_uploaded_file($bank_tmp, $bank_destination)) {
                    $bank = $bank_destination;
                } else {
                    echo "Error uploading Bank file.";
                }
            }

            // Update agent details in the database using prepared statement
            $update_query = "UPDATE agents SET agentCode=?, name=?, phone=?, alt_phone=?, email=?, dob=?, doj=?, address=?, companyName=?, aadhar=?, pan=?, photo=?, bank=? WHERE id=?";
            $stmt = $connect->prepare($update_query);
            if ($stmt === false) {
                die('Error preparing update statement: ' . htmlspecialchars($connect->error));
            }
            $stmt->bind_param("ssssssssssssss", $agentCode, $name, $phone, $alt_phone, $email, $dob, $doj, $address, $companyName, $aadhar, $pan, $photo, $bank, $agent_id);

            if($stmt->execute()) {
                // Redirect to view agent page after successful update
                header("Location: manage_agent.php");
                exit();
            } else {
                echo "Error updating record: " . htmlspecialchars($stmt->error);
            }
        }
    } else {
        // Agent not found with the provided ID
        echo "Agent not found.";
    }
} else {
    // Agent ID is not provided in the URL
    echo "Agent ID is missing.";
}

ob_end_flush(); // Flush the output buffer
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Agent</h3>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="agentCode">Agent Code:</label>
                        <input type="text" class="form-control" id="agentCode" name="agentCode" value="<?php echo htmlspecialchars($agent['agentCode']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Agent Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($agent['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($agent['phone']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">Alternative Phone:</label>
                        <input type="text" class="form-control" id="alt_phone" name="alt_phone" value="<?php echo htmlspecialchars($agent['alt_phone']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($agent['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($agent['dob']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="doj">Date of Joining:</label>
                        <input type="date" class="form-control" id="doj" name="doj" value="<?php echo htmlspecialchars($agent['doj']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($agent['address']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="companyName">Company Name:</label>
                        <!-- <input type="text" class="form-control" id="companyName" name="companyName" value="<?php echo htmlspecialchars($agent['companyName']); ?>"> -->
                        <select type="text" class="form-control" id="companyName" name="companyName" value="<?php echo htmlspecialchars($agent['companyName']); ?>">
    <option value="">~~SELECT~~</option>
    <?php 
    $sql = "SELECT company FROM company";
    $result = $connect->query($sql);

    while($row = $result->fetch_assoc()) {
        echo "<option value='".htmlspecialchars($row['company'])."'>".htmlspecialchars($row['company'])."</option>";
    }
    ?>
</select>
                    </div>
                    <div class="form-group">
                        <label for="aadhar">Aadhar:</label>
                        <input type="file" class="form-control" id="aadhar" name="aadhar">
                    </div>
                    <div class="form-group">
                        <label for="pan">Pan:</label>
                        <input type="file" class="form-control" id="pan" name="pan">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo:</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank:</label>
                        <input type="file" class="form-control" id="bank" name="bank">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Agent</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>
