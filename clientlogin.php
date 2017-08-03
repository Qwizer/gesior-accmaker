<?php
	//Made by Comedinha and Master Viciado.
	if(!defined('INITIALIZED'))
		exit;

	$request_body = file_get_contents('php://input');
	$result = json_decode($request_body, true);

	$accountName = $result["accountname"];
	$password = sha1($result["password"]);

	$isCast = false;
	$haveError = false;

	if ($accountName != "cast") {
		$accInfo = new Account();
		$accInfo->loadByName(strtoupper($accountName));

		if($accInfo->getName() != strtoupper($accountName) or $accInfo->getPassword() != $password){
			$haveError = true;
			$error = array("errorCode" => 1, "errorMessage" => "Account name or password is not correct.");
		}else{
			$accId = $accInfo->getID();
			$premiumDays = $accInfo->getPremDays();
			$lastLogin = $accInfo->getLastDay();

			$isPremium = false;
			if ($premiumDays > 0) {
				$isPremium = true;
			}

			$dbResource = $SQL->query("SELECT `name`, `sex`, `world_id` FROM `players` WHERE `account_id` = '$accId' ORDER BY `name`;")->fetchAll();

			$accArray = array();
			foreach($dbResource as $dbRet){
				$isMale = false;
				if ($dbRet["sex"] == 1) {
					$isMale = true;
				}
				$dict = array(
					"worldid" => (int)$dbRet["world_id"],
					"name" => $dbRet["name"],
					"ismale" => $isMale,
					"tutorial" => false
				);
				$accArray[] = $dict;
			}

			$session = array(
				"sessionkey" => $accountName . "\n" . $password,
				"lastlogintime" => $lastLogin,
				"ispremium" => $isPremium,
				"premiumuntil" => $premiumDays,
				"status" => "active"   
			);
		}
	} else {
		$isCast = true;
		$dbResource = $SQL->query("SELECT `player_id`, `cast_name`, `world_id` FROM `live_casts`;")->fetchAll();
		if(!$dbResource) {
			$haveError = true;
			$error = array("errorCode" => 3, "errorMessage" => "No casts found.");
		}else{
			$accArray = array();
			foreach($dbResource as $dbRet){
				$dict = array(
					"worldid" => (int)$dbRet["world_id"],
					"name" => $dbRet["cast_name"],
					"ismale" => false,
					"tutorial" => false
				);
				$accArray[] = $dict;
			}

			$session = array(
				"sessionkey" => $accountName . "\n" . $password,
				"lastlogintime" => 0,
				"ispremium" => false,
				"premiumuntil" => 0,
				"status" => "active"   
			);
		}
	}
	$dbResource = $SQL->query("SELECT * FROM `servers`;")->fetchAll();
	if(!$dbResource) {
		$haveError = true;
		$error = array("errorCode" => 2, "errorMessage" => "Worlds not loaded. Please contact CaterOT Support.");
	}else{
		$worldArray = array();
		$worldsArray = array();
		$ServerPort = 0;
		foreach($dbResource as $dbRet){
			if ($isCast) {
				$ServerPort = $dbRet["port"] + 1000;
			} else {
				$ServerPort = $dbRet["port"];
			}
			$dict = array(
				"id" => (int)$dbRet["id"],
				"name" => $dbRet["name"],
				"externaladdress" => $dbRet["ip"],
				"externalport" => (int)$ServerPort,
				"previewstate" => (int)$dbRet["previewer"],
				"location" => $dbRet["location"],
				"externaladdressunprotected" => $dbRet["ip"],
				"externaladdressprotected" => $dbRet["ip"]
			);
			$worldArray[] = $dict;
			$worldsArray[] = array($dict);
		}
	}

	$playerData = array();
	$playerData["worlds"] = $worldArray;
	$playerData["characters"] = $accArray;

	if ($haveError) {
		echo json_encode($error);
	} else {
		$data = array();
		$data["session"] = $session;
		$data["playdata"] = $playerData;
		echo json_encode($data);
	}
	//Sem necessidade de mostar o layout da pagina, entao: die:
	die();
?>