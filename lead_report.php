<?php require_once('./constant/connect.php'); ?>
<?php session_start(); ?>

<?php
if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Mapping of status numbers to status names
$statusNames = [
    1 => 'New',
    2 => 'Working',
    3 => 'Contacted',
    4 => 'Qualified',
    5 => 'Failed',
    6 => 'Closed',
];

// Fetch the number of leads per status for YTD
$year = date("Y");
$sqlYTD = "SELECT status, COUNT(*) as count FROM `lead` WHERE YEAR(date) = ? GROUP BY status";
$stmtYTD = $connect->prepare($sqlYTD);
$stmtYTD->bind_param("i", $year);
$stmtYTD->execute();
$resultYTD = $stmtYTD->get_result();

$ytdData = [];
while($row = $resultYTD->fetch_assoc()) {
    $row['status'] = $statusNames[$row['status']];
    $ytdData[] = $row;
}

// Fetch the number of leads per status for the current month
$month = date("m");
$sqlMonthly = "SELECT status, COUNT(*) as count FROM `lead` WHERE YEAR(date) = ? AND MONTH(date) = ? GROUP BY status";
$stmtMonthly = $connect->prepare($sqlMonthly);
$stmtMonthly->bind_param("ii", $year, $month);
$stmtMonthly->execute();
$resultMonthly = $stmtMonthly->get_result();

$monthlyData = [];
while($row = $resultMonthly->fetch_assoc()) {
    $row['status'] = $statusNames[$row['status']];
    $monthlyData[] = $row;
}

// Fetch the number of leads per status for today
$today = date("Y-m-d");
$sqlDaily = "SELECT status, COUNT(*) as count FROM `lead` WHERE DATE(date) = ? GROUP BY status";
$stmtDaily = $connect->prepare($sqlDaily);
$stmtDaily->bind_param("s", $today);
$stmtDaily->execute();
$resultDaily = $stmtDaily->get_result();

$dailyData = [];
while($row = $resultDaily->fetch_assoc()) {
    $row['status'] = $statusNames[$row['status']];
    $dailyData[] = $row;
}
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Manage Leads</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage Leads</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Alerts for success or error messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Graphs for Reports -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">YTD Leads Per Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="ytdChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">Monthly Leads Per Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">Daily Leads Per Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing lead management table -->
        <!-- Your existing code for managing leads here... -->

    </div>

    <?php include('./constant/layout/footer.php'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the data from PHP
    const ytdData = <?php echo json_encode($ytdData); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const dailyData = <?php echo json_encode($dailyData); ?>;

    // Prepare data for the YTD chart
    const ytdLabels = ytdData.map(item => item.status);
    const ytdCounts = ytdData.map(item => item.count);

    // Prepare data for the Monthly chart
    const monthlyLabels = monthlyData.map(item => item.status);
    const monthlyCounts = monthlyData.map(item => item.count);

    // Prepare data for the Daily chart
    const dailyLabels = dailyData.map(item => item.status);
    const dailyCounts = dailyData.map(item => item.count);

    // Create the YTD chart
    const ytdCtx = document.getElementById('ytdChart').getContext('2d');
    const ytdChart = new Chart(ytdCtx, {
        type: 'bar',
        data: {
            labels: ytdLabels,
            datasets: [{
                label: 'Number of Leads',
                data: ytdCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create the Monthly chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Number of Leads',
                data: monthlyCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create the Daily chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Number of Leads',
                data: dailyCounts,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
