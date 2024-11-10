<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?> 

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Reports</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Report</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Report Selection Buttons -->
                        <div class="form-group">
                            <a href="customer_report.php" class="btn btn-info">Sale Report</a>
                            <a href="agent_report.php" class="btn btn-info">Agent Report</a>
                            <a href="total_premium.php" class="btn btn-info">Premium Report</a>
                            <a href="company_reports.php" class="btn btn-info">Company Reports</a>
                            <a href="insurer_report.php" class="btn btn-info">Insurer Reports</a>
                        </div>

                        <!-- Report Content -->
                        <div id="reportContent">
                            <!-- The report content will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('./constant/layout/footer.php'); ?>
</div>
