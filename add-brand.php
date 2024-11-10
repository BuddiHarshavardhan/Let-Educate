<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>   
 
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add New Data</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add New Data</li>
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
                                    <form class="form-horizontal" method="POST"  id="submitBrandForm" action="php_action/createBrand.php" enctype="multipart/form-data">

                                   <input type="hidden" name="currnt_date" class="form-control">

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label"><b>Student Name</b></label>
                                                <div class="col-sm-9">
                                                  <input type="text"  class="form-control"id="student" placeholder="Name" name="student" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
    <div class="row">
        <label class="col-sm-3 control-label"><b>Phone Number</b></label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="phone" name="phone"  required>
        </div>
    </div>
</div>
<div class="form-group">
<div class="row">
    <label class="col-sm-3 control-label"><b>Remarks</b></label>
    <div class="col-sm-9">
        <textarea class="form-control" name="remarks" id="remarks" rows="5" style="width: 100%; height: 100px;"></textarea>
    </div>
</div>


                                        </div>


                                        <button type="submit" name="create" id="createBrandBtn" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                
               


<!--  Author Name: Mayuri K. = www.mayurik.com
 for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com  -->
<?php include('./constant/layout/footer.php');?>


