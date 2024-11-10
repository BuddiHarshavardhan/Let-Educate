<?php 
require_once('./constant/connect.php');
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Handle deletion of a customer
if (isset($_GET['delete'])) {
    $customerId = $_GET['delete'];
    $stmt = $connect->prepare("DELETE FROM `students` WHERE id = ?");
    $stmt->bind_param("i", $customerId);

    if ($stmt->execute()) {
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
$sql = "SELECT * FROM `students`";
if ($searchTerm) {
    $sql .= " WHERE student_name LIKE ? OR course LIKE ? OR university LIKE ? OR country LIKE ?";
}
$sql .= " ORDER BY id DESC"; // Order by ID in descending order

// Prepare and execute the query
$stmt = $connect->prepare($sql);
if ($searchTerm) {
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-title">
                <h4 style="color:green">Students List</h4>
                <form method="GET" action="manage-customer.php" class="form-inline">
                    <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
                <a href="export-customers.php" class="btn btn-success pull-right">Export to Excel</a>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>SNO</th>
                                <th>Student Name</th>
                                <th>Phone Number</th>
                                <th>Application Number</th>
                                <th>Date Of Birth</th>
                                <th>Course</th>
                                <th>University</th>
                                <th>Country</th>
                                <th>Joined_by</th>
                                <th>Visa Fee</th>
                                <th>Hostel Fee</th>
                                <th>Tuition</th>
                                <th>Aadhar</th>
                                <th>PAN</th>
                                <th>Photo</th>
                                <th>Tenth</th>
                                <th>Inter</th>
                                <th>UG</th>
                              
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($result->num_rows > 0) {
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$counter++."</td>";
                                    echo "<td>".$row['student_name']."</td>";
                                    echo "<td>".$row['phone']."</td>";
                                    echo "<td>".$row['application']."</td>";
                                    echo "<td>".date('d-m-Y', strtotime($row['dob']))."</td>";
                                    echo "<td>".$row['course']."</td>";
                                    echo "<td>".$row['university']."</td>";
                                    echo "<td>".$row['country']."</td>";
                                    echo "<td>".$row['joined_by']."</td>";
                                    echo "<td>".$row['visa']."</td>";
                                    echo "<td>".$row['hostel']."</td>";
                                    echo "<td>".$row['tution']."</td>";
                                    echo "<td><a href='".$row['aadhar']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['pan']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['photo']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['tenth']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['inter']."' download>Download</a></td>";
                                    echo "<td><a href='".$row['ug']."' download>Download</a></td>";
                                
                                    echo "<td>".$row['remarks']."</td>";
                                    echo "<td>";
                                    echo "<a href='edit-customer.php?id=".$row['id']."' class='btn btn-info btn-sm'><i class='fas fa-edit'></i></a>";
                                    echo " <a href='manage-customer.php?delete=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this customer?\");'><i class='fas fa-trash-alt'></i></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='26'>No customers found</td></tr>";
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
