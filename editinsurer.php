<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>   

<?php include('./constant/connect.php');

$sql="SELECT * from insurer where  id='".$_GET['id']."'";
  $result=$connect->query($sql)->fetch_assoc();  
  ?> 


  

 
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Insurer</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Insurer</li>
                    </ol>
                </div>
            </div>
            
            
            <div class="container-fluid">
                
                
                

                <div class="row">
                    <div class="col-lg-8" style="    margin-left: 10%;">
                        <div class="card">
                            <div class="card-title">
                               
                            </div>
                            <div id="add-brand-messages"></div>
                            <div class="card-body">
                                <div class="input-states">
                                    
                                     <form class="form-horizontal" method="POST"  id="submitProductForm" action="php_action/editInsurer.php?id=<?php echo $_GET['id'];?>"enctype="multipart/form-data">

                                    <fieldset>

                                       

                                    <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Insurer Name</label>
                                                <div class="col-sm-9">
                                                  <input type="text" class="form-control" id="insurer_name" value="<?php echo $result['insurer_name']?>"  name="insurer_name" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        
                                     
                                        

                                     


                                        <button type="submit" name="create" id="createCategoriesBtn" class="btn btn-primary btn-flat m-b-30 m-t-30">Update</button>
                                        </fieldset>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                
               


<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php');?>

<script src="custom/js/product.js"></script>
