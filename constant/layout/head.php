<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="This Lead management System Developed by Aeries Soft Tech Solutions">
<meta name="keywords" content="Aeries Soft Tech Solutions">
<meta name="author" content="Aeries">
    
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/uploadImage/Logo/sparkfins.jpg">
     <?php
     
             include('./constant/connect.php');
             // $sql_head_title = "select * from manage_website"; 
             // $result_head_title = $conn->query($sql_head_title);
             // $row_head_title = mysqli_fetch_array($result_head_title);
             ?>
    <title>LET EDUCATE </title>

    <link href="assets/css/lib/chartist/chartist.min.css" rel="stylesheet">
  <link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    
    <link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    
    <link href="assets/css/helper.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
 <link rel="stylesheet" href="assets/css/lib/html5-editor/bootstrap-wysihtml5.css" />
 <link href="assets/css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
     <link href="assets/css/lib/sweetalert/sweetalert.css" rel="stylesheet">
     <link href="assets/css/lib/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<link rel="stylesheet" type="text/css" href="path/to/css/styles.css">

</head>

<body class="fix-header fix-sidebar">
    
  <!--<div id="page"></div>-->
  <!-- <div id="loading"></div> -->
  <?php
// Start the session (if not started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>