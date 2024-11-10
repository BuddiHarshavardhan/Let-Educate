<?php 
require_once('./constant/connect.php');

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student'];
    $student_phone = $_POST['phone'];
    $student_application = $_POST['application'];
    $student_course = $_POST['course'];
    $student_university = $_POST['university'];
    $student_country = $_POST['country'];
    $student_joined_by = $_POST['join'];
    $student_dob = $_POST['dob'];
    $student_visa = $_POST['visa'];
    $student_hostel = $_POST['hostel'];
    $student_tution = $_POST['tution'];
    $student_scholarship = $_POST['scholar'];
    $student_total = $_POST['total'];
    $student_advance = $_POST['advance'];
    $student_balance = $_POST['balance'];
    $student_remarks = $_POST['remarks'];

    // File uploads
    $target_dir = "uploads/";
    $aadhar_path = $target_dir . basename($_FILES['aadhar']['name']);
    $pan_path = $target_dir . basename($_FILES['pan']['name']);
    $photo_path = $target_dir . basename($_FILES['photo']['name']);
    $tenth_path = $target_dir . basename($_FILES['tenth']['name']);
    $inter_path = $target_dir . basename($_FILES['inter']['name']);
    $ug_path = $target_dir . basename($_FILES['ug']['name']);

    move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadhar_path);
    move_uploaded_file($_FILES['pan']['tmp_name'], $pan_path);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    move_uploaded_file($_FILES['tenth']['tmp_name'], $tenth_path);
    move_uploaded_file($_FILES['inter']['tmp_name'], $inter_path);
    move_uploaded_file($_FILES['ug']['tmp_name'], $ug_path);

    // Insert data into the database
    $sql = "INSERT INTO `students` 
            (`student_name`, `phone`, `application`, `dob`, `course`, `university`, `country`, `joined_by`, `remarks`, `visa`, `hostel`, `tution`, `scholar`, `total`, `advance`, `balance`, `aadhar`, `pan`, `photo`, `tenth`, `inter`, `ug`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $connect->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssssssss", 
        $student_name, $student_phone, $student_application, $student_dob, 
        $student_course, $student_university, $student_country, $student_joined_by, 
        $student_remarks, $student_visa, $student_hostel, $student_tution, 
        $student_scholarship, $student_total, $student_advance, $student_balance, 
        $aadhar_path, $pan_path, $photo_path, $tenth_path, $inter_path, $ug_path
    );

    if($stmt->execute()) {
        header('location: manage-customer.php');
        exit();
    } else {
        $errors[] = 'Error adding student. Please try again.';
    }
    $stmt->close();
}
?>


<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

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
                                    <label class="control-label">Student Name</label>
                                    <input type="text" class="form-control" id="student" placeholder="Name" name="student" required >
                                </div>
                                <div class="form-group col-md-4">
    <label class="control-label">Phone</label>
    <input type="tel" class="form-control" id="phone" placeholder="Phone" name="phone" 
           pattern="\d{10}" maxlength="10" title="Please enter a 10-digit phone number" required>
</div>

                                <div class="form-group col-md-4">
                                    <label class="control-label">Application Number</label>
                                    <input type="text" class="form-control" id="application" placeholder="application number" name="application" >
                                </div>
                                <div class="form-group col-md-4">
                    <label class="control-label">Course</label>
                    <select type="text" class="form-control" id="course" name="course" onchange="fetchCourseDetails()">
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * FROM courses";
                        $result = $connect->query($sql);

                        while($row = $result->fetch_array()) {
                            echo "<option value='".$row['name']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                                                <div class="form-group col-md-4">
                                    <label class="control-label">University</label>
                                    <select type="text" class="form-control" id="university"  name="university" >
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * from university";
                                $result = $connect->query($sql);

                                while($row = $result->fetch_array()) {
                                    echo "<option value='".$row[1]."'>".$row[1]."</option>";
                                } // while
                                
                        ?>
                      </select>                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Country</label>
                                    <!-- <input type="text" class="form-control" id="insurer" placeholder="Insurer Name" name="insurer" > -->
                                    <select type="text" class="form-control" id="country"  name="country" >
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * from country";
                                $result = $connect->query($sql);

                                while($row = $result->fetch_array()) {
                                    echo "<option value='".$row[1]."'>".$row[1]."</option>";
                                } // while
                                
                        ?>
                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Joined By</label>
                                    <select type="text" class="form-control" id="join"  name="join" >
                        <option value="">~~SELECT~~</option>
                        <?php 
                        $sql = "SELECT * from staff";
                                $result = $connect->query($sql);

                                while($row = $result->fetch_array()) {
                                    echo "<option value='".$row[2]."'>".$row[2]."</option>";
                                } // while
                                
                        ?>
                      </select>                                   </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Date Of Birth</label>
                                    <input type="date" class="form-control" id="dob" placeholder="Policy Number" name="dob"  >
                                </div>
                              
                                <div class="form-group col-md-4">
                                    <label class="control-label">Visa Fee</label>
                                    <input type="text" class="form-control" id="visa" placeholder="visa" name="visa"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Hostel Fee</label>
                                    <input type="text" class="form-control" id="hostel" placeholder="hostel" name="hostel"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Tuition Fee</label>
                                    <input type="text" class="form-control" id="tution" placeholder="tution" name="tution" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Scholarship</label>
                                    <input type="text" class="form-control" id="scholar" placeholder="scholar" name="scholar" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Total Amount</label>
                                    <input type="text" class="form-control" id="total" placeholder="Total" name="total"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Advance Amount</label>
                                    <input type="text" class="form-control" id="advance" placeholder="advance" name="advance"  >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Balance Amount</label>
                                    <input type="text" class="form-control" id="balance" placeholder="balance" name="balance"  >
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
                                    <label class="control-label">Tenth</label>
                                    <input type="file" class="form-control" id="tenth" name="tenth" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Intermediate</label>
                                    <input type="file" class="form-control" id="inter" name="inter" >
                                </div> <div class="form-group col-md-4">
                                    <label class="control-label">Under Graduate</label>
                                    <input type="file" class="form-control" id="ug" name="ug" >
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
    <script>
function fetchCourseDetails() {
    var course = document.getElementById("course").value;
    if (course) {
        // Perform AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_course_details.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("tution").value = response.tution_fee || '';
                    document.getElementById("scholar").value = response.scholar || '';
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            }
        };
        xhr.send("course=" + encodeURIComponent(course));
    } else {
        document.getElementById("tution").value = '';
        document.getElementById("scholar").value = '';
    }
}
</script>
</div>
