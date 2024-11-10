<?php 
 require_once('./constant/connect.php');

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- <style>
        .left-sidebar {
            background-color: rgba(75, 192, 295, 0.2);
            width: 250px;
            height: 100%;
            position: fixed;
            color:red;
            top: 0;
            left: 0;
            overflow-y: auto; /* Ensure the sidebar is scrollable */
        }
        
        
        .sidebar-nav {
            background-color:rgba(75, 192, 192, 0.2);
            padding: 15px;
            color:green;
        }
        .nav-devider {
            margin-bottom: 10px;
        }
    </style> -->
</head>

        <div class="left-sidebar ">
            
            <div class="scroll-sidebar ">
                
                <nav class="sidebar-nav ">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a href="dash.php" aria-expanded="false"><i class="fa fa-tachometer"></i>Dashboard</a>
                        </li> 
                 
                         <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-industry"></i><span class="hide-menu">Calling Data</span></a>
                            <ul aria-expanded="false" class="collapse">
                           
                                <li><a href="add_call.php">Add New Data</a></li>
                           
                                <li><a href="call.php">Manage Data</a></li>
                                 <li><a href="import_call.php">Import Data</a></li>
                            </ul>
                        </li>
                    <?php }?>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Lead</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="ad_lead.php">Add Lead</a></li>
                                <li><a href="leads.php">Manage Lead</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Lead Status</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="new_lead.php">New </a></li>
                                <li><a href="working_lead.php">Week</a></li>
                                <li><a href="contact_lead.php">Month</a></li>
                                <li><a href="qualified_lead.php">Qualified</a></li>
                                <li><a href="failed_lead.php">Failed</a></li>
                                <li><a href="closed_lead.php">Closed</a></li>
                            </ul>
                        </li>
                        <!-- <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">categories</span></a>
                            <ul aria-expanded="false" class="collapse">
                           
                                <li><a href="add-category.php">Add category</a></li>
                           
                                <li><a href="categories.php">Manage catagories</a></li>
                            </ul>
                        </li> -->
                        
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Customer</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="add_customer.php">Add Customer</a></li>
                                <li><a href="manage_customer.php">Manage Customers</a></li>
                            </ul>
                        </li>
                        <?php }?>

                        <!-- <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-briefcase"></i>
                         <span class="hide-menu">Business</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="health-insurance.php">Health Insurance  </a></li>
                                <li><a href="life-insurance.php">Life Insurance</a></li>
                                <li><a href="motor-insurance.php">Motor Insurance</a></li>
                                <li><a href="non-motor.php">Non Motor General Insurance</a></li>

                                <li><a href="sip.php">SIPS</a></li>
                                <li><a href="loan.php">Loans</a></li>
                                <li><a href="creditcard.php">Credit Cards</a></li> 

                             </ul>
                        </li> -->
                    <!-- <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu">Product</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="add_product.php">Add Product</a></li>
                                <li><a href="products.php">Manage products</a></li>
                            </ul>
                        </li>
                    <?php }?>  -->
                         <!-- <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu">Policies</span></a>
                            <ul aria-expanded="false" class="collapse">
                           
                                <li><a href="add-order.php">Add Policy</a></li>
                           
                                <li><a href="Order.php">Manage Policies</a></li>
                                <li><a href="r.php">rep</a></li>


                            </ul>
                        </li> -->
                          
                      <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?> 
                        <li> <a class="has-arrow" href="manage_agent.php" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Agents</span></a>
                             <ul aria-expanded="false" class="collapse">
                                <li><a href="add_agent.php">Add Agent</a></li>
                                <li><a href="manage_agent.php">Manage Agents</a></li>  
                                 <!-- <li><a href="company_agents.php">Manage Agents</a></li>  -->

                                
                             </ul>
                        </li>
                    <?php }?>
                    <!-- <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-building" aria-hidden="true"></i> 

                         <span class="hide-menu">Companies</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="probuss.php">Probus  </a></li>
                                <li><a href="Turtlemints.php">Turtlemint</a></li>
                                <li><a href="policybazaar.php">Policybazaar </a></li>
                                <li><a href="zopper.php">Zopper</a></li> 


                             </ul>
                        </li>  -->


 
<!--                   

<li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-flag"></i><span class="hide-menu">Reports</span></a>
                            <ul aria-expanded="false" class="collapse"> -->
                            
                                 <!-- <li><a href="report.php">Order Report</a></li> 
                            <li><a href="customer_report.php">Sale Report</a></li>
                                <li><a href="lead_report.php">Lead Report</a></li>
                                <li><a href="agent_report.php">Agent Report</a></li>

                                <li><a href="total_premium.php">Premium Report</a></li>
                                <li><a href="company_reports.php">Company Reports</a></li> 

                                <li><a href="expreport.php">Expired Product Report</a></li>
                             </ul>
                        </li>  -->

                          <!-- <li style="background-color: yellow;"><a href="https://www.youtube.com/watch?v=6E6JPsLOABQ" target="_blank" aria-expanded="false"><i class="fa fa-download"></i><span class="hide-menu"><b>Check Pro Version<b></span></a></li> -->

                              <!-- <li><a href="https://mayurikom.myinstamojo.com/product/3570010/lead-management-software-source-code-project/" target="_blank" aria-expanded="false"><span class="hide-menu"><b>Copyright free Version<b></span></a></li>  -->
                               

                  <?php ?>


    
                    </ul>   
                </nav>
                
            </div>
            
        </div>
        