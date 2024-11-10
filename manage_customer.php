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
    $stmt = $connect->prepare("DELETE FROM `customers` WHERE id = ?");
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

// Fetch search term from query parameters
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Build SQL query with search functionality
$sql = "SELECT * FROM `customers`";
if ($searchTerm) {
    $sql .= " WHERE name LIKE ? OR email LIKE ? or application like ? or policy like ? or freelancer like ?";
}
$sql .= " ORDER BY id DESC"; // Order by ID in descending order


// Prepare and execute the query
$stmt = $connect->prepare($sql);
if ($searchTerm) {
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("sssss", $searchTerm, $searchTerm,$searchTerm,$searchTerm,$searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./side.php'); ?>

<div class="page-wrapper">
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

        <div class="card">
            <div class="card-title">
                <h4 style="color:green">Customers List</h4>
                <form method="GET" action="manage-customer.php" class="form-inline">
                    <input type="text" name="search" class="form-control" placeholder="Search for " value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
                <!-- <a href="export-customers.php" class="btn btn-success pull-right">Export to Excel</a> -->
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>SNO</th>
                                <th style="width:40px;">Customer_Name</th>
                                <!-- <th style="padding:60px">Phone</th> -->
                                <th>Application_Number</th>
                                <th>Policy_Number</th>
                                <th>Email</th>
                                <th>Date_Of_Birth</th>
                                <th>Insurer_Name</th>
                                <th >Plan_Name</th> 
                                <th style="padding:30px">Product_Name</th>
                                <th style="padding:20px">Start_Date</th>
                                <th style="padding:30px">End_Date</th>
                                <th>Booking_Date</th>
                                <th>Premium</th>
                                <th>Address</th>
                                <th>Aadhar</th>
                                <th>PAN</th>
                                <th>Photo</th>
                                <th>Bank</th>
                                <th>PaymentReceipt</th>
                                <th>BI</th>
                                <th>Proposal</th>
                                <th>Agent_Name</th>
                                <th>Broking_Name</th>
                                <th>Remarks</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($result->num_rows > 0) {
                                $counter = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td >".$counter++."</td>";
                                    echo "<td class=\"text-center\">";
                                    echo htmlspecialchars($row['name']);
                                    
                                    // Add WhatsApp icon and link
                                    echo " <a href=\"https://wa.me/" . htmlspecialchars($row['phone']) . "\" style=\"color: #25D366;\">";
                                    echo "<i class=\"fab fa-whatsapp\"></i>";
                                    echo "</a>";
                                    
                                    // Add phone icon and link
                                    echo " <a href=\"tel:" . htmlspecialchars($row['phone']) . "\">";
                                    echo "<i class=\"fas fa-phone\"></i>";
                                    echo "</a>";
                                    
                                    echo "</td>";
                     
                                    echo "<td>".$row['application']."</td>";
                                    echo "<td>".$row['policy']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".date('d-m-Y', strtotime($row['dob']))."</td>"; // Format DOB
                                    echo "<td>".$row['insurer']."</td>";
                                    echo "<td>".$row['pro']."</td>";

                                    echo "<td>";
                                    switch ($row['plan']) {
                                        case 1:
                                            echo "<label class='label label-primary'><h6>Health Insurance</h6></label>";
                                            break;
                                        case 2:
                                            echo "<label class='label label-primary'><h6>Life Insurance</h6></label>";
                                            break;
                                        case 3:
                                            echo "<label class='label label-primary'><h6>Motor Insurance</h6></label>";
                                            break;
                                        case 4:
                                            echo "<label class='label label-success'><h6>Non Motor</h6></label>";
                                            break;
                                        case 5:
                                            echo "<label class='label label-info'><h6>SIPS</h6></label>";
                                            break;
                                        case 6:
                                            echo "<label class='label label-info'><h6>Loans</h6></label>";
                                            break;
                                        case 7:
                                            echo "<label class='label label-info'><h6>Credit</h6></label>";
                                            break;
                                        default:
                                            echo "<label class='label label-default'><h6>Unknown</h6></label>";
                                            break;
                                    }
                                    echo "</td>";
                                    echo "<td>".date('d-m-Y', strtotime($row['start_date']))."</td>"; // Format DOB
                                    echo "<td>".date('d-m-Y', strtotime($row['end_date']))."</td>"; // Format DOB
                                    echo "<td>".date('d-m-Y', strtotime($row['booking_date']))."</td>"; // Format DOB

                                   
                                    echo "<td>".$row['premium']."</td>";
                                    echo "<td>".$row['address']."</td>";
                                    echo "<td><a href='".$row['aadhar']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['pan']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['photo']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['bank']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['payment']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['bi']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['proposal']."' download>Download</a></td>";
                                    echo "<td>".$row['freelancer']."</td>";
                                    echo "<td>".$row['company']."</td>";
                                    echo "<td>".$row['remarks']."</td>";
                                    // echo "<td>";
                                    // echo "<div class='btn-group'>";
                                    // echo "<a href='edit-customer.php?id=".$row['id']."' class='btn btn-info btn-sm'>
                                    //         <i class='fas fa-edit'></i> 
                                    //       </a> ";
                                    // echo "<a href='manage-customer.php?delete=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>
                                    //         <i class='fas fa-trash-alt'></i> 
                                    //       </a>";
                                    // echo "</div>";
                                    // echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='24'>No customers found</td></tr>";  // Adjust colspan to match the number of columns
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>               
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body>
</html>
