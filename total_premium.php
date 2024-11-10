<?php
require_once('./constant/connect.php');
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Handle deletion of a customer
if(isset($_GET['delete'])) {
    $customerId = $_GET['delete'];
    $stmt = $connect->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customerId);

    if($stmt->execute()) {
        $_SESSION['success'] = 'Customer deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting customer. Please try again.';
    }

    $stmt->close();
    header('location: manage-customer.php');
    exit();
}

// Get current dates
$currentDate = date('Y-m-d');
$currentMonth = date('Y-m');
$currentYear = date('Y');

// Fetch premium data for YTD
$ytdPremiumDataSql = "SELECT freelancer AS agent, 
                        CASE 
                            WHEN plan = 1 THEN 'Health Insurance'
                            WHEN plan = 2 THEN 'Life Insurance'
                            WHEN plan = 3 THEN 'Motor Insurance'
                            WHEN plan = 4 THEN 'Non Motor Life Insurance'
                            WHEN plan = 5 THEN 'SIPS'
                            WHEN plan = 6 THEN 'Loans'
                            WHEN plan = 7 THEN 'Credit'
                            ELSE 'Unknown'
                        END AS plan, 
                        SUM(premium) AS total_premium 
                   FROM customers 
                   WHERE YEAR(start_date) = YEAR(CURDATE())
                   GROUP BY agent, plan";
$ytdPremiumDataResult = $connect->query($ytdPremiumDataSql);

$ytdPremiumData = [];
while($row = $ytdPremiumDataResult->fetch_assoc()) {
    $ytdPremiumData[] = $row;
}

// Fetch premium data for MTD
$mtdPremiumDataSql = "SELECT freelancer AS agent, 
                        CASE 
                            WHEN plan = 1 THEN 'Health Insurance'
                            WHEN plan = 2 THEN 'Life Insurance'
                            WHEN plan = 3 THEN 'Motor Insurance'
                            WHEN plan = 4 THEN 'Non Motor Life Insurance'
                            WHEN plan = 5 THEN 'SIPS'
                            WHEN plan = 6 THEN 'Loans'
                            WHEN plan = 7 THEN 'Credit'
                            ELSE 'Unknown'
                        END AS plan, 
                        SUM(premium) AS total_premium 
                   FROM customers 
                   WHERE DATE_FORMAT(start_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
                   GROUP BY agent, plan";
$mtdPremiumDataResult = $connect->query($mtdPremiumDataSql);

$mtdPremiumData = [];
while($row = $mtdPremiumDataResult->fetch_assoc()) {
    $mtdPremiumData[] = $row;
}

// Fetch premium data for Daily
$dailyPremiumDataSql = "SELECT freelancer AS agent, 
                        CASE 
                            WHEN plan = 1 THEN 'Health Insurance'
                            WHEN plan = 2 THEN 'Life Insurance'
                            WHEN plan = 3 THEN 'Motor Insurance'
                            WHEN plan = 4 THEN 'Non Motor Life Insurance'
                            WHEN plan = 5 THEN 'SIPS'
                            WHEN plan = 6 THEN 'Loans'
                            WHEN plan = 7 THEN 'Credit'
                            ELSE 'Unknown'
                        END AS plan, 
                        SUM(premium) AS total_premium 
                   FROM customers 
                   WHERE DATE(start_date) = CURDATE()
                   GROUP BY agent, plan";
$dailyPremiumDataResult = $connect->query($dailyPremiumDataSql);

$dailyPremiumData = [];
while($row = $dailyPremiumDataResult->fetch_assoc()) {
    $dailyPremiumData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: calc(33% - 20px); /* Adjust width as needed */
            float: left;
            margin: 10px;
        }
    </style>
</head>
<body>
    <?php include('./constant/layout/head.php');?>
    <?php include('./constant/layout/header.php');?>
    <?php include('./constant/layout/sidebar.php');?>

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

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4>Year-to-Date Premiums</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="ytdChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4>Month-to-Date Premiums</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="mtdChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-title">
                            <h4>Daily Premiums</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('./constant/layout/footer.php');?>
    </div>
    <script>
    // Get the data from PHP
    const ytdPremiumData = <?php echo json_encode($ytdPremiumData); ?>;
    const mtdPremiumData = <?php echo json_encode($mtdPremiumData); ?>;
    const dailyPremiumData = <?php echo json_encode($dailyPremiumData); ?>;

    // Helper function to format numbers in thousands (k), lakhs (l), and crores (cr)
    // Optionally remove decimal values
    function formatNumber(value, removeDecimals = false) {
        if (removeDecimals) {
            // Format without decimal values
            if (value >= 10000000) {
                return Math.floor(value / 10000000) + ' Cr'; // Crores
            } else if (value >= 100000) {
                return Math.floor(value / 100000) + ' L'; // Lakhs
            } else if (value >= 1000) {
                return Math.floor(value / 1000) + ' K'; // Thousands
            } else {
                return value;
            }
        } else {
            // Format with decimal values
            if (value >= 10000000) {
                return (value / 10000000).toFixed(2) + ' Cr'; // Crores
            } else if (value >= 100000) {
                return (value / 100000).toFixed(2) + ' L'; // Lakhs
            } else if (value >= 1000) {
                return (value / 1000).toFixed(2) + ' K'; // Thousands
            } else {
                return value;
            }
        }
    }

    function createDatasets(data) {
        const agents = [...new Set(data.map(item => item.agent))];
        const plans = [...new Set(data.map(item => item.plan))];

        return plans.map(plan => {
            return {
                label: plan,
                data: agents.map(agent => {
                    const record = data.find(item => item.agent === agent && item.plan === plan);
                    return record ? record.total_premium : 0;
                }),
                backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`
            };
        });
    }

    // Chart configuration for premiums generated by each agent per plan
    function createChartConfig(data, title, removeDecimals = false) {
        const agents = [...new Set(data.map(item => item.agent))];
        const datasets = createDatasets(data);

        return {
            type: 'bar',
            data: {
                labels: agents,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: title,
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Agents'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Premium Amount'
                        },
                        ticks: {
                            callback: function(value) {
                                return formatNumber(value, removeDecimals); // Format y-axis values based on removeDecimals flag
                            }
                        }
                    }
                }
            }
        };
    }

    // Render the charts
    const ytdChart = new Chart(document.getElementById('ytdChart'), createChartConfig(ytdPremiumData, 'Year-to-Date Premiums'));
    const mtdChart = new Chart(document.getElementById('mtdChart'), createChartConfig(mtdPremiumData, 'Month-to-Date Premiums'));
    const dailyChart = new Chart(document.getElementById('dailyChart'), createChartConfig(dailyPremiumData, 'Daily Premiums', true)); // Remove decimals for daily chart
</script>

</body>
</html>
