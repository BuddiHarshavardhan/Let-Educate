<?php
require_once('./constant/connect.php');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="customers.xls"');
header('Cache-Control: max-age=0');

// Fetch the data
$sql = "SELECT * FROM customers";
$result = $connect->query($sql);

// Start outputting the Excel file
echo '<table border="1">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Application Number</th>
            <th>Policy Number</th>
            <th>Email</th>
            <th>Date Of Birth</th>
            <th>Insurer_Name</th>
            <th>Plan</th>
            <th>Product</th>

            <th>Start Date</th>
            <th>End Date</th>
            <th>Booking Date</th>
            <th>Premium</th>
            <th>Address</th>
            <th>Aadhar</th>
            <th>PAN</th>
            <th>Photo</th>
            <th>Bank</th>
            <th>Agent Name</th>
            <th>Broking Name</th>
            <th>Remarks</th>
        </tr>
      </thead>';
echo '<tbody>';

$counter = 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $counter++ . '</td>';
    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
    echo '<td>' . htmlspecialchars($row['application']) . '</td>';
    echo '<td>' . htmlspecialchars($row['policy']) . '</td>';
    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
    echo '<td>' . htmlspecialchars($row['dob']) . '</td>';
    echo '<td>' . htmlspecialchars($row['insurer']) . '</td>';
    echo '<td>' . htmlspecialchars($row['pro']) . '</td>';

    
    echo '<td>';
    switch ($row['plan']) {
        case 1:
            echo "Health Insurance";
            break;
        case 2:
            echo "Life Insurance";
            break;
        case 3:
            echo "Motor Insurance";
            break;
        case 4:
            echo "Non Motor Life Insurance";
            break;
        case 5:
            echo "SIPS";
            break;
        case 6:
            echo "Loans";
            break;
        case 7:
            echo "Credit";
            break;
        default:
            echo "Unknown";
            break;
    }
    echo '</td>';

    echo '<td>' . htmlspecialchars($row['start_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['end_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['booking_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['premium']) . '</td>';
    echo '<td>' . htmlspecialchars($row['address']) . '</td>';
    echo '<td><a href="' . htmlspecialchars($row['aadhar']) . '" download>Download Aadhar</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['pan']) . '" download>Download PAN</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['photo']) . '" download>Download Photo</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['bank']) . '" download>Download Bank</a></td>';
    echo '<td>' . htmlspecialchars($row['freelancer']) . '</td>';
    echo '<td>' . htmlspecialchars($row['company']) . '</td>';
    echo '<td>' . htmlspecialchars($row['remarks']) . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$connect->close();
?>
