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
    header('location: manage_agent.php');
    exit();
}

// Add search functionality
$searchTerm = isset($_GET['search']) ? '%' . $connect->real_escape_string(trim($_GET['search'])) . '%' : '%';
$sql = "SELECT * FROM agents WHERE agentCode LIKE ? OR name LIKE ? OR phone LIKE ? OR email LIKE ? OR companyName LIKE ? ORDER BY id DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./side.php');?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Manage Agents</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage Agents</li>
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
        
        <div class="row mb-3">
            <div class="col-md-6">
                <!-- Add New Agent Button -->
                <!-- <a href="add-agent.php" class="btn btn-primary">Add New Agent</a> -->
            </div>
            <div class="col-md-6">
                <form method="GET" action="manage_agent.php" class="form-inline float-right">
                    <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search Agent" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Agents List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>AgentCode</th>
                                        <th>Agent_Name</th>
                                        <th>Alternative_Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Company</th>
                                        <th style="padding:20px">Joining_Date</th>
                                        <th>Date_Of_Birth</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Bank</th>
                                        <th>Photo</th>
                                        <th>Educational_Proof</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($result->num_rows > 0) {
                                        $counter = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$counter++."</td>"; // Displaying SNO
                                            echo "<td>".$row['agentCode']."</td>";
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
                                            
                                            
                                            echo "<td class=\"text-center\">";
                                            echo htmlspecialchars($row['name']);
                                            
                                            // Add WhatsApp icon and link
                                            echo " <a href=\"https://wa.me/" . htmlspecialchars($row['alt_phone']) . "\" style=\"color: #25D366;\">";
                                            echo "<i class=\"fab fa-whatsapp\"></i>";
                                            echo "</a>";
                                            
                                            // Add phone icon and link
                                            echo " <a href=\"tel:" . htmlspecialchars($row['alt_phone']) . "\">";
                                            echo "<i class=\"fas fa-phone\"></i>";
                                            echo "</a>";
                                            
                                            echo "</td>";
                                            
                                            
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$row['address']."</td>";
                                            echo "<td>".$row['companyName']."</td>";
                                            echo "<td>".date('d-m-Y', strtotime($row['doj']))."</td>"; // Format DOB
                                            echo "<td>".date('d-m-Y', strtotime($row['dob']))."</td>"; 
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
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
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>