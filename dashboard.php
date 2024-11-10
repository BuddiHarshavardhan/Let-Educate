<?php //error_reporting(1); ?>
<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>

<?php 
// Initialize filters
$selectedProject = isset($_GET['project']) ? $_GET['project'] : '';
$selectedFloor = isset($_GET['floor']) ? $_GET['floor'] : '';

// Fetch projects and floors for dropdown
$projectsResult = $connect->query("SELECT DISTINCT product_name FROM product");
$floorsResult = $selectedProject ? $connect->query("SELECT DISTINCT floor FROM product WHERE product_name = '$selectedProject'") : null;

// Fetch rooms based on filters
$roomsQuery = "SELECT flat, status FROM product WHERE product_name = '$selectedProject'";
if ($selectedFloor) {
    $roomsQuery .= " AND floor = '$selectedFloor'";
}
$roomsResult = $connect->query($roomsQuery);

// Total counts for each status
$totalOngoing = $connect->query("SELECT COUNT(*) as total FROM product WHERE status = 'ongoing'")->fetch_assoc()['total'];
$totalCompleted = $connect->query("SELECT COUNT(*) as total FROM product WHERE status = 'completed'")->fetch_assoc()['total'];
$totalSold = $connect->query("SELECT COUNT(*) as total FROM product WHERE status = 'sold'")->fetch_assoc()['total'];
?>
<style>
    /* Container for the whole card */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Filter Section */
    .filter-container {
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
    }

    .filter-container select {
        background: linear-gradient(135deg, #fbc2eb 0%, #a6c0fe 100%);
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        font-size: 14px;
        color: #333;
        width: 200px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .filter-container select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        outline: none;
    }

    /* Total Counts Section */
    .total-available-rooms {
        margin-bottom: 20px;
        display: flex;
        gap: 20px;
        justify-content: space-between;
    }

    .count-card {
        background-color: #007bff;
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Room Status Display */
    .room-display {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .room-box {
        padding: 15px;
        border-radius: 8px;
        color: white;
        text-align: center;
        width: 100px;
        font-size: 14px;
        font-weight: bold;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .room-box:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .room-box.completed { background: #5bc0de; } /* Light blue for completed */
    .room-box.sold { background: #d9534f; } /* Red for sold */
    .room-box.ongoing { background: #f0ad4e; } /* Orange for ongoing */

    /* Background Image */
    .page-wrapper {
        background-image: url('uploads/edu.jpg'); /* Path to your background image */
        background-size: cover; /* Ensure the image covers the whole area */
        background-repeat: no-repeat; /* Prevent the image from repeating */
        background-position: center; /* Center the background image */
        position: relative;
        /* Add a transparent background color */
        background-color: rgba(255, 255, 255, 0.5); /* White with 50% opacity */
    }

    /* Ensure the main content is transparent */
    .container-fluid {
        background: transparent; /* Keep the main container background transparent */
        position: relative; /* Ensure it stays on top of the background */
    }

    .dropdown-toggle {
        color: #007bff; /* Primary color for the trigger text */
    }
    .dropdown-toggle:hover {
        color: #0056b3; /* Darker shade for hover effect */
        text-decoration: none;
    }
    .dropdown-menu {
        background-color: #f8f9fa; /* Light grey background */
    }
    .dropdown-item {
        color: #343a40; /* Dark grey color for items */
    }
    .dropdown-item:hover {
        background-color: #007bff; /* Blue background on hover */
        color: #ffffff; /* White text on hover */
    }
    .card-custom {
        color: #fff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-custom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
    .card-custom .card-body {
        padding: 20px;
    }
    .card-custom .media-left {
        font-size: 28px;
        color: #fff;
        background-color: #007bff; /* Default background for icons */
        border-radius: 50%;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-custom .media-body h3 {
        color: #fff; /* White text color for counts */
    }
    .card-custom .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 5px;
        padding: 10px 20px;
    }
    .card-custom .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>


<head>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<?php 
// Get today's students
$student = "SELECT * FROM `students` WHERE DATE(`created_at`) = CURDATE()";
$students = $connect->query($student);
$countstudents = $students->num_rows;

// Get today's calls
$leadsql = "SELECT * FROM `calls` WHERE DATE(`created_at`) = CURDATE() and status=1";
$leadquery = $connect->query($leadsql);
$countlead = $leadquery->num_rows;
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="dashboard-container">
            <!-- Your main content goes here -->
        </div>
                
        <div class="row">
            <div class="col-md-3">
                <div class="card card-custom" style="background: linear-gradient(136deg, #FF6F61, #D7263D);">
                    <div class="media widget-ten align-items-center">
                        <div class="media-left">
                            <span class="material-symbols-outlined">Phone</span>
                        </div>
                        <div class="media-body media-text-right">
                            <h3><?php echo $countlead; ?></h3>
                            <a href="brand.php"><h3><?php echo "Calls"; ?></h3></a>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="col-md-3">
                <div class="card card-custom" style="background: linear-gradient(135deg, #FFDD67, #FFAB4C);">
                    <div class="media widget-ten align-items-center">
                        <div class="media-left">
                            <span class="material-symbols-outlined">groups</span>     
                        </div>
                        <div class="media-body media-text-right">
                            <p class="card-text">
                                <h3><?php echo $countstudents; ?></h3>
                                <a href="manage-customer.php"><h3><?php echo "Students"; ?></h3></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('./constant/layout/footer.php'); ?>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
