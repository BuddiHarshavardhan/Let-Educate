<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<?php
// Fetch all existing courses to display in the table
$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = $connect->query($sql);
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Add New Courses</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add New Courses</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="input-states">
                            <!-- Form for adding courses -->
                            <form class="form-horizontal" id="submitCourseForm" action="php_action/createcourse.php" method="POST">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Course Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" placeholder="Enter course name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Tuition Fee</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="tution_fee" placeholder="Enter Tuition Fee" name="tution_fee" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Scholarship</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="scholarship" placeholder="Enter Scholarship Amount" name="scholarship" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="createCourseBtn" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                            </form>
                        </div>
                    </div>

                    <!-- Table for displaying courses data -->
                    <div class="card">
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <th>Course Name</th>
                                        <th>Tuition Fee</th>
                                        <th>Scholarship</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="courseTableBody">
                                    <?php
                                    $serialNumber = 1;
                                    foreach ($result as $row) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>{$serialNumber}</td>";
                                        echo "<td>{$row['name']}</td>";
                                        echo "<td>{$row['tution_fee']}</td>";
                                        echo "<td>{$row['scholarship']}</td>";
                                        echo "<td>
                                                <a href='editcourse.php?id={$row['id']}'>
                                                    <button type='button' class='btn btn-xs btn-primary'>
                                                        <i class='fa fa-pencil'></i>
                                                    </button>
                                                </a>
                                                <a href='php_action/removecourse.php?id={$row['id']}' onclick='return confirm(\"Are you sure to delete this record?\")'>
                                                    <button type='button' class='btn btn-xs btn-danger'>
                                                        <i class='fa fa-trash'></i>
                                                    </button>
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
<script>
$(document).ready(function() {
    // Handle form submission via AJAX
    $("#submitCourseForm").on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: 'php_action/createcourse.php', // URL to submit to
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.success) {
                    // Success: Update the table with the new data
                    var newRow = "<tr>" +
                        "<td class='text-center'>" + ($("#courseTableBody tr").length + 1) + "</td>" +
                        "<td>" + response.data.name + "</td>" +
                        "<td>" + response.data.tution_fee + "</td>" +
                        "<td>" + response.data.scholarship + "</td>" +
                        "<td>" +
                        "<a href='editcourse.php?id=" + response.data.id + "'>" +
                        "<button type='button' class='btn btn-xs btn-primary'><i class='fa fa-pencil'></i></button>" +
                        "</a> " +
                        "<a href='php_action/removecourse.php?id=" + response.data.id + "'>" +
                        "<button type='button' class='btn btn-xs btn-danger' onclick='return confirm(\"Are you sure to delete this record?\")'>" +
                        "<i class='fa fa-trash'></i>" +
                        "</button>" +
                        "</a>" +
                        "</td>" +
                        "</tr>";

                    $("#courseTableBody").append(newRow); // Append the new row

                    alert(response.messages); // Show success message
                    $("#submitCourseForm")[0].reset(); // Clear form fields
                } else {
                    alert(response.messages); // Show error message
                }
            },
            error: function() {
                alert("Error in processing the request.");
            }
        });
    });
});
</script>
