<?php 
require_once('./constant/connect.php');


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = trim($_POST['name']);
    $customer_phone = trim($_POST['phone']);
    $customer_application = trim($_POST['app']);
    $customer_policy = trim($_POST['policy']);

    $customer_email = trim($_POST['email']);
    $customer_dob = trim($_POST['dob']);
    $customer_insurer = trim($_POST['insurer']);
    $customer_pro = trim($_POST['pro']);

    $customer_plan = trim($_POST['plan']);
    $customer_start_date = trim($_POST['start_date']);
    $customer_end_date = trim($_POST['end_date']);
    $customer_booking = trim($_POST['booking_date']);
    $customer_premium = trim($_POST['premium']);
    $customer_agent = trim($_POST['freelancer']);
    $customer_company = trim($_POST['company']);
    $customer_address = trim($_POST['address']);
    $customer_aadhar = $_FILES['aadhar'];
    $customer_pan = $_FILES['pan'];
    $customer_photo = $_FILES['photo'];
    $customer_bank = $_FILES['bank'];
    $customer_payment = $_FILES['payment'];
    $customer_bi = $_FILES['bi'];
    $customer_proposal = $_FILES['proposal'];

    $customer_remarks = trim($_POST['remarks']);

    $target_dir = "uploads/";
    $aadhar_path = $target_dir . basename($customer_aadhar["name"]);
    $pan_path = $target_dir . basename($customer_pan["name"]);
    $photo_path = $target_dir . basename($customer_photo["name"]);
    $bank_path = $target_dir . basename($customer_bank["name"]);
    $payment_path = $target_dir . basename($customer_payment["name"]);
    $bi_path = $target_dir . basename($customer_bi["name"]);
    $proposal_path = $target_dir . basename($customer_proposal["name"]);


    // if(empty($errors)) {
    //     if(!move_uploaded_file($customer_aadhar["tmp_name"], $aadhar_path)) {
    //         $errors[] = "Error uploading Aadhar.";
    //     }
    //     if(!move_uploaded_file($customer_pan["tmp_name"], $pan_path)) {
    //         $errors[] = "Error uploading PAN.";
    //     }
    //     if(!move_uploaded_file($customer_photo["tmp_name"], $photo_path)) {
    //         $errors[] = "Error uploading Photo.";
    //     }
    //     if(!move_uploaded_file($customer_bank["tmp_name"], $bank_path)) {
    //         $errors[] = "Error uploading bank photo.";
    //     }
    // }

    // Insert data into the database if no errors
    $sql = "INSERT INTO `customers` (`name`, `phone`, `application`, `policy`, `email`, `dob`, `insurer`, `pro`,`plan`, `start_date`, `end_date`, `booking_date`, `premium`, `address`,`company`, `aadhar`, `pan`, `photo`, `bank`, `payment`, `bi`, `proposal`, `freelancer`, `remarks`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ssssssssssssssssssssssss", $customer_name, $customer_phone, $customer_application, $customer_policy, $customer_email, $customer_dob, $customer_insurer,$customer_pro, $customer_plan, $customer_start_date, $customer_end_date, $customer_booking, $customer_premium, $customer_address,$customer_company, $aadhar_path, $pan_path, $photo_path, $bank_path, $payment_path, $bi_path, $proposal_path, $customer_agent, $customer_remarks);

if($stmt->execute()) {
    header('location: manage-customer.php');
    exit();
} else {
    $errors[] = 'Error adding customer. Please try again.';
}
$stmt->close();

     
    }

?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./side.php'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Add Customer</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Customer</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-title"></div>
                    <div id="add-agent-messages"></div>
                    <div class="card-body">
                        <div class="input-states">
                            <form class="row" method="POST" id="submitAgentForm" action="" enctype="multipart/form-data">
                                
                                <div class="form-group col-md-4">
                                    <label class="control-label">Customer Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required >
                                </div>
                                <div class="form-group col-md-4">
    <label class="control-label">Phone</label>
    <input type="tel" class="form-control" id="phone" placeholder="Phone" name="phone" 
           pattern="\d{10}" maxlength="10" title="Please enter a 10-digit phone number" required>
</div>

                                <div class="form-group col-md-4">
                                    <label class="control-label">Application Number</label>
                                    <input type="text" class="form-control" id="app" placeholder="application number" name="app" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Policy Number</label>
                                    <input type="text" class="form-control" id="policy" placeholder="Policy Number" name="policy"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Date Of Birth</label>
                                    <input type="date" class="form-control" id="dob" placeholder="DoB" name="dob" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Insurer Name</label>
                                    <!-- <input type="text" class="form-control" id="insurer" placeholder="Insurer Name" name="insurer" > -->
                                    <select type="text" class="form-control" id="insurer"  name="insurer" >
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * from insurer";
                                $result = $connect->query($sql);

                                while($row = $result->fetch_array()) {
                                    echo "<option value='".$row[1]."'>".$row[1]."</option>";
                                } // while
                                
                        ?>
                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Plan Name</label>
                                    <input type="text" class="form-control" id="pro" placeholder="Plan Name" name="pro" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Product Name</label>
                                    <!-- <input type="text" class="form-control" id="plan" placeholder="planName" name="plan" > -->
                                    <select type="text" class="form-control" id="plan"  name="plan" >
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * from product";
                                $result = $connect->query($sql);

                                while($row = $result->fetch_array()) {
                                    echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                } // while
                                
                        ?>
                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" placeholder="Start Date" name="start_date"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" placeholder="End Date" name="end_date" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Booking Date</label>
                                    <input type="date" class="form-control" id="booking_date" placeholder="Booking Date" name="booking_date" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Premium</label>
                                    <input type="text" class="form-control" id="premium" placeholder="Premium" name="premium" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Agent Name</label>
                                    <!-- <input type="text" class="form-control" id="freelancer" placeholder="Agent Name" name="freelancer" > -->
                                    <select type="text" class="form-control" id="freelancer"  name="freelancer" >
                        <option value="">~~SELECT~~</option>
                        <?php 
$sql = "SELECT * FROM agents";
$result = $connect->query($sql);

while ($row = $result->fetch_array()) {
    echo "<option value='" . htmlspecialchars($row[2]) . "'>" . htmlspecialchars($row[2]) . "</option>";
}
?>

                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Broking Name</label>
                                    <!-- <input type="text" class="form-control" id="company" placeholder="Broking Name" name="company" > -->
                                    <select class="form-control" id="company" name="company" >
                        <option value="">~~SELECT~~</option>
                        <option value="Probus">Probus</option>
                        <option value="Turtlemint">Turtlemint</option>
                        <option value="Policybaazar">Policybazaar</option>
                        <option value="Zopper">Zopper</option>


                      </select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Address" name="address" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Aadhar</label>
                                    <input type="file" class="form-control" id="aadhar" name="aadhar" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Pan</label>
                                    <input type="file" class="form-control" id="pan" name="pan" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Bank</label>
                                    <input type="file" class="form-control" id="bank" name="bank" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Payment Reciept</label>
                                    <input type="file" class="form-control" id="payment" name="payment" >
                                </div> <div class="form-group col-md-4">
                                    <label class="control-label">BI</label>
                                    <input type="file" class="form-control" id="bi" name="bi" >
                                </div> <div class="form-group col-md-4">
                                    <label class="control-label">Proposal</label>
                                    <input type="file" class="form-control" id="proposal" name="proposal" >
                                </div>
                                <div class="form-group col-md-12">
    <label class="control-label">Remarks</label>
    <textarea class="form-control" id="remarks" name="remarks" placeholder="Enter your remarks" rows="10" cols="500" ></textarea>
</div>

                                <div class="form-group col-md-12">
                                    <button type="submit" name="create" id="createAgentBtn" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                                </div>
                            </form>

                            <?php if(!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach($errors as $error): ?>
                                            <li><?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('./constant/layout/footer.php'); ?>

</div>
