<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./constant/layout/sidebar.php');?>
<?php include('./constant/connect.php');
$user = $_SESSION['userId'];
$sql = "SELECT * FROM orders WHERE order_status = 1";
$result = $connect->query($sql);

$expiringPoliciesSql = "SELECT * FROM orders WHERE order_status = 1 AND end_date <= DATE_ADD(CURDATE(), INTERVAL 2 MONTH) AND end_date > CURDATE()";
$expiringPoliciesResult = $connect->query($expiringPoliciesSql);
$expiringPoliciesCount = $expiringPoliciesResult->num_rows;
?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Expiring Policies</h4>
                        <div class="text-right"> <span class="text-muted">Expiring within 2 months</span>
                            <h2 class="font-light m-b-0"><i class="fa fa-exclamation-triangle text-warning"></i> <?= $expiringPoliciesCount ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Clients with Expiring Policies</h4>
                <div class="table-responsive m-t-40">
                    <table id="expiringTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Client Name</th>
                                <th>Policy Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Contact Number</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $expNo = 1;
                            foreach ($expiringPoliciesResult as $row) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $expNo++; ?></td>
                                    <td><?php echo $row['client_name'] ?></td>
                                    <td><?php echo $row['policy'] ?></td>
                                    <td><?php echo $row['order_date'] ?></td>
                                    <td><?php echo $row['end_date'] ?></td>
                                    <td><?php echo $row['client_contact'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['payment_status'] == 1) {
                                            $paymentStatus = "<label class='label label-success'><h4>Full Payment</h4></label>";
                                        } else if ($row['payment_status'] == 2) {
                                            $paymentStatus = "<label class='label label-danger'><h4>Advance Payment</h4></label>";
                                        } else if ($row['payment_status'] == 3) {
                                            $paymentStatus = "<label class='label label-warning'><h4>No Payment</h4></label>";
                                        }
                                        echo $paymentStatus;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <a href="add-order.php"><button class="btn btn-primary">Add Order</button></a>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Client Name</th>
                                <th>Policy Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Contact Number</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($result as $row) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?php echo $row['client_name'] ?></td>
                                    <td><?php echo $row['policy'] ?></td>
                                    <td><?php echo $row['order_date'] ?></td>
                                    <td><?php echo $row['end_date'] ?></td>
                                    <td><?php echo $row['client_contact'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['payment_status'] == 1) {
                                            $paymentStatus = "<label class='label label-success'><h4>Full Payment</h4></label>";
                                        } else if ($row['payment_status'] == 2) {
                                            $paymentStatus = "<label class='label label-danger'><h4>Advance Payment</h4></label>";
                                        } else if ($row['payment_status'] == 3) {
                                            $paymentStatus = "<label class='label label-warning'><h4>No Payment</h4></label>";
                                        }
                                        echo $paymentStatus;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="editorder.php?id=<?php echo $row['order_id'] ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                        <a href="php_action/removeOrder.php?id=<?php echo $row['order_id'] ?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                        <!-- <a href="invoiceprint.php?id=<?php echo $row['order_id'] ?>"><button type="button" class="btn btn-xs btn-success"><i class="fa fa-print"></i></button></a> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./constant/layout/footer.php');?>
