<?php 
 require_once('./constant/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
</head>

<div class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <br>
                <br>
                <li><a href="dash.php" aria-expanded="false"></i>Home</a></li>
                <li> <a href="dashboard.php" aria-expanded="false"><i class="fa fa-tachometer"></i>Dashboard</a></li>

                <?php if(isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                <li>
                    <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-industry"></i><span class="hide-menu">Calling Data</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="add-brand.php">Add New Data</a></li>
                        <li><a href="brand.php">Manage Data</a></li>
                        <!-- <li><a href="importbrand.php">Import Data</a></li> -->
                    </ul>
                </li>
                <?php } ?>

               


                <li>
                    <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Students</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="add-customer.php">Add Student</a></li>
                        <li><a href="manage-customer.php">Manage Students</a></li>
                    </ul>
                </li>

                <!-- <li><a href="courses.php" aria-expanded="false"></i>Courses</a></li> -->
                <li> <a href="courses.php" aria-expanded="false"><i class="fa fa-tachometer"></i>Courses</a></li>
                <li> <a href="countries.php" aria-expanded="false"><i class="fa fa-flag"></i>Countries</a></li>
                <li> <a href="universities.php" aria-expanded="false"><i class="fa fa-book"></i>Universities</a></li>
                <li> <a href="staff.php" aria-expanded="false"><i class="fa fa-users"></i>Staff</a></li>

                <li> <a href="reports.php" aria-expanded="false"><i class="fa fa-users"></i>Staff</a></li>

              
             


                

            
                

            </ul>
        </nav>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
