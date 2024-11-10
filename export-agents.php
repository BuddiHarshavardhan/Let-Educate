<?php
require_once('./constant/connect.php');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="agents.xls"');
header('Cache-Control: max-age=0');

// Fetch the data
$sql = "SELECT * FROM agents";
$result = $connect->query($sql);

// Start outputting the Excel file
echo '<table border="1">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>Agent Code</th>
            <th>Agent Name</th>
            <th>Phone</th>
            <th>Alternative Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Working Company</th>
            <th>Date Of Joining</th>
            <th>Date Of Birth</th>
            <th>Aadhar</th>
            <th>PAN</th>
            <th>Bank</th>
            <th>Photo</th>
        </tr>
      </thead>';
echo '<tbody>';

$counter = 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $counter++ . '</td>';
    echo '<td>' . htmlspecialchars($row['agentCode']) . '</td>';
    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
    echo '<td>' . htmlspecialchars($row['alt_phone']) . '</td>';
    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
    echo '<td>' . htmlspecialchars($row['address']) . '</td>';
    echo '<td>' . htmlspecialchars($row['companyName']) . '</td>';
    echo '<td>' . htmlspecialchars($row['doj']) . '</td>';
    echo '<td>' . htmlspecialchars($row['dob']) . '</td>';
    echo '<td><a href="' . htmlspecialchars($row['aadhar']) . '" download>Download Aadhar</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['pan']) . '" download>Download PAN</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['bank']) . '" download>Download Bank</a></td>';
    echo '<td><a href="' . htmlspecialchars($row['photo']) . '" download>Download Photo</a></td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$connect->close();
?>
