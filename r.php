<?php require_once('./constant/connect.php'); ?>
<?php session_start(); ?>

<?php
if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Mapping of plan numbers to plan names
$planNames = [
    1 => 'Health',
    2 => 'Life',
    3 => 'Motor',
    4 => 'Non-Motor',
    5 => 'SIPS',
    6 => 'Loans',
];

// Fetch the number of customers per plan for YTD
$year = date("Y");
$sqlYTD = "SELECT plan, COUNT(*) as count FROM customers WHERE YEAR(booking_date) = ? GROUP BY plan";
$stmtYTD = $connect->prepare($sqlYTD);
$stmtYTD->bind_param("i", $year);
$stmtYTD->execute();
$resultYTD = $stmtYTD->get_result();

$ytdData = [];
while($row = $resultYTD->fetch_assoc()) {
    $row['plan'] = $planNames[$row['plan']];
    $ytdData[] = $row;
}

// Fetch the number of customers per plan for the current month
$month = date("m");
$sqlMonthly = "SELECT plan, COUNT(*) as count FROM customers WHERE YEAR(booking_date) = ? AND MONTH(booking_date) = ? GROUP BY plan";
$stmtMonthly = $connect->prepare($sqlMonthly);
$stmtMonthly->bind_param("ii", $year, $month);
$stmtMonthly->execute();
$resultMonthly = $stmtMonthly->get_result();

$monthlyData = [];
while($row = $resultMonthly->fetch_assoc()) {
    $row['plan'] = $planNames[$row['plan']];
    $monthlyData[] = $row;
}

// Fetch the number of customers per plan for today
$today = date("Y-m-d");
$sqlDaily = "SELECT plan, COUNT(*) as count FROM customers WHERE DATE(booking_date) = ? GROUP BY plan";
$stmtDaily = $connect->prepare($sqlDaily);
$stmtDaily->bind_param("s", $today);
$stmtDaily->execute();
$resultDaily = $stmtDaily->get_result();

$dailyData = [];
while($row = $resultDaily->fetch_assoc()) {
    $row['plan'] = $planNames[$row['plan']];
    $dailyData[] = $row;
}
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Manage Customers</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage Customers</li>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">YTD Customers Per Plan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="ytdBarChart"></canvas>
                        <canvas id="ytdPieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">Monthly Customers Per Plan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyBarChart"></canvas>
                        <canvas id="monthlyPieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">Daily Customers Per Plan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyBarChart"></canvas>
                        <canvas id="dailyPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing customer management table -->
        <!-- Your existing code for managing customers here... -->

    </div>

    <?php include('./constant/layout/footer.php'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    // Get the data from PHP
    const ytdData = <?php echo json_encode($ytdData); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const dailyData = <?php echo json_encode($dailyData); ?>;

    // Prepare data for the YTD chart
    const ytdLabels = ytdData.map(item => item.plan);
    const ytdCounts = ytdData.map(item => item.count);

    // Prepare data for the Monthly chart
    const monthlyLabels = monthlyData.map(item => item.plan);
    const monthlyCounts = monthlyData.map(item => item.count);

    // Prepare data for the Daily chart
    const dailyLabels = dailyData.map(item => item.plan);
    const dailyCounts = dailyData.map(item => item.count);

    // Generate random colors for each segment
    const backgroundColors = ytdLabels.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`);
    const borderColors = ytdLabels.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`);

    // Create the YTD Bar chart
    const ytdBarCtx = document.getElementById('ytdBarChart').getContext('2d');
    const ytdBarChart = new Chart(ytdBarCtx, {
        type: 'bar',
        data: {
            labels: ytdLabels,
            datasets: [{
                label: 'Number of Customers',
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

    // Create the YTD Pie chart
    const ytdPieCtx = document.getElementById('ytdPieChart').getContext('2d');
    const ytdPieChart = new Chart(ytdPieCtx, {
        type: 'pie',
        data: {
            labels: ytdLabels,
            datasets: [{
                label: 'Number of Customers',
                data: ytdCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#fff',
                }
            }
        }
    });

    // Create the Monthly Bar chart
    const monthlyBarCtx = document.getElementById('monthlyBarChart').getContext('2d');
    const monthlyBarChart = new Chart(monthlyBarCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Number of Customers',
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

    // Create the Monthly Pie chart
    const monthlyPieCtx = document.getElementById('monthlyPieChart').getContext('2d');
    const monthlyPieChart = new Chart(monthlyPieCtx, {
        type: 'pie',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Number of Customers',
                data: monthlyCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#fff',
                }
            }
        }
    });

    // Create the Daily Bar chart
    const dailyBarCtx = document.getElementById('dailyBarChart').getContext('2d');
    const dailyBarChart = new Chart(dailyBarCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Number of Customers',
                data: dailyCounts,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
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

    // Create the Daily Pie chart
    const dailyPieCtx = document.getElementById('dailyPieChart').getContext('2d');
    const dailyPieChart = new Chart(dailyPieCtx, {
        type: 'pie',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Number of Customers',
                data: dailyCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#fff',
                }
            }
        }
    });
</script>
