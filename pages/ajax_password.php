<?php
if(!defined('INITIALIZED'))
	exit;

$pass1 = $_GET["a_Password1"];
$pass2 = $_GET["a_Password2"];

if(empty($pass2) || empty($pass1))
{
	echo '<font color="red">Please enter the password again!</font>';
	exit;
} elseif($pass1 != $pass2) {
	echo 'The two passwords do not match!';
	exit;
}

if (strlen($pass1) < 8 || strlen($pass2) > 29) {
	echo 'The password must have at least 8 and less than 30 letters!';
} elseif (!ctype_alnum($pass1)) {
	echo 'The password contains invalid letters!';
} elseif (!preg_match('/[a-zA-Z]/', $pass1)) {
	echo 'The password must contain at least one letter A-Z or a-z!';
} elseif (!preg_match('/[0-9]/', $pass1)) {
	echo 'The password must contain at least one letter other than A-Z or a-z!';
}

exit;