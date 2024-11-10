<?php
// Include header, sidebar, and other necessary files
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');
include('./constant/connect.php');

// Fetch all existing staff to display in the table
$sql = "SELECT * FROM staff ORDER BY staff_id DESC";
$result = $connect->query($sql);
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Staff Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Staff</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="color:GREEN">Add New Staff</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="submitStaffForm" action="php_action/createstaff.php" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Staff ID</label>
                                <div class="col-sm-4">
                                    <?php 
                                    // Generate new Staff ID
                                    $sql = "SELECT count(*) AS cnt FROM staff";
                                    $row = $connect->query($sql)->fetch_assoc();
                                    $new_id = 'S' . sprintf('%05d', intval($row['cnt']) + 1); // Prefix "S" with a zero-padded number
                                    ?>
                                    <input type="text" class="form-control" name="staff_id" value="<?php echo $new_id; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" name="phone" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="role" placeholder="Enter Role" name="role" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" id="createStaffBtn" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table for displaying staff data -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="color:GREEN">Staff List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="staffTableBody">
                                    <?php
                                    $serialNumber = 1;
                                    foreach ($result as $row) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>{$serialNumber}</td>";
                                        echo "<td>{$row['staff_id']}</td>";
                                        echo "<td>{$row['name']}</td>";
                                        echo "<td>{$row['phone']}</td>";
                                        echo "<td>{$row['role']}</td>";
                                        echo "<td>
                                                <a href='editstaff.php?id={$row['id']}' class='btn btn-xs btn-primary' title='Edit'>
                                                    <i class='fa fa-pencil'></i>
                                                </a>
                                                <a href='php_action/removestaff.php?id={$row['id']}' class='btn btn-xs btn-danger' title='Delete' onclick='return confirm(\"Are you sure to delete this record?\")'>
                                                    <i class='fa fa-trash'></i>
                                                </a>
                                              </td>";
                                        echo "</tr>";
                                        $serialNumber++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>

<!-- jQuery for handling AJAX form submission -->
<script>
$(document).ready(function() {
    // Handle form submission via AJAX
    $("#submitStaffForm").on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: 'php_action/createstaff.php', // Submit to the PHP action file
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.success === true) {
                    // Update the table with new data
                    var newRow = "<tr>" +
                        "<td class='text-center'>" + ($("#staffTableBody tr").length + 1) + "</td>" +
                        "<td>" + response.data.staff_id + "</td>" +
                        "<td>" + response.data.name + "</td>" +
                        "<td>" + response.data.phone + "</td>" +
                        "<td>" + response.data.role + "</td>" +
                        "<td>" +
                        "<a href='editstaff.php?id=" + response.data.staff_id + "' class='btn btn-xs btn-primary' title='Edit'>" +
                        "<i class='fa fa-pencil'></i></a> " +
                        "<a href='php_action/removestaff.php?id=" + response.data.staff_id + "' class='btn btn-xs btn-danger' title='Delete' onclick='return confirm(\"Are you sure to delete this record?\")'>" +
                        "<i class='fa fa-trash'></i></a>" +
                        "</td>" +
                        "</tr>";

                    $("#staffTableBody").append(newRow); // Append new row to table
                    alert(response.messages); // Show success message
                    $("#name, #phone, #role").val(''); // Clear form fields
                } else {
                    alert(response.messages); // Show error message
                }
            }
        });
    });
});
</script>
