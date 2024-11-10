<?php
/* Local Database*/

$servername = "localhost";
$username = "aeries_ssm";
$password = "Aeries@123";
$dbname = "aeries_penglead";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?> 