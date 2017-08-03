<?php
if(!defined('INITIALIZED'))
	exit;

$account = strtoupper(trim($_REQUEST['account']));
if(empty($account))
{
	echo '<font color="red">Please enter an account number.</font>';
	exit;
}
if(strlen($account) < 32 )
{
	if (strlen($account) < 6){
		echo '<font color="red">Account name is too lower (min. 6 chars).</font>';
		exit;
	}
	if(!check_account_name($account))
	{
		echo '<font color="red">Invalid account name format. Use only A-Z and numbers 0-9.</font>';
		exit;
	}
	$account_db = new Account();
	$account_db->find($account);
	if($account_db->isLoaded())
		echo '<font color="red">Account with this name already exist.</font>';
	else
		echo '<font color="green">Good account name ( '.htmlspecialchars($account).' ). You can create account.</font>';
}
else
	echo '<font color="red">Account name is too long (max. 32 chars).</font>';
exit;