<?php
require_once('./constant/connect.php');
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Fetch premium data grouped by broking name
$premiumSql = "SELECT company AS broking_name, SUM(premium) AS total_premium FROM customers GROUP BY company";
$premiumResult = $connect->query($premiumSql);

$premiumData = [];
while ($row = $premiumResult->fetch_assoc()) {
    $premiumData[] = $row;
}

// Fetch sales reports
$yearWiseSql = "SELECT YEAR(start_date) AS year, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers GROUP BY year";
$yearWiseResult = $connect->query($yearWiseSql);

$monthWiseSql = "SELECT DATE_FORMAT(start_date, '%Y-%M') AS month, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers WHERE YEAR(start_date) = YEAR(CURDATE()) GROUP BY month";
$monthWiseResult = $connect->query($monthWiseSql);

$dayWiseSql = "SELECT DATE_FORMAT(start_date, '%Y-%M-%d') AS day, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers WHERE MONTH(start_date) = MONTH(CURDATE()) AND YEAR(start_date) = YEAR(CURDATE()) GROUP BY day";
$dayWiseResult = $connect->query($dayWiseSql);

// Prepare data for graphs
$yearWiseData = [];
while ($row = $yearWiseResult->fetch_assoc()) {
    $yearWiseData[] = $row;
}

$monthWiseData = [];
while ($row = $monthWiseResult->fetch_assoc()) {
    $monthWiseData[] = $row;
}

$dayWiseData = [];
while ($row = $dayWiseResult->fetch_assoc()) {
    $dayWiseData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('./constant/layout/head.php');?>
    <style>
        .chart-container {
            width: 100%;
            height: 400px;
        }
        .small-chart {
            max-width: 400px;
            height: 300px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include('./constant/layout/header.php');?>
    <?php include('./constant/layout/sidebar.php');?>

    <div class="page-wrapper">
        <!-- Graph for Premium and Broking Name -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4 style="color:green">Premiums by Broking Name</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="premiumChart" class="small-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Reports: Year-wise, Month-wise, Day-wise -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4 style="color:green">Year-wise Sales</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="yearWiseChart" class="small-chart"></canvas>
                        </div>
                    </div>
                </div></div>
                </div> 
                <div class="container-fluid">

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4 style="color:green">Month-wise Sales</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="monthWiseChart" class="small-chart"></canvas>
                        </div>
                    </div>
                </div></div>
                <div class="container-fluid">

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4 style="color:green">Day-wise Sales</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="dayWiseChart" class="small-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include('./constant/layout/footer.php');?>
    </div>

    <script>
        // Premiums by Broking Name
        const premiumCtx = document.getElementById('premiumChart').getContext('2d');
        const premiumData = <?php echo json_encode($premiumData); ?>;
        const premiumLabels = premiumData.map(data => data.broking_name);
        const premiumAmounts = premiumData.map(data => data.total_premium);

        new Chart(premiumCtx, {
            type: 'bar',
            data: {
                labels: premiumLabels,
                datasets: [{
                    label: 'Total Premium',
                    data: premiumAmounts,
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

        // Year-wise Sales
        const yearWiseCtx = document.getElementById('yearWiseChart').getContext('2d');
        const yearWiseData = <?php echo json_encode($yearWiseData); ?>;
        const yearWiseLabels = yearWiseData.map(data => data.year);
        const yearWiseSales = yearWiseData.map(data => data.total_sales);
        const yearWisePremiums = yearWiseData.map(data => data.total_premium);

        new Chart(yearWiseCtx, {
            type: 'bar',
            data: {
                labels: yearWiseLabels,
                datasets: [
                    {
                        label: 'Total Sales',
                        data: yearWiseSales,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Total Premium',
                        data: yearWisePremiums,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left'
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right'
                    }
                }
            }
        });

        // Month-wise Sales
        const monthWiseCtx = document.getElementById('monthWiseChart').getContext('2d');
        const monthWiseData = <?php echo json_encode($monthWiseData); ?>;
        const monthWiseLabels = monthWiseData.map(data => data.month);
        const monthWiseSales = monthWiseData.map(data => data.total_sales);
        const monthWisePremiums = monthWiseData.map(data => data.total_premium);

        new Chart(monthWiseCtx, {
            type: 'bar',
            data: {
                labels: monthWiseLabels,
                datasets: [
                    {
                        label: 'Total Sales',
                        data: monthWiseSales,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Total Premium',
                        data: monthWisePremiums,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left'
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right'
                    }
                }
            }
        });

        // Day-wise Sales
        const dayWiseCtx = document.getElementById('dayWiseChart').getContext('2d');
        const dayWiseData = <?php echo json_encode($dayWiseData); ?>;
        const dayWiseLabels = dayWiseData.map(data => data.day);
        const dayWiseSales = dayWiseData.map(data => data.total_sales);
        const dayWisePremiums = dayWiseData.map(data => data.total_premium);

        new Chart(dayWiseCtx, {
            type: 'bar',
            data: {
                labels: dayWiseLabels,
                datasets: [
                    {
                        label: 'Total Sales',
                        data: dayWiseSales,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Total Premium',
                        data: dayWisePremiums,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left'
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>
</html>
