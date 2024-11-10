<?php 
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');   
include('./constant/connect.php');

$sql = "SELECT * FROM product";
$result = $connect->query($sql);
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40" style="overflow-y: scroll; height: 500px;">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            foreach ($result as $row) {
                                $sql2 = "SELECT * FROM categories WHERE categories_id='".$row['categories_id']."'";
                                $result2 = $connect->query($sql2);
                                $row2 = $result2->fetch_assoc();
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $counter++; ?></td>
                                <td class="text-center"><?php echo $row['product_name']; ?></td>
                                <td>
                                    <?php 
                                    if ($row['active'] == 1) {
                                        echo "<label class='label label-success'><h4>Available</h4></label>";
                                    } else {
                                        echo "<label class='label label-danger'><h4>Not Available</h4></label>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="editproduct.php?id=<?php echo $row['product_id']; ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                    <a href="php_action/removeProduct.php?id=<?php echo $row['product_id']; ?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php'); ?>
