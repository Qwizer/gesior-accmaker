<?php
if ($_REQUEST['debug']) {
ini_set("display_errors", true);
error_reporting(E_ALL);
}

// GIVE HERE YOUR DB INFO

$mysql_host = 'localhost'; //Leave at localhost
$mysql_user = 'root'; //DB User
$mysql_pass = 'MurrugaFeso2017@sql009'; //DB Pass
$mysql_db = 'RelembraOT'; //DB Name

$file = 'paypal.log'; //Paypal Log Name will be placed in the same location as your ipn.php file
$payer_email = $_REQUEST['payer_email'];
$ip = $_SERVER['REMOTE_ADDR'];
if($ip != "66.211.170.66" && $ip != "216.113.188.202" && $ip != "216.113.188.203" && $ip != "216.113.188.202" && $ip != "173.0.81.1" && $ip != "notify.paypal.com" && $ip != "73.0.81.33" && $ip != "173.0.81.33" ) {
    print "Acess restricted";
$hak = fopen("scammer.log", "a");
fwrite($hak, "$ip \r\n");
fclose($hak);
die(0);
}
$time = date("F j, Y, g:i a");
// REMEBER THERE ARE DOTS AND TWO ZEROS
$paylist = array("10.00" => 10, "20.00" => 20, "40.00" => 40, "80.00" => 100, "160.00" => 250);

// connect db

$db = mysql_connect($mysql_host, $mysql_user, $mysql_pass);

$custom = stripslashes(ucwords(strtolower(trim($_REQUEST['custom']))));
$receiver_email = $_REQUEST['receiver_email'];
$payment_status = $_REQUEST['payment_status'];

// currency

$currency =  $_REQUEST['mc_currency'];

$mc_gross = $_REQUEST['mc_gross'];
mysql_select_db($mysql_db, $db);
if ($_REQUEST['debug']){
print $payment_status . '\n';
print (isset($paylist[$mc_gross])) ? 1 : 0 . '\n';
print (isset($paylist[$mc_gross])) ? 1 : 0 . '\n';
print $receiver_email . '\n';
print $custom . '\n';
}
// GIVE HERE YOUR MAIL
if ($payment_status == "Completed" && $receiver_email == "contato.relembraglobal@gmail.com" && $currency == "BRL" && isset($paylist[$mc_gross]))
{

    $query = "SELECT coins FROM accounts WHERE accounts.id = '$custom'";

    $result = mysql_query($query);

    $prem = mysql_fetch_array($result);
    $somecode = "'$time' '$custom' '$payer_email' '$mc_gross' '$ip'\r\n";

    // figure out how much to give
    $give = $paylist[$mc_gross];
    $points = $prem['coins'] + $give;
    // $points = mysql_query($prem)
    $qry2 = "UPDATE accounts SET coins = '$points' WHERE accounts.id = '$custom'";
    // Log Paypal Transaction
    $hak = fopen($file, "a");
    fwrite($hak, $somecode);
    fclose($hak);
    $result2 = mysql_query($qry2);

}

else
{
echo("Error.");
}
?>