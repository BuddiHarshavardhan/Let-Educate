<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>   

<?php include('./constant/connect.php');

$sql="SELECT * from product where  product_id='".$_GET['id']."'";
  $result=$connect->query($sql)->fetch_assoc();  
  ?> 


  

 
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Product</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
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
                                    
                                     <form class="form-horizontal" method="POST"  id="submitProductForm" action="php_action/editProduct.php?id=<?php echo $_GET['id'];?>"enctype="multipart/form-data">

                                    <fieldset>
                                        <h1>College Info</h1>

                                       

                                    <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Product Name</label>
                                                <div class="col-sm-9">
                                                  <input type="text" class="form-control" id="editProductName" value="<?php echo $result['product_name']?>"  name="editProductName" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Premium</label>
                                                <div class="col-sm-9">
                                                   <input type="text" class="form-control" id="edit
                                                   Rate" value="<?php echo $result['rate']?>" name="editRate" autocomplete="off">
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Business Type</label>
                                                <div class="col-sm-9">
                                                 <select  id="editBrandName" name="editBrandName"  required class="form-control">
<?php
     $sql = ("SELECT * FROM brands  where brand_status=1 ");
     //echo $sql;exit;
     $results = mysqli_query($connect, $sql);
     //echo "23";exit;
 while ($rows = mysqli_fetch_assoc($results)){
  //echo $row['categories_name'];exit;?>
     <option value="<?php echo $rows['brand_id']; ?>"<?php if($result['brand_id']==$rows['brand_id']){echo "selected";}?>><?php echo $rows['brand_name']; ?></option>";
 <?php   }                    
?></select>
                                            </div>
                                        </div>
                                    </div> -->

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Status</label>
                                                <div class="col-sm-9">
                                                     <select class="form-control" id="editProductStatus" name="editProductStatus">
                        <option value="1" <?php 
                                                        if($result['active']=="1") 
                                                            { 
                                                                echo "selected";
                                                            }
                                                        ?>>Available</option>
                                                        <option value="2" <?php if($result['active']=="2"){ echo "selected";}?>>Not Available</option>
                      </select>

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
