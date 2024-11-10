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
?>

<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./constant/layout/sidebar.php');?>

<div class="page-wrapper">
    <!-- <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Turtle Mint Agents</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage Agents</li>
            </ol>
        </div>
    </div> -->

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
            <!-- <a href="add-agent.php" class="btn btn-primary">Add New Agent</a> -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Agents List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-y: scroll; height: 500px;">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Agent Code</th>
                                        <th>Agent Name</th>
                                        <th>Phone</th>
                                        <th>Alternative Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Working Company</th>
                                        <th>Date_Of_Joining</th>
                                        <th>Date_Of_Birth</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Bank</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $companyName = 'probus'; // Specify the company name
                                    $sql = "SELECT * FROM `agents` WHERE companyName = ?";
                                    $stmt = $connect->prepare($sql);
                                    $stmt->bind_param("s", $companyName);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    if($result->num_rows > 0) {
                                        $counter = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$counter++."</td>";
                                            echo "<td>".$row['agentCode']."</td>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td><a href='tel:".$row['phone']."'>".$row['phone']."</a></td>";
                                            echo "<td><a href='tel:".$row['alt_phone']."'>".$row['alt_phone']."</a></td>";
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$row['address']."</td>";
                                            echo "<td>".$row['companyName']."</td>";
                                            echo "<td>".$row['doj']."</td>";
                                            echo "<td>".$row['dob']."</td>";
                                            echo "<td><a href='".$row['aadhar']."' download>Download </a></td>";
                                            echo "<td><a href='".$row['pan']."' download>Download </a></td>";
                                            echo "<td><a href='".$row['bank']."' download>Download </a></td>";
                                            echo "<td><a href='".$row['photo']."' download>Download </a></td>";
                                            echo "<td>";
                                            echo "<div class='btn-group'>";
                                            echo "<a href='editagent.php?id=".$row['id']."' class='btn btn-info btn-sm'>
                                                    <i class='fas fa-edit'></i> 
                                                  </a> ";
                                            echo "<a href='manage-agent.php?delete=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>
                                                    <i class='fas fa-trash-alt'></i> 
                                                  </a>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='15'>No agents found</td></tr>";
                                    }
                                    $stmt->close();
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
