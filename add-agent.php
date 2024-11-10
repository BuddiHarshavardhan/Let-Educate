<?php 
require_once('./constant/connect.php');
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $agentCode = trim($_POST['agentCode']);
    $agentName = trim($_POST['name']);
    $agentPhone = trim($_POST['phone']);
    $altPhone = trim($_POST['alt']);
    $agentEmail = trim($_POST['email']);
    $agentDob = trim($_POST['dob']);
    $agentAddress = trim($_POST['address']);
    $companyName = trim($_POST['companyName']);
    $dateOfJoining = trim($_POST['doj']);
    $aadharFile = $_FILES['aadhar'];
    $panFile = $_FILES['pan'];
    $photoFile = $_FILES['photo'];
    $bankFile = $_FILES['bank'];
    $eduFile = $_FILES['edu'];


   
    // Validate file uploads
    $uploadDir = "uploads/";
    $aadharPath = $uploadDir . basename($aadharFile["name"]);
    $panPath = $uploadDir . basename($panFile["name"]);
    $photoPath = $uploadDir . basename($photoFile["name"]);
    $bankPath = $uploadDir . basename($bankFile["name"]);
    $eduPath = $uploadDir . basename($eduFile["name"]);


    

   
    // Insert data into the database if no errors
    if(empty($errors)) {
        $sql = "INSERT INTO `agents` (`agentCode`, `name`, `phone`, `alt_phone`, `email`, `dob`, `address`, `companyName`, `doj`, `aadhar`, `pan`, `photo`, `bank`,`edu`) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssssssssssssss", $agentCode, $agentName, $agentPhone, $altPhone, $agentEmail, $agentDob, $agentAddress, $companyName, $dateOfJoining, $aadharPath, $panPath, $photoPath, $bankPath,$eduPath);

        if($stmt->execute()) {
            $_SESSION['success'] = 'Agent added successfully';
            header('location: manage-agent.php');
            exit();
        } else {
            $errors[] = 'Error adding agent. Please try again.';
        }

        $stmt->close();
    }
}
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Add Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Agent</li>
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
                            <form class="row" method="POST" id="submitAgentForm" action="add-agent.php" enctype="multipart/form-data">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Agent Code</label>
                                    <input type="text" class="form-control" id="agentCode" placeholder="Agent Code" name="agentCode" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Alternative Phone Number</label>
                                    <input type="tel" class="form-control" id="alt" placeholder="Phone" name="alt" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Date Of Birth</label>
                                    <input type="date" class="form-control" id="dob" placeholder="Date of Birth" name="dob" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Address" name="address" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Working Company</label>
                                    <!-- <input type="text" class="form-control" id="companyName" placeholder="Company Name" name="companyName" required> -->
                                    <select type="text" class="form-control" id="companyName" name="companyName">
    <option value="">~~SELECT~~</option>
    <?php 
    $sql = "SELECT `company` FROM `company`";
    $result = $connect->query($sql);

    while($row = $result->fetch_assoc()) {
        echo "<option value='".htmlspecialchars($row['company'])."'>".htmlspecialchars($row['company'])."</option>";
    }
    ?>
</select>

                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Date Of Joining</label>
                                    <input type="date" class="form-control" id="doj" placeholder="Date of Joining" name="doj" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Aadhar</label>
                                    <input type="file" class="form-control" id="aadhar" name="aadhar" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Pan</label>
                                    <input type="file" class="form-control" id="pan" name="pan" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Bank</label>
                                    <input type="file" class="form-control" id="bank" name="bank" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Educational Proof</label>
                                    <input type="file" class="form-control" id="edu" name="edu" >
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
