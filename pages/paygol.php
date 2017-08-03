<?php
/*
 
Note:Before starting you have to create an account at http://www.paygol.com/register?affiliatecode=T8Y7-LK0M-NY0R-Y6O3
 
*/
 
// check that the request comes from PayGol server
if(!in_array($_SERVER['REMOTE_ADDR'],
  array('109.70.3.48', '109.70.3.146', '109.70.3.58'))) {
  header("HTTP/1.0 403 Forbidden");
  die("Error: Unknown IP");
}
// CONFIG
$your_service_id =  367658;  // Your service ID from Paygol
 
// get the variables from PayGol system
$message_id = $_GET['message_id'];
$service_id = $_GET['service_id'];
$shortcode  = $_GET['shortcode'];
$keyword    = $_GET['keyword'];
$message    = $_GET['message'];
$sender = $_GET['sender'];
$operator   = $_GET['operator'];
$country    = $_GET['country'];
$custom = $_GET['custom'];
$points = $_GET['points'];
$price  = $_GET['price'];
$currency   = $_GET['currency'];
 
//Replace these parameters by your database details
$dbhost     = "localhost"; //Your database domain
$dbuser     = "root"; //Database username
$dbpassword = "MurrugaFeso2017@sql009"; //Database password
$db         = "RelembraOT"; //Database name
 
if ($your_service_id == $service_id) {
    //Connect to Database
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword);
    mysql_select_db($db);
    $sql = "UPDATE accounts SET coins = coins+'".mysql_real_escape_string($points)."' WHERE name = '".mysql_real_escape_string($custom)."'";
    mysql_query($sql);
 
    mysql_close($conn);
}
 
?>