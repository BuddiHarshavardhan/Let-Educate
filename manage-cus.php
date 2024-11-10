<?php
session_start(); // Start session at the beginning of the script

include('./constant/layout/head.php');
include('./constant/connect.php');
include('./constant/layout/header.php');
include('./sid.php');

// Check if the user is logged in
if (!isset($_SESSION['userId']) || !isset($_SESSION['username'])) {
  header('Location: login.php'); // Redirect to login if not logged in
  exit();
}

// Get the logged-in agent's username
$username = $_SESSION['username'];

// Query to get the customers associated with the logged-in agent
$sql = "SELECT * FROM customers WHERE freelancer = '$username'";
$result = $connect->query($sql);
?>


<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Customers</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View customers</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SNO</th>
                                <th>Customer_Name</th>
                                <th>Application_Number</th>
                                <th>Policy_Number</th>
                                <th>Email</th>
                                <th>Date_Of_Birth</th>
                                <th>Insurer_Name</th>
                                <th>Plan</th>
                                <th>Start_Date</th>
                                <th>End_Date</th>
                                <th>Booking_Date</th>
                                <th>Premium</th>
                                <th>Address</th>
                                <th>Agent_Name</th>
                                <th>Broking_Name</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = $result->fetch_array()) {
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['application']); ?></td>
                                    <td><?php echo htmlspecialchars($row['policy']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dob']); ?></td>
                                    <td><?php echo htmlspecialchars($row['insurer']); ?></td>
                                    <td>
                                        <?php
                                        switch ($row['plan']) {
                                            case 1:
                                                echo "<label class='label label-primary'><h6>Health Insurance</h6></label>";
                                                break;
                                            case 2:
                                                echo "<label class='label label-primary'><h6>Life Insurance</h6></label>";
                                                break;
                                            case 3:
                                                echo "<label class='label label-primary'><h6>Motor Insurance</h6></label>";
                                                break;
                                            case 4:
                                                echo "<label class='label label-success'><h6>Non Motor Life Insurance</h6></label>";
                                                break;
                                            case 5:
                                                echo "<label class='label label-success'><h6>SIPS</h6></label>";
                                                break;
                                            case 6:
                                                echo "<label class='label label-info'><h6>Loans</h6></label>";
                                                break;
                                            case 7:
                                                echo "<label class='label label-info'><h6>Credit Cards</h6></label>";
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['premium']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td><?php echo htmlspecialchars($row['freelancer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['company']); ?></td>
                                    <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>