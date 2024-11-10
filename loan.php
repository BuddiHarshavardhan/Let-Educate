<?php
//require_once './php_action/core.php';
 include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./side.php');?>   
<?php include('./constant/connect.php');?>

<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Loans  Customers</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Loans </li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- <a href="add-customer.php"><button class="btn btn-primary">Add Customer</button></a> -->
                <div class="table-responsive m-t-40" style="overflow-y: scroll; height: 500px;">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SNO</th>
                                <th> Customer_Name</th>
                                <!-- <th>Phone</th> -->
                                <th>Application_Number</th>
                                <th>Policy_Number</th>


                                <th>Email</th>
                                <th>Date_Of_Birth</th>
                                <th>Insurer_Name</th>
                                <th>Plan</th>
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
                                <th>Agent_Name</th>
                                <th>Broking_Name</th>

                                <th>Remarks</th>

                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `customers` WHERE plan=6";
                            $result1 = $connect->query($sql);
                            $i = 1;
                            while ($row = $result1->fetch_array()) {
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="text-center">
                                    <a href="tel:<?= htmlspecialchars($row['phone']) ?>">
                                        <?php echo htmlspecialchars($row['name']); ?>
                                    </a>
                                </td>                                        
                                    <td><?php echo htmlspecialchars($row['application']); ?></td>
                                    <td><?php echo htmlspecialchars($row['policy']); ?></td>

                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <?php
// Convert and format the start_date
$startDate = new DateTime($row['dob']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?>
</td>                                                             <td><?php echo htmlspecialchars($row['insurer']); ?></td>
                                    <td>
                                        <?php
                                        if ($row['plan'] == 1) {
                                            echo "<label class='label label-primary'><h6>Health Insurance</h6></label>";
                                        } elseif ($row['plan'] == 2) {
                                            echo "<label class='label label-primary'><h6>Life Insurance</h6></label>";
                                        } elseif ($row['plan'] == 3) {
                                            echo "<label class='label label-primary'><h6> Motor Insurance </h6></label>";
                                        } elseif ($row['plan'] == 4) {
                                            echo "<label class='label label-success'><h6>Non Motor Life Insurance 4</h6></label>";
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
<td><?php echo htmlspecialchars($formattedStartDate); ?></td><?php
// Convert and format the start_date
$startDate = new DateTime($row['end_date']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td><?php
// Convert and format the start_date
$startDate = new DateTime($row['booking_date']);
$formattedStartDate = $startDate->format('d-m-Y');
?>
<td><?php echo htmlspecialchars($formattedStartDate); ?></td>
                                    <td><?php echo htmlspecialchars($row['premium']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>

                                    <td><?php echo htmlspecialchars($row['freelancer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['company']); ?></td>

                                    <td><?php echo htmlspecialchars($row['remarks']); ?></td>

                                    <!-- <td>
    <a href="edit-customer.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
        <i class="fa fa-edit"></i> 
    </a>
    <a href="manage-customer.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?');">
        <i class="fa fa-trash"></i> 
    </a>
</td> -->

                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php'); ?>
