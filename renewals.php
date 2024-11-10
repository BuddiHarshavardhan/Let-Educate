<?php 
require_once('./constant/connect.php');
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Fetch expiring customers
$expiringCustomersSql = "SELECT * FROM customers WHERE end_date <= DATE_ADD(CURDATE(), INTERVAL 2 MONTH) AND end_date > CURDATE()";
$expiringCustomersResult = $connect->query($expiringCustomersSql);
$expiringCustomersCount = $expiringCustomersResult->num_rows;
?>

<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./constant/layout/sidebar.php');?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Renewals</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Renewals</li>
            </ol>
        </div>
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Expiring Policies</h4>
                        <div class="text-right"> <span class="text-muted">Expiring within 2 months</span>
                            <h2 class="font-light m-b-0"><i class="fa fa-exclamation-triangle text-warning"></i> <?= $expiringCustomersCount ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                    <h4 class="card-title" style="color:green">Expiring Policies within 2 months</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                            <table id="expiringTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th>SNO</th>
                                        <th style="width:40px">Customer_Name</th>
                                        <th>Phone</th>
                                        <th>Application_Number</th>
                                        <th>Policy_Number</th>
                                        <th>Email</th>
                                        <th>Date_Of_Birth</th>
                                        <th>Insurer_Name</th>
                                        <th style="padding:30px">Plan_Name</th>
                                        <th style="padding:30px">Start_date</th>
                                        <th style="padding:30px">End_date</th>
                                        <th>Booking_Date</th>
                                        <th>Premium</th>
                                        <th>Address</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Photo</th>
                                        <th>Bank</th>
                                        <th>Payment Receipt</th>
                                        <th>BI</th>
                                        <th>Proposal</th>
                                        <th>Agent Name</th>
                                        <th>Broking_Name</th>
                                        <th>Remarks</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
    <?php
    $expNo = 1;
    while($row = $expiringCustomersResult->fetch_assoc()) {
    ?>
        <tr>
        <td class="text-center"><?= $expNo++; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['application']); ?></td>
                                    <td><?php echo htmlspecialchars($row['policy']); ?></td>

                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <?php
// Convert and format the start_date
$startDate = new DateTime($row['dob']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td>
                                    <td><?php echo htmlspecialchars($row['insurer']); ?></td>
                                    <td>
                                        <?php
                                        if ($row['plan'] == 1) {
                                            echo "<label class='label label-primary'><h6>Health Insurance</h6></label>";
                                        } elseif ($row['plan'] == 2) {
                                            echo "<label class='label label-primary'><h6>Life Insurance</h6></label>";
                                        } elseif ($row['plan'] == 3) {
                                            echo "<label class='label label-primary'><h6> Motor Insurance </h6></label>";
                                        } elseif ($row['plan'] == 4) {
                                            echo "<label class='label label-success'><h6>Non Motor </h6></label>";
                                        } elseif ($row['plan'] == 5) {
                                            echo "<label class='label label-success'><h6>SIPS</h6></label>";
                                        } elseif ($row['plan'] == 6) {
                                            echo "<label class='label label-info'><h6>Loans</h6></label>";
                                        }
                                        elseif ($row['plan'] == 7) {
                                            echo "<label class='label label-info'><h6>Credit Cards</h6></label>";
                                        }
                                        ?>
                                    </td>
                                    <?php
// Convert and format the start_date
$startDate = new DateTime($row['start_date']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td>
<?php
// Convert and format the start_date
$startDate = new DateTime($row['end_date']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td>
<?php
// Convert and format the start_date
$startDate = new DateTime($row['booking_date']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td>
                                    
                                  
                                    <td><?php echo htmlspecialchars($row['premium']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($row['aadhar']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['pan']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['photo']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['bank']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['payment']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['bi']); ?>" download>Download </a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['proposal']); ?>" download>Download </a></td>

                                    <td><?php echo htmlspecialchars($row['freelancer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['company']); ?></td>

                                    <td><?php echo htmlspecialchars($row['remarks']); ?></td>

                                    <td>

        </tr>
    <?php
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
    <?php include('./constant/layout/footer.php');?>
</div>
