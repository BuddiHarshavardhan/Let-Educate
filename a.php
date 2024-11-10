
<?php
// Include necessary files
include './constant/layout/head.php';
include './constant/layout/header.php';
include './constant/layout/sidebar.php';
include './constant/connect.php';

// Fetch expiring clients
$expiringClientsSql = "SELECT * FROM orders WHERE order_status = 1 AND end_date <= DATE_ADD(CURDATE(), INTERVAL 2 MONTH) AND end_date > CURDATE()";
$expiringClientsResult = $connect->query($expiringClientsSql);
$countExpiringClients = $expiringClientsResult->num_rows;

// Fetch all orders
$sql = "SELECT * FROM orders WHERE order_status = 1";
$result = $connect->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Insurance System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include custom styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <?php include './constant/layout/sidebar.php'; ?>

    <div class="container-fluid">
        <?php include './constant/layout/header.php'; ?>

        <div class="row">
            <div class="col-md-12">
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

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Expiring Clients Alert</h5>
                                    <p class="card-text">
                                        You have <strong><?= $countExpiringClients ?></strong> clients with policies expiring within the next 2 months.
                                    </p>
                                    <a href="Order.php" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Add other dashboard components here -->
                    </div>
                </div>
            </div>
        </div>

        <?php include './constant/layout/footer.php'; ?>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php include './constant/layout/footer.php'; ?>
