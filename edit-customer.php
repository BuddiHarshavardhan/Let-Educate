<?php
// Include necessary files
include('./constant/connect.php'); // Ensure the database connection is included first
session_start();

// Check if user is logged in and has appropriate permissions (replace with your authentication logic)
if (!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php'); // Redirect unauthorized users to login page
    exit();
}

// Initialize variables
$customer = []; // Array to store customer details

// Check if customer ID is provided in the URL
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer data from the database based on ID
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if customer exists
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc(); // Fetch customer details
    } else {
        $_SESSION['error'] = "Customer not found.";
        header("Location: manage-customer.php"); // Redirect if customer not found
        exit();
    }

    // Handle form submission for updating customer details
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission for updating customer details
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $insurer = $_POST['insurer'];
        $plan = $_POST['plan'];
        $pro = $_POST['pro'];

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $booking_date = $_POST['booking_date'];
        $premium = $_POST['premium'];
        $address = $_POST['address'];
        $freelancer = $_POST['freelancer'];
        $company = $_POST['company'];
        $application = $_POST['app'];
        $policy = $_POST['policy'];
        $remarks = $_POST['remarks'];

        // Handle file uploads
        $aadhar = $customer['aadhar'];
        $pan = $customer['pan'];
        $photo = $customer['photo'];
        $bank = $customer['bank'];
        $payment = $customer['payment'];
        $bi = $customer['bi'];
        $proposal = $customer['proposal'];

        // Check and handle file uploads
        if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] == UPLOAD_ERR_OK) {
            $aadhar = 'uploads/' . basename($_FILES['aadhar']['name']);
            move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadhar);
        }

        if (isset($_FILES['pan']) && $_FILES['pan']['error'] == UPLOAD_ERR_OK) {
            $pan = 'uploads/' . basename($_FILES['pan']['name']);
            move_uploaded_file($_FILES['pan']['tmp_name'], $pan);
        }

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $photo = 'uploads/' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }

        if (isset($_FILES['bank']) && $_FILES['bank']['error'] == UPLOAD_ERR_OK) {
            $bank = 'uploads/' . basename($_FILES['bank']['name']);
            move_uploaded_file($_FILES['bank']['tmp_name'], $bank);
        }

        if (isset($_FILES['payment']) && $_FILES['payment']['error'] == UPLOAD_ERR_OK) {
            $payment = 'uploads/' . basename($_FILES['payment']['name']);
            move_uploaded_file($_FILES['payment']['tmp_name'], $payment);
        }

        if (isset($_FILES['bi']) && $_FILES['bi']['error'] == UPLOAD_ERR_OK) {
            $bi = 'uploads/' . basename($_FILES['bi']['name']);
            move_uploaded_file($_FILES['bi']['tmp_name'], $bi);
        }

        if (isset($_FILES['proposal']) && $_FILES['proposal']['error'] == UPLOAD_ERR_OK) {
            $proposal = 'uploads/' . basename($_FILES['proposal']['name']);
            move_uploaded_file($_FILES['proposal']['tmp_name'], $proposal);
        }

        // Update customer details in the database
        $update_query = "UPDATE customers SET name=?, phone=?, email=?, dob=?, insurer=?, plan=?,pro=?, application=?, policy=?, remarks=?, start_date=?, end_date=?, booking_date=?, premium=?, address=?, freelancer=?, company=?, aadhar=?, pan=?, photo=?, bank=?, payment=?, bi=?, proposal=? WHERE id=?";
        $stmt = $connect->prepare($update_query);
        $stmt->bind_param("ssssssssssssssssssssssssi", $name, $phone, $email, $dob, $insurer, $plan,$pro, $application, $policy, $remarks, $start_date, $end_date, $booking_date, $premium, $address, $freelancer, $company, $aadhar, $pan, $photo, $bank, $payment, $bi, $proposal, $customer_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Customer updated successfully";
            header("Location: manage-customer.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating customer: " . $connect->error;
        }
    }
} else {
    // Customer ID is not provided in the URL
    $_SESSION['error'] = "Customer ID is missing.";
    header("Location: manage-customer.php"); // Redirect if customer ID is missing
    exit();
}

include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Customer</h3>
        </div>
    </div>

    <div class="container-fluid">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name">Customer Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="app">Application Number:</label>
                            <input type="text" class="form-control" id="app" name="app" value="<?php echo htmlspecialchars($customer['application']); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="policy">Policy Number:</label>
                            <input type="text" class="form-control" id="policy" name="policy" value="<?php echo htmlspecialchars($customer['policy']); ?>">
                        </div>
                        <div class="form-group col-md-4">   
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($customer['dob']); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="insurer">Insurer Name:</label>
                            <!-- <input type="text" class="form-control" id="insurer" name="insurer" value="<?php echo htmlspecialchars($customer['insurer']); ?>"> -->
                            <select class="form-control" id="insurer" name="insurer" >
                                <option value="">~~SELECT~~</option>
                                <?php 
                                $sql = "SELECT * FROM insurer";
                                $result = $connect->query($sql);

                                while ($row = $result->fetch_array()) {
                                    $selected = ($row[1] == $customer['insurer']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                                    <label class="control-label">Plan Name</label>
                                    <input type="text" class="form-control" id="pro" placeholder="Plan Name" name="pro"  value="<?php echo htmlspecialchars($customer['pro']); ?>">
                                </div>
                        <div class="form-group col-md-4">
                            <label for="plan">Product Name:</label>
                            <select class="form-control" id="plan" name="plan" >
                                <option value="">~~SELECT~~</option>
                                <?php 
                                $sql = "SELECT * FROM product";
                                $result = $connect->query($sql);

                                while ($row = $result->fetch_array()) {
                                    $selected = ($row[0] == $customer['plan']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($customer['start_date']); ?>">
                        </div>
                   
                        <div class="form-group col-md-4">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($customer['end_date']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="booking_date">Booking Date:</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($customer['booking_date']); ?>">
                        </div>
                        </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="premium">Premium:</label>
                            <input type="text" class="form-control" id="premium" name="premium" value="<?php echo htmlspecialchars($customer['premium']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="aadhar">Aadhar:</label>
                            <input type="file" class="form-control" id="aadhar" name="aadhar">
                            <small>Current File: <?php echo htmlspecialchars($customer['aadhar']); ?></small>
                        </div>
                        </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="pan">Pan:</label>
                            <input type="file" class="form-control" id="pan" name="pan">
                            <small>Current File: <?php echo htmlspecialchars($customer['pan']); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            <small>Current File: <?php echo htmlspecialchars($customer['photo']); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bank">Bank:</label>
                            <input type="file" class="form-control" id="bank" name="bank">
                            <small>Current File: <?php echo htmlspecialchars($customer['bank']); ?></small>
                        </div>
                        </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="payment">Payment Receipt:</label>
                            <input type="file" class="form-control" id="payment" name="payment">
                            <small>Current File: <?php echo htmlspecialchars($customer['payment']); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bi">BI:</label>
                            <input type="file" class="form-control" id="bi" name="bi">
                            <small>Current File: <?php echo htmlspecialchars($customer['bi']); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="proposal">Proposal:</label>
                            <input type="file" class="form-control" id="proposal" name="proposal">
                            <small>Current File: <?php echo htmlspecialchars($customer['proposal']); ?></small>
                        </div>
                        </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="freelancer">Agent Name:</label>
                            <select class="form-control" id="freelancer" name="freelancer" >
                                <option value="">~~SELECT~~</option>
                                <?php 
                                $sql = "SELECT * FROM agents";
                                $result = $connect->query($sql);

                                while ($row = $result->fetch_array()) {
                                    $selected = ($row[2] == $customer['freelancer']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="company">Company Name:</label>
                            <select class="form-control" id="company" name="company">
                                <option value="">~~SELECT~~</option>
                                <option value="Probus" <?php echo ($customer['company'] == 'Probus') ? 'selected' : ''; ?>>Probus</option>
                                <option value="Turtlemint" <?php echo ($customer['company'] == 'Turtlemint') ? 'selected' : ''; ?>>Turtlemint</option>
                                <option value="Policybazaar" <?php echo ($customer['company'] == 'Policybazaar') ? 'selected' : ''; ?>>Policybazaar</option>
                                <option value="Zopper" <?php echo ($customer['company'] == 'Zopper') ? 'selected' : ''; ?>>Zopper</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="remarks">Remarks:</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="5"><?php echo htmlspecialchars($customer['remarks'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:10%";>Update Customer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>


