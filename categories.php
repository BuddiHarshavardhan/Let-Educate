<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>
<?php include('./constant/connect.php');

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories ORDER BY categories_id DESC";
$result = $connect->query($sql);

?>

<div class="page-wrapper">
    <!-- <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View categories</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View categories</li>
            </ol>
        </div>
    </div> -->
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- <a href="add-category.php"><button class="btn btn-primary">Add Category</button></a> -->
                
                <div class="table-responsive" style="overflow-y: scroll; height: 800px;">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th style>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $counter++; ?></td>
                                <td><?php echo htmlspecialchars($row['categories_name']); ?></td>
                                <td>
                                    <?php 
                                    if($row['categories_active'] == 1) {
                                        echo "Available";
                                    } else {
                                        echo "Not Available";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="editcategory.php?id=<?php echo $row['categories_id']; ?>">
                                        <button type="button" class="btn btn-xs btn-primary">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </a>
                                    <a href="php_action/removeCategories.php?id=<?php echo $row['categories_id']; ?>" >
                                        <button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Author Name: Mayuri K. = www.mayurik.com -->
<!--  for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php'); ?>
