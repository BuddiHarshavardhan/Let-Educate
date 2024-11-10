<?php
require_once('./constant/connect.php');
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Mapping of plan numbers to plan names
$planNames = [
    1 => 'Health Insurance',
    2 => 'Life Insurance',
    3 => 'Motor Insurance',
    4 => 'Non-Motor',
    5 => 'SIPS',
    6 => 'Loans',
    7 => 'Credit Cards',
];

// Fetch data based on the report type
function fetchReportData($connect, $sql, $params) {
    $stmt = $connect->prepare($sql);
    $stmt->bind_param(...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['plan'] = $GLOBALS['planNames'][$row['plan']];
        $data[] = $row;
    }
    return $data;
}

// YTD data
$year = date("Y");
$sqlYTD = "SELECT plan, COUNT(*) as count FROM customers WHERE YEAR(booking_date) = ? GROUP BY plan";
$ytdData = fetchReportData($connect, $sqlYTD, [$year]);

// Monthly data
$month = date("m");
$sqlMonthly = "SELECT plan, COUNT(*) as count FROM customers WHERE YEAR(booking_date) = ? AND MONTH(booking_date) = ? GROUP BY plan";
$monthlyData = fetchReportData($connect, $sqlMonthly, [$year, $month]);

// Daily data
$today = date("Y-m-d");
$sqlDaily = "SELECT plan, COUNT(*) as count FROM customers WHERE DATE(booking_date) = ? GROUP BY plan";
$dailyData = fetchReportData($connect, $sqlDaily, [$today]);

// Return JSON data
header('Content-Type: application/json');
echo json_encode([
    'ytd' => $ytdData,
    'monthly' => $monthlyData,
    'daily' => $dailyData,
]);
?>
