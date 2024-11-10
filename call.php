<?php 
session_start(); // Start the session

include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');   
include('./constant/connect.php');

// Fetch user_id from the session
$user_id = $_SESSION['user_id'];

// Determine the filter option (0 for not called, 1 for called, or all)
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Modify the SQL query based on the filter and user_id
if ($filter === 'not_called') {
    $sql = "SELECT * FROM `calls` WHERE `status` = 0 AND `user_id` = ? ORDER BY `id` DESC";
} elseif ($filter === 'called') {
    $sql = "SELECT * FROM `calls` WHERE `status` = 1 AND `user_id` = ? ORDER BY `id` DESC";
} else {
    $sql = "SELECT * FROM `calls` WHERE `user_id` = ? ORDER BY `id` DESC";
}

// Prepare the statement to prevent SQL injection
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id); // Assuming user_id is an integer
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Data</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Data</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Filter Buttons -->
                <div class="mb-3">
                    <a href="brand.php?filter=all" class="btn btn-primary">All</a>
                    <a href="brand.php?filter=not_called" class="btn btn-warning">Not Called</a>
                    <a href="brand.php?filter=called" class="btn btn-success">Called</a>
                </div>
                <a href="javascript:void(0);" style="float: right;" onclick="toggleForm()">
                    <button style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                        Import
                    </button>
                </a>
                <a href="exportcall.php" class="btn btn-success">Export</a>

                <div id="importFormContainer" style="display: none;">
                    <form class="form-horizontal" id="submitImportForm" action="php_action/createBrandImport.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-3 control-label">Import Data File</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="brandfile" placeholder="Import Data" name="brandfile" class="file-loading" style="width:auto;" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-2">
                                    <a href="assets/import/sample data.xlsx" download>Sample file</a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" id="importBrandBtn" value="showAlert" onclick="showAlert();">Submit</button>
                    </form>
                </div>

                <script>
                    function toggleForm() {
                        var formContainer = document.getElementById("importFormContainer");
                        if (formContainer.style.display === "none") {
                            formContainer.style.display = "block";
                        } else {
                            formContainer.style.display = "none";
                        }
                    }
                </script>

                <!-- Form for Bulk Deletion -->
                <form id="bulkDeleteForm" method="POST" action="php_action/bulkDelete.php">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" id="selectAll"></th>
                                    <th class="text-center">#</th>
                                    <th>Student Name</th>
                                    <th>Phone Number</th>
                                    <th>Call Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $serialNumber = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>">
                                        </td>
                                        <td class="text-center"><?php echo $serialNumber++; ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td>
                                            <a href="tel:<?= htmlspecialchars($row['phone']) ?>">
                                                <?= htmlspecialchars($row['phone']) ?>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=<?= htmlspecialchars($row['phone']) ?>" target="_blank" style="margin-left: 10px; color: green;">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <button class="btn btn-success">Called</button>
                                            <?php else: ?>
                                                <button class="btn btn-danger">Not Called</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="editcall.php?id=<?php echo $row['id']; ?>">
                                                <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button>
                                            </a>
                                            <a href="php_action/removeCall.php?id=<?php echo $row['id']; ?>">
                                                <button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button>
                                            </a>
                                            <?php if ($row['status'] == 0) { ?>
                                                <a href="php_action/updateCallStatus.php?id=<?php echo $row['id']; ?>">
                                                    <button type="button" class="btn btn-xs btn-success">Mark as Called</button>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Delete Button -->
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete selected records?')">Delete Selected</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<script>
// Select or Deselect All Checkboxes
document.getElementById('selectAll').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
});
</script>
