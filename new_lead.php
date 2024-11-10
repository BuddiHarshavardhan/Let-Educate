
<?php
//require_once './php_action/core.php';
 include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./side.php');?>   
<?php include('./constant/connect.php');?>
<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
       <div class="page-wrapper">
            
            <div class="row page-titles">
                <!-- <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> View New Lead</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View New Lead</li>
                    </ol>
                </div>
            </div>
             -->
            
            <div class="container-fluid">
                
                
                
                
                 <div class="card">
                            <div class="card-body">
                              
                            <!-- <a href="ad_lead.php"><button class="btn btn-primary">Add Lead</button></a> -->
                            <h3 class="text-primary"> View New Lead</h3> </div>

                                <div class="table-responsive m-t-40" style="overflow-y: scroll; height: 500px;">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                             
                            <th>#</th>
                            <th>Lead Name</th>
                            <th>Email </th>
                            <th>City</th>
                            <th>Interested In</th>
                            <th>Source</th>
                            
                            <th>Status</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                        <?php
                                        
    
   $sql = "SELECT * FROM `lead` where  status=1";
  $result1 = $connect->query($sql);
  $i=1;
   while($row = $result1->fetch_array()) {
                                    ?>    
                                        <tr>
                                                
                                            <td class="text-center"><?php echo $i ?></td>
                                                
                                            <td class="text-center">
                                    <a href="tel:<?= htmlspecialchars($row['phone']) ?>">
                                        <?php echo htmlspecialchars($row['lead_name']); ?>
                                    </a>
                                </td>                                            
                                           
                                               <td><?php echo $row['email'] ?></td> 
                                               <td><?php echo $row['city'] ?></td> 
                                    
                                             <td><?php echo $row['interest'] ?></td>
                                              <td><?php echo $row['source'] ?></td>
                                              
                                           
                                             <td><?php  if($row['status']==1)
                                            {
                                                 
                                                 $status = "<label class='label label-primary' ><h4>New</h4></label>";
                                                 echo $status;
                                            }
                                            else if($row['status'] == 2){
                                                $status = "<label class='label label-primary'><h4> Week</h4></label>";
                                                echo $status;
                                            }else if($row['status'] == 3){
                                                $status = "<label class='label label-primary'><h4> Month</h4></label>";
                                                echo $status;
                                            }else if($row['status'] == 4){
                                                $status = "<label class='label label-success'><h4> Qualified</h4></label>";
                                                echo $status;
                                            }else if($row['status'] == 5){
                                                $status = "<label class='label label-danger'><h4> Failed</h4></label>";
                                                echo $status;
                                            }
                                            else if($row['status'] == 6){
                                                $status = "<label class='label label-danger'><h4> Closed</h4></label>";
                                                echo $status;
                                            }
                                        ?></td>
                                           
                                            <!-- <td>
            
                                              <a href="edit_lead.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i></button></a> 
                                              

             
                                                <a href="php_action/remove_Lead.php?id=<?php echo $row['id']?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                           
                                                
                                                </td> -->
                                        </tr>
                                      <?php $i++;}  ?>
                                    </tbody>
                        
                               </table>
                                </div>
                            </div>
                        </div>
</div></div>
<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php');?>


