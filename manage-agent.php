<?php 
require_once('./constant/connect.php');
session_start();

if(!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Handle deletion of an agent
if(isset($_GET['delete'])) {
    $agentId = $_GET['delete'];
    $stmt = $connect->prepare("DELETE FROM agents WHERE id = ?");
    $stmt->bind_param("i", $agentId);

    if($stmt->execute()) {
        $_SESSION['success'] = 'Agent deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting agent. Please try again.';
    }

    $stmt->close();
    header('location: manage-agent.php');
    exit();
}

// Fetch search term from query parameters
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
// Build SQL query with search functionality
$sql = "SELECT * FROM agents";
if ($searchTerm) {
    $sql .= " WHERE agentCode LIKE ? OR name LIKE ? OR phone LIKE ? OR email LIKE ? OR companyName LIKE ?";
}
$sql .= " ORDER BY id DESC";
// Prepare and execute the query
$stmt = $connect->prepare($sql);
if ($searchTerm) {
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./constant/layout/sidebar.php');?>

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
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4 style="color:green">Agents List</h4>
                        <form method="GET" action="manage-agent.php" class="form-inline">
                            <input type="text" name="search" class="form-control" placeholder="Search for..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn btn-primary ml-2">Search</button>
                        </form>
                        <a href="export-agents.php" class="btn btn-success pull-right">Export to Excel</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Agent_Code</th>
                                        <th>Agent_Name</th>
                                        <th style="padding:60px">Phone</th>
                                        <th style="padding:20px">Alternative_Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Working_Company</th>
                                        <th>Date_Of_Joining</th>
                                        <th>Date_Of_Birth</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Bank</th>
                                        <th>Photo</th>
                                        <th>Educational Proof</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($result->num_rows > 0) {
                                        $counter = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$counter++."</td>";
                                            echo "<td>".$row['agentCode']."</td>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>
        
                                            ".$row['phone']."  
                                            <a href='https://wa.me/".$row['phone']."' style='color: #25D366;'>
                                                <i class='fab fa-whatsapp'></i>
                                            </a>
                                            <a href='tel:".$row['phone']."'>
                                                <i class='fas fa-phone'></i>
                                            </a> 
                                          </td>";                                           
                                          echo "<td>
        
                                          ".$row['alt_phone']."  
                                          <a href='https://wa.me/".$row['alt_phone']."' style='color: #25D366;'>
                                              <i class='fab fa-whatsapp'></i>
                                          </a>
                                          <a href='tel:".$row['alt_phone']."'>
                                              <i class='fas fa-phone'></i>
                                          </a> 
                                        </td>";                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$row['address']."</td>";
                                            echo "<td>".$row['companyName']."</td>";
                                            echo "<td>".date('d-m-Y', strtotime($row['doj']))."</td>"; // Format DOB
                                            echo "<td>".date('d-m-Y', strtotime($row['dob']))."</td>"; // Format DOB

                                          
                                            echo "<td><a href='".$row['aadhar']."' download>Download</a></td>";
                                            echo "<td><a href='".$row['pan']."' download>Download</a></td>";
                                            echo "<td><a href='".$row['bank']."' download>Download</a></td>";
                                            echo "<td><a href='".$row['photo']."' download>Download</a></td>";
                                            echo "<td><a href='".$row['edu']."' download>Download</a></td>";

                                            echo "<td>";
                                            echo "<div class='btn-group'>";
                                            echo "<a href='editagent.php?id=".$row['id']."' class='btn btn-info btn-sm'>
                                                    <i class='fas fa-edit'></i> 
                                                  </a> ";
                                            echo "<a href='manage-agent.php?delete=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this agent?\");'>
                                                    <i class='fas fa-trash-alt'></i> 
                                                  </a>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='15'>No agents found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('./constant/layout/footer.php');?>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
function scrollToTop() {
    document.querySelector('.table-responsive').scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
