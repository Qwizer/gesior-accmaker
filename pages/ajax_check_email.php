<?php
if(!defined('INITIALIZED'))
	exit;

$ok = "/[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}/";
$email = trim($_REQUEST['email']);
if(empty($email))
{
	echo '<font color="red">Please enter an e-mail.</font>';
	exit;
}
if(strlen($email) < 255)
{
	if(preg_match($ok, $email))
	{
		if($config['site']['one_email'])
		{
			$email_db = new Account();
			$email_db->findByEMail($email);
			if($email_db->isLoaded())
				echo '<font color="red">Account with this e-mail already exist.</font>';
			else
				echo '<font color="green">Good email.</font>';
		}
		else
			echo '<font color="green">Good email.</font>';
	}
	else
		echo '<font color="red">Wrong e-mail format.</font>';
}
else
	echo '<font color="red">E-mail is too long (max. 255 chars).</font>';
exit;