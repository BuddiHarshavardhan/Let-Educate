<?php //error_reporting(1); ?>
<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./side.php');?>   
<head>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<?php 
$expiringClientsSql = "SELECT * FROM customers WHERE  end_date <= DATE_ADD(CURDATE(), INTERVAL 2 MONTH) AND end_date > CURDATE()";
$expiringClientsResult = $connect->query($expiringClientsSql);
$countExpiringClients = $expiringClientsResult->num_rows;

// Fetch all orders
$sql = "SELECT * FROM orders WHERE order_status = 1";
$result = $connect->query($sql);

$lowStockSql = "SELECT * FROM product";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$lowStockSql1 = "SELECT * FROM brands ";
$lowStockQuery1 = $connect->query($lowStockSql1);
$countLowStock1 = $lowStockQuery1->num_rows;

// $date=date('Y-m-d');
//     $lowStockSql3 = "SELECT * FROM product WHERE  expdate<'".$date."' AND status = 1";
//     //echo "SELECT * FROM product WHERE  expdate<='".$date."' AND status = 1" ;exit;
// $lowStockQuery3 = $connect->query($lowStockSql3);
// $countLowStock3 = $lowStockQuery3->num_rows;


$leadsql = "SELECT * FROM `lead` ";
$leadquery = $connect->query($leadsql);
$countlead = $leadquery->num_rows;

$newleadsql = "SELECT * FROM `lead`where status=1 ";
$leadnewquery = $connect->query($newleadsql);
$countnewlead = $leadnewquery->num_rows;

$workleadsql = "SELECT * FROM `lead` where status=2";
$leadworkquery = $connect->query($workleadsql);
$countworklead = $leadworkquery->num_rows;

$contactleadsql = "SELECT * FROM `lead` where status=3";
$leadcontactquery = $connect->query($contactleadsql);
$countcontactlead = $leadcontactquery->num_rows;



$qualifiedleadsql = "SELECT * FROM `lead` where status=4 ";
$leadqualifiedquery = $connect->query($qualifiedleadsql);
$countqualifiedlead = $leadqualifiedquery->num_rows;

$failedleadsql = "SELECT * FROM `lead` where status=5";
$leadfailedquery = $connect->query($failedleadsql);
$countfailedlead = $leadfailedquery->num_rows;

$closedleadsql = "SELECT * FROM `lead` where status=6";
$leadclosedquery = $connect->query($closedleadsql);
$countclosedlead = $leadclosedquery->num_rows;
//$connect->close();
$agents = "SELECT * FROM `agents`";
$agent = $connect->query($agents);
$countagents= $agent->num_rows;


?>
  
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to fetch customer data and check birthdays
            function fetchCustomerBirthdays() {
                fetch('fetch-birthday.php') // Replace with your PHP script to fetch birthdays
                    .then(response => response.json())
                    .then(data => {
                        const alertsContainer = document.getElementById('alerts');
                        alertsContainer.innerHTML = ''; // Clear existing alerts

                        // Today's date
                        const today = new Date();
                        const todayString = today.toISOString().slice(0, 10); // Get YYYY-MM-DD format

                        // Check each customer's date of birth
                        data.forEach(customer => {
                            if (customer.dob === todayString) {
                                // Format the date to 'DD Month YYYY'
                                const dob = new Date(customer.dob);
                                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                                const formattedDob = dob.toLocaleDateString(undefined, options);

                                // Create an alert element
                                const alert = document.createElement('div');
                                alert.className = 'alert alert-info';
                                alert.innerHTML = `<strong>Alert!</strong> Today is ${customer.name}'s birthday. ${formattedDob}`;
                                alertsContainer.appendChild(alert);
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Fetch birthdays on page load
            fetchCustomerBirthdays();

            // Optionally, refresh every hour or so
            setInterval(fetchCustomerBirthdays, 3600000); // Refresh every hour (in milliseconds)
        });
    </script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
        <div class="page-wrapper" style="background-color: #ffffff;">
              
        <div class="container-fluid ">
            <div class="dashboard-container">
        <div id="alerts"></div>
            
        <!--     <div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <div class="float-right"><h3 style="color:black;"><p style="color:black;"><?php echo date('l') .' '.date('d').'- '.date('m').'- '.date('Y'); ?></p></h3>
                    </div>
                    </div>
                
            </div> -->
            
            
            <div class="container-fluid ">
                
                 <div class="row">
                <!-- <div class="col-md-3 dashboard">
                       <div class="card" style="background: #fff">
                           <div class="media widget-ten align-items-center">
                               <div class="media-left meida media-middle">
                                   <span><i class="ti-agenda"></i></span>
                               </div>
                               <div class="media-body media-text-right">
        <h2 class=""><?php echo $countLowStock; ?></h2>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <p class="m-b-0">Business</p>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="health.php">Health Insurance</a>
                <a class="dropdown-item" href="life.php">Life Insurance</a>
                <a class="dropdown-item" href="motor.php">Motor Insurance</a>
                <a class="dropdown-item" href="non_motor.php">Non Motor General  Insurance</a>
                <a class="dropdown-item" href="sips.php">SIPS</a>
                <a class="dropdown-item" href="loans.php">Loans</a>


            </div>
        </div>
    </div>
                           </div>
                       </div>
                   </div>  -->
                   <!-- <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countLowStock1; ?></h2>
                                     <a href="product.php"><p class="m-b-0">Total Data</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php }?>
                                       <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?> -->
                   <!--      -->
                  <!-- <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Expiring Clients Alert</h5>
                                    <p class="card-text">
                                        You have <strong><?= $countExpiringClients ?></strong> clients with policies expiring within the next 2 months.
                                    </p>
                                    <a href="Order.php" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        Add other dashboard components here -->
                    <!-- </div> --> 
                    <!-- <div class="col-md-3 dashboard">
                      <div class="card" style="background-color: #fff">
                          <div class="media widget-ten align-items-center">
                              <div class="media-left meida media-middle">
                                  <span><i class="ti-alert"></i></span>
                              </div>
                              <div class="media-body media-text-right">
                                  
                          <h2 class="color-white"><?php echo "Renewals"; ?></h2>
                          <p class="card-text">
                                        <strong><?= $countExpiringClients ?></strong> clients with policies expiring within the next 2 months.
                                    </p>
                                    <a href="manage-customer.php" class="btn btn-primary">View Details</a>
                              </div>
                          </div>
                      </div>
                  </div> -->
                                 <?php }?>
                                 <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-receipt"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countlead; ?></h2>
                                     <a href="leads.php"><p class="m-b-0">Total Leads</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-user"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countagents; ?></h2>
                                     <a href="manage_agent.php"><p class="m-b-0">Total Agents</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php }?>


                                        <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-new-window"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                         
                    
                    





                            
                                     <h2 class="color-white"><?php echo $countnewlead; ?></h2>
                                     <a href="new_lead.php"><p class="m-b-0">Total New Leads</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-alert"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                   
                            
                                 <h2 class="color-white"><?php echo $countworklead; ?></h2>
                                     <a href="working_lead.php"><p class="m-b-0"> Call Alert-Week</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-alert"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countcontactlead; ?></h2>
                                     <a href="contact_lead.php"><p class="m-b-0"> Call Alert-Month</p></a>
                                </div>
                            </div>
                        </div> 
                 </div>
                                       <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-bookmark"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countqualifiedlead; ?></h2>
                                     <a href="qualified_lead.php"><p class="m-b-0">Total Qualified Leads</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                   <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#72c727"><path d="m376-400 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>                           </div>


                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countfailedlead; ?></h2>
                                     <a href="failed_lead.php"><p class="m-b-0">Total Failed Leads</p></a>
                                </div>
                            </div>
                        </div>
                    </div> 
                                       <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                 <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-close"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countclosedlead; ?></h2>
                                     <a href="closed_lead.php"><p class="m-b-0">Total Closed Leads</p></a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-user"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                    
                    
                            
                                    <h2 class="color-white"><?php echo $countagents; ?></h2>
                                     <a href="agents.php"><p class="m-b-0">Total Agents</p></a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <?php }?> <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#fff ">
                            <div class="media widget-ten align-items-center">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-agenda"></i>
                                    </span>
                                </div>
                                <div class="media-body media-text-right">
                                                        
                                <div class="dropdown"><br>

            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <p class="m-b-0">Reports</p>
            </a>

            <div class="dropdown-menu">
                
                <a class="dropdown-item" href="customer_report.php">Customers Report</a>
                <a class="dropdown-item" href="lead_report.php">Leads Report</a>
                <a class="dropdown-item" href="agent_report.php">Agents Report</a>



            </div>
        </div>
                    
                            
                                </div>
                            </div>
                        </div>
                    </div> -->
                                       <?php }?>

                                 <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                  
                                 <?php }?>
                                 
                   
                   
                  
     <!-- <div class="col-md-12">
<div class="card">
                            <div class="card-header">
                                <strong class="card-title">New Leads</strong>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                              <th>#</th>
                            <th>Lead Name</th>
                            <th>Phone</th>                           
                            <th>Email </th>
                            <th>City</th>
                            <th>Interested In</th>
                            <th>Source</th>
                          
                                                
                                            </tr>
                                       </thead>
                                       <tbody>
                                        <?php
                                        //include('./constant/connect');

 $sql = "SELECT * FROM `lead`  WHERE lead_status=1 AND status='1'";
 //echo $sql;exit;
$result=$connect->query($sql);
//print_r($result);exit;
$no=1;
foreach ($result as $row) {
     
$no+=1;
    ?>
                                        <tr>
                                           <td class="text-center"><?php echo $no ?></td>
                                                
                                            <td class="text-center"><?php echo $row['lead_name'] ?></td>
                                            <td><?php echo $row['phone'] ?></td>
                                           
                                               <td><?php echo $row['email'] ?></td> 
                                               <td><?php echo $row['city'] ?></td> 
                                    
                                             <td><?php echo $row['interest'] ?></td>
                                              <td><?php echo $row['source'] ?></td>
                                              
                                           
                                             
                                           
                                            
                                        </tr>
                                     
                                    </tbody>
                                   <?php    
}

?>
                               </table>
                                </div>
                            </div>
                            
                    </div>
                </div>
                </div>
        <div class="row">
            <div class="col-md-6">
                <div id="myChart" style="width:100%; max-width:600px; height:500px;">
                    </div>
            </div>
            <div class="col-md-6">
                
            <div id="myChart1" style="width:100%; max-width:600px; height:500px;"></div>
            </div>
        </div>


<?php
//error_reporting(0);
//require_once('../constant/connect.php');
 $qqq = "SELECT * FROM product WHERE  status ='1' ";
$result=$connect->query($qqq);
//print_r($result);exit;
 $a ='';
 $b = '';
foreach ($result as $row) {

  //print_r($row);
    $a.=$row["product_name"].',';
    $b.=$row["active"].',';
   

 }
    $am= explode(",",$a,-1);
     $amm= explode(",",$b,-1);
     //print_r($a);
     //print_r($b);

  $cnt=count($am);

  $datavalue1='';
                    for($i=0;$i<$cnt;$i++){ 
 $datavalue1.="['".$am[$i]."',".$amm[$i]."],";
         }
          //echo 

 $datavalue1; //used this $data variable in js
?>


                
            </div>
        </div>
    </div>

            
            
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
var data = google.visualization.arrayToDataTable([ ['Contry', 'Mhl'],<?php echo $datavalue1;?>]);

var options = {
  title:'World Wide Wine Production',
  is3D:true
};

var chart = new google.visualization.PieChart(document.getElementById('myChart'));
  chart.draw(data, options);

  var chart = new google.visualization.BarChart(document.getElementById('myChart1'));
  chart.draw(data, options);
}
</script> -->
<?php include ('./constant/layout/footer.php');?>
        <script>
        $(function(){
            $(".preloader").fadeOut();
        })
        </script>
        <script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />