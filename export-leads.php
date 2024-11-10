<?php
require_once('./constant/connect.php');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="leads.xls"');
header('Cache-Control: max-age=0');

// Fetch the data
$sql = "SELECT * FROM `lead` WHERE lead_status=1";
$result = $connect->query($sql);

// Start outputting the Excel file
echo '<table border="1">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>Lead Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>City</th>
            <th>Date</th>
            <th>Interested In</th>
            <th>Source</th>
            <th>Requirement</th>
            <th>Status</th>
        </tr>
      </thead>';
echo '<tbody>';

$i = 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $i . '</td>';
    echo '<td>' . $row['lead_name'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['city'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['interest'] . '</td>';
    echo '<td>' . $row['source'] . '</td>';
    echo '<td>' . $row['requirement'] . '</td>';

    $status = '';
    switch ($row['status']) {
        case 1:
            $status = 'New';
            break;
        case 2:
            $status = 'Working';
            break;
        case 3:
            $status = 'Contacted';
            break;
        case 4:
            $status = 'Qualified';
            break;
        case 5:
            $status = 'Failed';
            break;
        case 6:
            $status = 'Closed';
            break;
        default:
            $status = 'Unknown';
    }
    echo '<td>' . $status . '</td>';
    echo '</tr>';
    $i++;
}

echo '</tbody>';
echo '</table>';

$connect->close();
?>
