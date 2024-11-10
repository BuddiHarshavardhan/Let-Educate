<?php 
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');   
include('./constant/connect.php');

$sql = "SELECT * FROM `insurer`";
$result = $connect->query($sql);
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
            <h1 style="color:green">Insurer List</h1>

                <div class="table-responsive m-t-40" style="overflow-y: scroll; height: 500px;">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">S.No</th>
                                <th>Insurer Name</th>
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
                                <td class="text-center"><?php echo $row['insurer_name']; ?></td>
                               
                                <td>
                                    <a href="editinsurer.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                    <a href="php_action/removeInsurer.php?id=<?php echo $row['id']; ?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
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
