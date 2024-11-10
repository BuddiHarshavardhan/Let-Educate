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
    header('location: manage-agents-by-company.php');
    exit();
}

// Fetch distinct company names
$companySql = "SELECT DISTINCT companyName FROM agents";
$companyResult = $connect->query($companySql);
$companies = [];
while($row = $companyResult->fetch_assoc()) {
    $companies[] = $row['companyName'];
}
?>

<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<?php include('./constant/layout/sidebar.php');?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Manage Agents by Company</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage Agents by Company</li>
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
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Select Company</h4>
                    </div>
                    <div class="card-body">
                        <form method="get" action="manage-agents-by-company.php">
                            <div class="form-group">
                                <label for="company">Company:</label>
                                <select name="company" id="company" class="form-control">
                                    <option value="">Select a company</option>
                                    <?php foreach($companies as $company): ?>
                                        <option value="<?php echo $company; ?>" <?php echo isset($_GET['company']) && $_GET['company'] == $company ? 'selected' : ''; ?>>
                                            <?php echo $company; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter Agents</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($_GET['company']) && !empty($_GET['company'])): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Agents List for <?php echo $_GET['company']; ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
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
                                            <th>Date Of Joining</th>
                                            <th>Date Of Birth</th>
                                            <th>Aadhar</th>
                                            <th>PAN</th>
                                            <th>Bank</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $company = $_GET['company'];
                                        $sql = "SELECT * FROM agents WHERE companyName = ?";
                                        $stmt = $connect->prepare($sql);
                                        $stmt->bind_param("s", $company);
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
                                                echo "<td><a href='".$row['aadhar']."' download>Download Aadhar</a></td>";
                                                echo "<td><a href='".$row['pan']."' download>Download PAN</a></td>";
                                                echo "<td><a href='".$row['bank']."' download>Download Bank</a></td>";
                                                echo "<td><a href='".$row['photo']."' download>Download Photo</a></td>";
                                                echo "<td>";
                                                echo "<a href='editagent.php?id=".$row['id']."' class='btn btn-info btn-sm'>Edit</a> ";
                                                echo "<a href='manage-agents-by-company.php?delete=".$row['id']."&company=".$_GET['company']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this agent?\");'>Delete</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='15'>No agents found for this company</td></tr>";
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
        <?php endif; ?>
    </div>

    <?php include('./constant/layout/footer.php');?>
</div>
