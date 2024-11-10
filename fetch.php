<?php
require_once('./constant/connect.php');

$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');
$month = isset($_POST['month']) ? intval($_POST['month']) : 0;

$yearWiseData = [];
$monthWiseData = [];
$dayWiseData = [];

if ($month == 0) {
    // Fetch year-wise data
    $yearWiseSql = "SELECT YEAR(booking_date) AS year, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers GROUP BY year";
    $yearWiseResult = $connect->query($yearWiseSql);

    while ($row = $yearWiseResult->fetch_assoc()) {
        $yearWiseData[] = $row;
    }

    // Fetch month-wise data for the selected year
    $monthWiseSql = "SELECT DATE_FORMAT(booking_date, '%Y-%M') AS month, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers WHERE YEAR(booking_date) = $year GROUP BY month";
    $monthWiseResult = $connect->query($monthWiseSql);

    while ($row = $monthWiseResult->fetch_assoc()) {
        $monthWiseData[] = $row;
    }
} else {
    // Fetch day-wise data for the selected month and year
    $dayWiseSql = "SELECT DATE_FORMAT(booking_date, '%Y-%m-%d') AS day, COUNT(*) AS total_sales, SUM(premium) AS total_premium FROM customers WHERE YEAR(booking_date) = $year AND MONTH(booking_date) = $month GROUP BY day";
    $dayWiseResult = $connect->query($dayWiseSql);

    while ($row = $dayWiseResult->fetch_assoc()) {
        $dayWiseData[] = $row;
    }
}

$response = [
    'yearWiseLabels' => array_column($yearWiseData, 'year'),
    'yearWiseSales' => array_column($yearWiseData, 'total_sales'),
    'yearWisePremiums' => array_column($yearWiseData, 'total_premium'),
    'monthWiseLabels' => array_column($monthWiseData, 'month'),
    'monthWiseSales' => array_column($monthWiseData, 'total_sales'),
    'monthWisePremiums' => array_column($monthWiseData, 'total_premium'),
    'dayWiseLabels' => array_column($dayWiseData, 'day'),
    'dayWiseSales' => array_column($dayWiseData, 'total_sales'),
    'dayWisePremiums' => array_column($dayWiseData, 'total_premium'),
];

echo json_encode($response);
?>
