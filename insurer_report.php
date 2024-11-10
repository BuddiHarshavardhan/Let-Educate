<?php 
require_once('./constant/connect.php');
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Helper function to format numbers in thousands and lakhs
function formatNumber($number) {
    if ($number >= 100000) {
        return number_format($number / 100000, 2) . ' L';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 2) . ' K';
    } else {
        return number_format($number, 2);
    }
}

// Fetch Yearly Premium Data by Insurer
$sql_yearly = "SELECT YEAR(booking_date) AS year, insurer, SUM(premium) AS total_premium 
               FROM `customers` GROUP BY YEAR(booking_date), insurer";
$result_yearly = $connect->query($sql_yearly);
$yearly_data = [];
while ($row = $result_yearly->fetch_assoc()) {
    $yearly_data[$row['year']][$row['insurer']] = $row['total_premium'];
}

// Fetch Monthly Premium Data by Insurer
$sql_monthly = "SELECT YEAR(booking_date) AS year, MONTH(booking_date) AS month, insurer, SUM(premium) AS total_premium 
                FROM `customers` GROUP BY YEAR(booking_date), MONTH(booking_date), insurer";
$result_monthly = $connect->query($sql_monthly);
$monthly_data = [];
while ($row = $result_monthly->fetch_assoc()) {
    $monthly_data[$row['year']][$row['month']][$row['insurer']] = $row['total_premium'];
}

// Fetch Daily Premium Data by Insurer
$sql_daily = "SELECT DATE(booking_date) AS date, insurer, SUM(premium) AS total_premium 
              FROM `customers` GROUP BY DATE(booking_date), insurer";
$result_daily = $connect->query($sql_daily);
$daily_data = [];
while ($row = $result_daily->fetch_assoc()) {
    $daily_data[$row['date']][$row['insurer']] = $row['total_premium'];
}

// Convert PHP arrays to JSON
$yearly_json = json_encode($yearly_data);
$monthly_json = json_encode($monthly_data);
$daily_json = json_encode($daily_data);

// Get the current date in YYYY-MM-DD format
$current_date = date('Y-m-d');
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<style>
    .chart-container {
        margin-left:100px;
        width: 40%;
        height: 300px;
        margin-bottom: 30px;
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
    h2 {
        margin-top: 20px;
        color: #007bff;
    }
    table {
        margin-left:100px;

        width: 40%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    table, th, td {
        border: 3px solid #ddd;
        text-align: left;
    }
    th, td {
        padding: 8px;
        text-align:center;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid">
        <h2>Premiums by Insurer</h2>
        <div>
            <label for="dataSelect">Select Data View:</label>
            <select id="dataSelect" onchange="showData()">
                <option value="daily">Daily</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <div class="chart-container">
            <canvas id="premiumChart"></canvas>
        </div>

        <div id="dailyTable" style="display: none;">
            <h2>Daily Premium Data Table for Today</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Insurer</th>
                    <th>Total Premium</th>
                </tr>
                <?php if (isset($daily_data[$current_date]) && !empty($daily_data[$current_date])): ?>
                    <?php foreach ($daily_data[$current_date] as $insurer => $premium): ?>
                    <tr>
                        <td><?php echo date('d F Y', strtotime($current_date)); ?></td>
                        <td><?php echo $insurer; ?></td>
                        <td><?php echo number_format($premium); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No data available for today.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div id="monthlyTable" style="display: none;">
            <h2>Monthly Premium Data Table</h2>
            <table>
                <tr>
                    <th>Year-Month</th>
                    <th>Insurer</th>
                    <th>Total Premium</th>
                </tr>
                <?php foreach ($monthly_data as $year => $months): ?>
                    <?php foreach ($months as $month => $insurers): ?>
                        <?php foreach ($insurers as $insurer => $premium): ?>
                        <tr>
                            <td><?php echo str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . $year; ?></td>
                            <td><?php echo $insurer; ?></td>
                            <td><?php echo formatNumber($premium); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>

        <div id="yearlyTable" style="display: none;">
            <h2>Yearly Premium Data Table</h2>
            <table>
                <tr>
                    <th>Year</th>
                    <th>Insurer</th>
                    <th>Total Premium</th>
                </tr>
                <?php foreach ($yearly_data as $year => $insurers): ?>
                    <?php foreach ($insurers as $insurer => $premium): ?>
                    <tr>
                        <td><?php echo $year; ?></td>
                        <td><?php echo $insurer; ?></td>
                        <td><?php echo formatNumber($premium); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// PHP data as JavaScript objects
var yearlyData = <?php echo $yearly_json; ?>;
var monthlyData = <?php echo $monthly_json; ?>;
var dailyData = <?php echo $daily_json; ?>;

// Function to format numbers in thousands ('K') and lakhs ('L')
function formatNumber(num) {
    if (num >= 100000) {
        return (num / 100000).toFixed(2) + ' L';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(2) + ' K';
    } else {
        return num.toFixed(2);
    }
}

// Function to show the appropriate table and graph based on the selection
function showData() {
    var select = document.getElementById("dataSelect").value;
    document.getElementById("dailyTable").style.display = "none";
    document.getElementById("monthlyTable").style.display = "none";
    document.getElementById("yearlyTable").style.display = "none";
    
    if (select === "daily") {
        document.getElementById("dailyTable").style.display = "block";
        updateChart('daily');
    } else if (select === "monthly") {
        document.getElementById("monthlyTable").style.display = "block";
        updateChart('monthly');
    } else if (select === "yearly") {
        document.getElementById("yearlyTable").style.display = "block";
        updateChart('yearly');
    }
}

// Function to update the chart based on the selection
function updateChart(type) {
    var labels = [];
    var data = [];
    var backgroundColors = [];
    var borderColors = [];

    if (type === 'daily') {
        for (var date in dailyData) {
            if (date === '<?php echo $current_date; ?>') { // Only show data for the current date
                for (var insurer in dailyData[date]) {
                    labels.push(insurer);
                    data.push(dailyData[date][insurer]);
                    backgroundColors.push('rgba(75, 192, 192, 0.2)');
                    borderColors.push('rgba(75, 192, 192, 1)');
                }
            }
        }
    } else if (type === 'monthly') {
        for (var year in monthlyData) {
            for (var month in monthlyData[year]) {
                for (var insurer in monthlyData[year][month]) {
                    labels.push(insurer + ' (' + year + '-' + month + ')');
                    data.push(monthlyData[year][month][insurer]);
                    backgroundColors.push('rgba(153, 102, 255, 0.2)');
                    borderColors.push('rgba(153, 102, 255, 1)');
                }
            }
        }
    } else if (type === 'yearly') {
        for (var year in yearlyData) {
            for (var insurer in yearlyData[year]) {
                labels.push(insurer + ' (' + year + ')');
                data.push(yearlyData[year][insurer]);
                backgroundColors.push('rgba(255, 159, 64, 0.2)');
                borderColors.push('rgba(255, 159, 64, 1)');
            }
        }
    }

    // Update chart
    premiumChart.data.labels = labels;
    premiumChart.data.datasets[0].data = data;
    premiumChart.data.datasets[0].backgroundColor = backgroundColors;
    premiumChart.data.datasets[0].borderColor = borderColors;
    premiumChart.update();
}

// Initialize Chart.js chart
var ctx = document.getElementById('premiumChart').getContext('2d');
var premiumChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // Will be updated by updateChart()
        datasets: [{
            label: 'Total Premium',
            data: [], // Will be updated by updateChart()
            backgroundColor: [],
            borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return formatNumber(value);
                    }
                }
            }
        }
    }
});

// Show default data on page load
window.onload = function() {
    document.getElementById("dataSelect").value = "daily";
    showData();
};
</script>

<?php include('./constant/layout/footer.php'); ?>
