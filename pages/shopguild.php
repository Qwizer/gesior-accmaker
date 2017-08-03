<?PHP
if($config['site']['shop_system'] == true) {
        if($logged)
                $user_guild_points = $account_logged->getCustomField('guild_points');
        else
                $user_guild_points = 'Login first';
 
function getItemByID($id)
{
  $id = (int) $id;
  $SQL = $GLOBALS['SQL'];
  $data = $SQL->query('SELECT * FROM '.$SQL->tableName('z_shopguild_offer').' WHERE '.$SQL->fieldName('id').' = '.$SQL->quote($id).';')->fetch();
  if ($data['offer_type'] == 'pacc')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['days'] = $data['count1'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'item')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['item_id'] = $data['itemid1'];
    $offer['item_count'] = $data['count1'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'vipdays')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['days'] = $data['count1'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'megaitems')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['item_id'] = $data['itemid1'];
    $offer['item_count'] = $data['count1'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'container')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['container_id'] = $data['itemid2'];
    $offer['container_count'] = $data['count2'];
    $offer['item_id'] = $data['itemid1'];
    $offer['item_count'] = $data['count1'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'unban')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'redskull')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  elseif ($data['offer_type'] == 'itemlogout')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['pid'] = $data['pid'];
    $offer['count1'] = $data['count1'];
    $offer['item_id'] = $data['itemid1'];
    $offer['free_cap'] = $data['free_cap'];
  }
  elseif ($data['offer_type'] == 'changename')
  {
    $offer['id'] = $data['id'];
    $offer['type'] = $data['offer_type'];
    $offer['points'] = $data['points'];
    $offer['description'] = $data['offer_description'];
    $offer['name'] = $data['offer_name'];
  }
  return $offer;
}
 
function getOfferArray()
{
  $offer_list = $GLOBALS['SQL']->query('SELECT * FROM '.$GLOBALS['SQL']->tableName('z_shopguild_offer').';');
  $i_pacc = 0;
  $i_item = 0;
  $i_vipdays = 0;
  $i_megaitems = 0;
  $i_container = 0;
  $i_unban = 0;
  $i_redskull = 0;
  $i_itemlogout = 0;
  $i_changename = 0;
  while($data = $offer_list->fetch()) {
    if ($data['offer_type'] == 'pacc')
    {
      $offer_array['pacc'][$i_pacc]['id'] = $data['id'];
      $offer_array['pacc'][$i_pacc]['days'] = $data['count1'];
      $offer_array['pacc'][$i_pacc]['points'] = $data['points'];
      $offer_array['pacc'][$i_pacc]['description'] = $data['offer_description'];
      $offer_array['pacc'][$i_pacc]['name'] = $data['offer_name'];
      $i_pacc++;
    }
    elseif ($data['offer_type'] == 'item')
    {
      $offer_array['item'][$i_item]['id'] = $data['id'];
      $offer_array['item'][$i_item]['item_id'] = $data['itemid1'];
      $offer_array['item'][$i_item]['item_count'] = $data['count1'];
      $offer_array['item'][$i_item]['points'] = $data['points'];
      $offer_array['item'][$i_item]['description'] = $data['offer_description'];
      $offer_array['item'][$i_item]['name'] = $data['offer_name'];
      $i_item++;
    }
    elseif ($data['offer_type'] == 'vipdays')
    {
      $offer_array['vipdays'][$i_vipdays]['id'] = $data['id'];
      $offer_array['vipdays'][$i_vipdays]['days'] = $data['count1'];
      $offer_array['vipdays'][$i_vipdays]['points'] = $data['points'];
      $offer_array['vipdays'][$i_vipdays]['description'] = $data['offer_description'];
      $offer_array['vipdays'][$i_vipdays]['name'] = $data['offer_name'];
      $i_vipdays++;
    }
    elseif ($data['offer_type'] == 'megaitems')
    {
      $offer_array['megaitems'][$i_megaitems]['id'] = $data['id'];
      $offer_array['megaitems'][$i_megaitems]['item_id'] = $data['itemid1'];
      $offer_array['megaitems'][$i_megaitems]['item_count'] = $data['count1'];
      $offer_array['megaitems'][$i_megaitems]['points'] = $data['points'];
      $offer_array['megaitems'][$i_megaitems]['description'] = $data['offer_description'];
      $offer_array['megaitems'][$i_megaitems]['name'] = $data['offer_name'];
      $i_megaitems++;
    }
    elseif ($data['offer_type'] == 'container')
    {
      $offer_array['container'][$i_container]['id'] = $data['id'];
      $offer_array['container'][$i_container]['container_id'] = $data['itemid2'];
      $offer_array['container'][$i_container]['container_count'] = $data['count2'];
      $offer_array['container'][$i_container]['item_id'] = $data['itemid1'];
      $offer_array['container'][$i_container]['item_count'] = $data['count1'];
      $offer_array['container'][$i_container]['points'] = $data['points'];
      $offer_array['container'][$i_container]['description'] = $data['offer_description'];
      $offer_array['container'][$i_container]['name'] = $data['offer_name'];
      $i_container++;
    }
    elseif ($data['offer_type'] == 'unban')
    {
      $offer_array['unban'][$i_unban]['id'] = $data['id'];
      $offer_array['unban'][$i_unban]['points'] = $data['points'];
      $offer_array['unban'][$i_unban]['description'] = $data['offer_description'];
      $offer_array['unban'][$i_unban]['name'] = $data['offer_name'];
      $i_unban++;
    }
    elseif ($data['offer_type'] == 'redskull')
    {
      $offer_array['redskull'][$i_redskull]['id'] = $data['id'];
      $offer_array['redskull'][$i_redskull]['points'] = $data['points'];
      $offer_array['redskull'][$i_redskull]['description'] = $data['offer_description'];
      $offer_array['redskull'][$i_redskull]['name'] = $data['offer_name'];
      $i_redskull++;
    }
    elseif ($data['offer_type'] == 'itemlogout')
    {
      $offer_array['itemlogout'][$i_itemlogout]['id'] = $data['id'];
      $offer_array['itemlogout'][$i_itemlogout]['points'] = $data['points'];
      $offer_array['itemlogout'][$i_itemlogout]['description'] = $data['offer_description'];
      $offer_array['itemlogout'][$i_itemlogout]['name'] = $data['offer_name'];
      $offer_array['itemlogout'][$i_itemlogout]['count1'] = $data['count1'];
      $offer_array['itemlogout'][$i_itemlogout]['pid'] = $data['pid'];
      $offer_array['itemlogout'][$i_itemlogout]['item_id'] = $data['itemid1'];
      $offer_array['itemlogout'][$i_itemlogout]['free_cap'] = $data['free_cap'];
      $i_itemlogout++;
    }
    elseif ($data['offer_type'] == 'changename')
    {
      $offer_array['changename'][$i_changename]['id'] = $data['id'];
      $offer_array['changename'][$i_changename]['points'] = $data['points'];
      $offer_array['changename'][$i_changename]['description'] = $data['offer_description'];
      $offer_array['changename'][$i_changename]['name'] = $data['offer_name'];
      $i_changename++;
    }
  }
  return $offer_array;
}
 
        if($action == '') {
                unset($_SESSION['viewed_confirmation_page']);
                $main_content .= '<div style="text-align: justify;"><center><h2>Welcome to '.$config['server']['serverName'].' Shop.</h2></center></div><div style="text-align: justify;"><center><font color="#2F4F4F"><font size="1"><b>Para receber os 15 points você precisa ter 6 membros ou mais em diferentes IPs e falar !guildpoints</center></div> <center>Que fique bem claro que n&oacute;s da <font color="#FF0000">Equipe</font> n&atilde;o temos a <u>obriga&ccedil;&atilde;o</u> e n&atilde;o iremos <font color="#FF0000">devolver</font> items <u>perdidos</u> ou <u>roubados</u>!</b></font></font><center><br />';
                $offer_list = getOfferArray();
                        //show list of items offers
			if(count($offer_list['vipdays']) > 0 or count($offer_list['container']) > 0 or count($offer_list['itemlogout']) > 0)
				$main_content .= '<center><table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;VIP DAYS</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>Picture</b></td><td width="350" align="left"><b>Description</b></td><td width="250" align="center"><b>Select product</b></td></tr>';
				if(count($offer_list['vipdays']) > 0) {
					foreach($offer_list['vipdays'] as $item) {
						$main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/items/'.$item['id'].'.gif"></td><td><b>'.$item['name'].'</b> ('.$item['points'].' points)<br />'.$item['description'].'</td><td align="center">';
						if(!$logged) $main_content .= '<b>Login to buy</b>'; else 
						$main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$item['id'].'"><input type="submit" value="Buy '.$item['name'].'"><br><b>for '.$item['points'].' points</b></form>';
						$main_content .= '</td></tr>';
					}
					$main_content .= '</table><br />';
				}
			//show list of items offers
			if(count($offer_list['megaitems']) > 0 or count($offer_list['container']) > 0 or count($offer_list['itemlogout']) > 0)
				$main_content .= '<center><table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;VIP ITEMS</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>Picture</b></td><td width="350" align="left"><b>Description</b></td><td width="250" align="center"><b>Select product</b></td></tr>';
				if(count($offer_list['megaitems']) > 0) {
					foreach($offer_list['megaitems'] as $item) {
						$main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/items/'.$item['id'].'.gif"></td><td><b>'.$item['name'].'</b> ('.$item['points'].' points)<br />'.$item['description'].'</td><td align="center">';
						if(!$logged) $main_content .= '<b>Login to buy</b>'; else 
						$main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$item['id'].'"><input type="submit" value="Buy '.$item['name'].'"><br><b>for '.$item['points'].' points</b></form>';
						$main_content .= '</td></tr>';
					}
					$main_content .= '</table><br />';
				}
			//show list of items offers
			if(count($offer_list['item']) > 0 or count($offer_list['container']) > 0 or count($offer_list['itemlogout']) > 0)
				$main_content .= '<center><table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;ITEMS</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>Picture</b></td><td width="350" align="left"><b>Description</b></td><td width="250" align="center"><b>Select product</b></td></tr>';
				if(count($offer_list['item']) > 0) {
					foreach($offer_list['item'] as $item) {
						$main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/items/'.$item['item_id'].'.gif"></td><td><b>'.$item['name'].'</b> ('.$item['points'].' points)<br />'.$item['description'].'</td><td align="center">';
						if(!$logged) $main_content .= '<b>Login to buy</b>'; else 
						$main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$item['id'].'"><input type="submit" value="Buy '.$item['name'].'"><br><b>for '.$item['points'].' points</b></form>';
						$main_content .= '</td></tr>';
					}
					$main_content .= '</table><br />';
				}
				//show list of containers offers
				if(count($offer_list['container']) > 0) {
					$main_content .= '<table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;CONTAINERS WITH ITEMS</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>Picture</b></td><td width="350" align="left"><b>Description</b></td><td width="250" align="center"><b>Select product</b></td></tr>';
					foreach($offer_list['container'] as $container) {
						$main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/items/'.$container['id'].'.gif"></td><td><b>'.$container['name'].'</b> ('.$container['points'].' points)<br />'.$container['description'].'</td><td align="center">';
						if(!$logged) $main_content .= '<b>Login to buy</b>'; else 
						$main_content .= '<form action="?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$container['id'].'"><input type="submit" value="Buy '.$container['name'].'"><br><b>for '.$container['points'].' points</b></form>';
						$main_content .= '</td></tr>';
					}
					$main_content .= '</table><br />';
				}
				if(count($offer_list['itemlogout']) > 0) {
					$main_content .= '<table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;Receive Item on Logout</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>Picture</b></font></td><td width="350" align="left"><b>Description</b></font></td><td width="250" align="center"><b>Select product</b></font></td></tr>';
					foreach($offer_list['itemlogout'] as $itemlogout) {
						$main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/items/'.$itemlogout['id'].'.gif"></td><td><b>'.$itemlogout['name'].'</b> ('.$itemlogout['points'].' points)<br />'.$itemlogout['description'].'</td><td align="center">';
						if(!$logged) $main_content .= '<b>Login to buy</b>'; else 
						$main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$itemlogout['id'].'"><input type="submit" value="Buy '.$itemlogout['name'].'"><br><b>for '.$itemlogout['points'].' points</b></form>';
						$main_content .= '</td></tr>';
					}
					$main_content .= '</table><br />';
				}
                        if(count($offer_list['changename']) > 0 or count($offer_list['pacc']) > 0 or count($offer_list['redskull']) > 0 or count($offer_list['unban']) > 0 )
                                $main_content .= '<center><table border="0" cellpadding="1" cellspacing="1" width="650"><tr width="650" bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>&nbsp;Others</b></font></td></tr><tr bgcolor="#D4C0A1"><td width="50" align="center"><b>#</b></td><td width="350" align="left"><b>Description</b></td><td width="250" align="center"><b>Select product</b></td></tr>';
                                //Pacc
                                if(count($offer_list['pacc']) > 0)
                                        foreach($offer_list['pacc'] as $pacc) {
                                                $main_content .= '<tr bgcolor="#F1E0C6"><td align="center">'.$pacc['days'].'</td><td><b>'.$pacc['name'].'</b> ('.$pacc['points'].' points)<br />'.$pacc['description'].'</td><td align="center">';
                                                if(!$logged) $main_content .= '<b>Login to buy</b>'; else
                                                $main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$pacc['id'].'"><input type="submit" value="Buy '.$pacc['name'].'"><br><b>for '.$pacc['points'].' points</b></form>';
                                        }
                                //Change Name
                                if(count($offer_list['changename']) > 0)
                                        foreach($offer_list['changename'] as $changename) {
                                                $main_content .= '<tr bgcolor="#F1E0C6"><td align="center">Change Name</td><td><b>'.$changename['name'].'</b> ('.$changename['points'].' points)<br />'.$changename['description'].'</td><td align="center">';
                                                if(!$logged) $main_content .= '<b>Login to buy</b>'; else
                                                $main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$changename['id'].'"><input type="submit" value="Buy '.$changename['name'].'"><br><b>for '.$changename['points'].' points</b></form>';
                                        }
                                //Remove Red Skull
                                if(count($offer_list['redskull']) > 0)
                                        foreach($offer_list['redskull'] as $redskull) {
                                                $main_content .= '<tr bgcolor="#F1E0C6"><td align="center"><img src="images/item_images/'.$redskull['id'].'.gif"></td><td><b>'.$redskull['name'].'</b> ('.$redskull['points'].' points)<br />'.$redskull['description'].'</td><td align="center">';
                                                if(!$logged) $main_content .= '<b>Login to buy</b>'; else
                                                $main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$redskull['id'].'"><input type="submit" value="Buy '.$redskull['name'].'"><br><b>for '.$redskull['points'].' points</b></form>';
                                                $main_content .= '</td></tr>';
                                        }
                                //Unban
                                if(count($offer_list['unban']) > 0)
                                        foreach($offer_list['unban'] as $unban){
                                                $main_content .= '<tr bgcolor="#F1E0C6"><td align="center">Unban</td><td><b>'.$unban['name'].'</b> ('.$unban['points'].' points)<br />'.$unban['description'].'</td><td align="center">';
                                                if(!$logged) $main_content .= '<b>Login to buy</b>'; else
                                                $main_content .= '<form action="index.php?subtopic=shopguild&action=select_player" method=POST><input type="hidden" name="buy_id" value="'.$unban['id'].'"><input type="submit" value="Buy '.$unban['name'].'"><br><b>for '.$unban['points'].' points</b></form>';
                                                $main_content .= '</td></tr>';
                                        }
                                        $main_content .= '</table>';
        }
        elseif($action == 'select_player') 
{
	unset($_SESSION['viewed_confirmation_page']);
	
	if(!$logged) 
	{
		$main_content .= 'Please login first.';
	} 
	else 
	{
		$buy_id = (int) $_REQUEST['buy_id'];
		
		if(empty($buy_id)) 
		{			
			$main_content .= 'Please <a href="index.php?subtopic=shopguild">select item</a> first.';
		} 
		else 
		{
			$buy_offer = getItemByID($buy_id);
			
			if(isset($buy_offer['id'])) 
			{
				if($user_guild_points >= $buy_offer['points']) 
				{
					$main_content .= '<center><h2>Select player</h2><table border="0" cellpadding="1" cellspacing="1" width="650">
					<tr bgcolor="#505050"><td colspan="2"><font color="white" size="4"><b>Selected offer</b></font></td></tr>
					<tr bgcolor="#F1E0C6"><td width="100"><b>Name:</b></td><td width="550">'.$buy_offer['name'].'</td></tr>
					<tr bgcolor="#D4C0A1"><td width="100"><b>Description:</b></td><td width="550">'.$buy_offer['description'].'</td></tr>
					</table><br /><form action="index.php?subtopic=shopguild&action=confirm_transaction" method=POST><input type="hidden" name="buy_id" value="'.$buy_id.'">
					<table border="0" cellpadding="1" cellspacing="1" width="650">
					<tr bgcolor="#505050"><td colspan="2"><font color="white" size="4"><b>Give item to a player from your account</b></font></td></tr>
					<tr bgcolor="#F1E0C6"><td width="110"><b>Name:</b></td><td width="550"><select name="buy_name">';
								
					$players_from_logged_acc = $account_logged->getPlayersList();
						
					if(count($players_from_logged_acc) > 0) 
                    {
                        $players_from_logged_acc->addOrder(new SQL_Order('name', SQL_Order::ASC));  
                        foreach($players_from_logged_acc as $player)
						{
							$main_content .= '<option>'.$player->getName().'</option>';
						}
                    } 
					else 
					{
						$main_content .= 'You don\'t have any character on your account.';
					}
					
					$main_content .= '</select>&nbsp;<input type="submit" value="Give"></td></tr></table></form><br />
					<form action="index.php?subtopic=shopguild&action=confirm_transaction" method=POST><input type="hidden" name="buy_id" value="'.$buy_id.'">
					<table border="0" cellpadding="1" cellspacing="1" width="650"> </table><br /></form>';
				} 
				else 
				{
					$main_content .= 'For this item you need <b>'.$buy_offer['points'].'</b> points.<br>You have only <b>'.$user_guild_points.'</b> guild points. Please <a href="index.php?subtopic=shopguild">select other item</a> or buy guild points.';
				}
			} 
			else 
			{
          		$main_content .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="index.php?subtopic=shopguild">select item</a> again.';
			}
		}
	}
}
        elseif($action == 'confirm_transaction') {
                if(!$logged) {
                        $main_content .= 'Please login first.';
                } else {
                        $buy_id = (int) $_POST['buy_id'];
                        $buy_name = stripslashes(urldecode($_POST['buy_name']));
                        $buy_from = stripslashes(urldecode($_POST['buy_from']));
                        if(empty($buy_id)) {
                                $main_content .= 'Please <a href="index.php?subtopic=shopguild">select item</a> first.';
                        } else {
                                if($buy_offer['type'] == 'changename'){
                                        if(!check_name_new_char($buy_from)) {
                                                $main_content .= 'Invalid name format of new name.';
                                        }
                                } else {
                                        $buy_offer = getItemByID($buy_id);
                                        $buy_player = new Player();
										$buy_player->find($buy_from);

                                        if($buy_offer['type'] == 'changename'){
                                                if(!$check_name_in_database->isLoaded()) {
                                                }
                                        }
                                        if(isset($buy_offer['id'])) {  //item exist in database
                                                if($user_guild_points >= $buy_offer['points']) {
                                                        if(check_name($buy_name)) {
                                                                $buy_player = new Player();
                                                                $buy_player->find($buy_name);
                                                                if($buy_player->isLoaded()) {
                                                                        $buy_player_account = $buy_player->getAccount();
                                                                        if($_SESSION['viewed_confirmation_page'] == 'yes' && $_POST['buy_confirmed'] == 'yes') {
                                                                               
                                                                               
                                                                               
                        if($buy_offer['type'] == 'pacc') {
                                $player_vip_time = $buy_player_account->getCustomField('vip_time');
                                $player_lastlogin = $buy_player_account->getCustomField('lastday');
                                $save_transaction = 'INSERT INTO '.$SQL->tableName('z_shopguild_history_pacc').' (id, to_name, to_account, from_nick, from_account, price, pacc_days, trans_state, trans_start, trans_real) VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['days']).', \'realized\', '.$SQL->quote(time()).', '.$SQL->quote(time()).');';
                                $SQL->query($save_transaction);
                                if($player_vip_time > 0)
                                        $buy_player_account->setCustomField('vip_time', $player_vip_time + $buy_offer['days'] * 86400);
                                else
                                        $buy_player_account->setCustomField('vip_time', time() + $buy_offer['days'] * 86400);
                                $buy_player_account->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                $user_guild_points = $user_guild_points - $buy_offer['points'];
                                if ($player_vip_days >= 1) {
                                }
                                $main_content .= '<center><h2>VIP Days added!</h2><b>'.$buy_offer['days'].' days</b> of VIP days added to the account of player <b>'.$buy_player->getName().'</b> for <b>'.$buy_offer['points'].' guild points</b> from your account.<br />Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">Go to Shop Site</a><br>';
                                }
                        elseif($buy_offer['type'] == 'unban') {
                                $my_acc_id = $account_logged->getCustomField('id');
                                $datadata = $SQL->query('SELECT * FROM '.$SQL->tableName('bans').' WHERE value = '.$my_acc_id.';')->fetch();
                                        if($datadata['value'] == $my_acc_id) {
                                                if($SQL->query('DELETE FROM bans WHERE value= '.$my_acc_id.' LIMIT 1;')) {
                                                } else {
                                                        $SQL->query('DELETE FROM bans WHERE account= '.$my_acc_id.' LIMIT 1;');
                                                }
                                                $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                $main_content .= '<center><h2>Ban Deleted!</h2><b>Your account has been unbanned for '.$buy_offer['points'].' guild points</b> from your account.
                                                       <br>Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">Go to Shop Site</a><br>';
                                        } else {
                                                $main_content .= '<center><b>You don\'t have any bans in your account!</b><br><br><a href="index.php?subtopic=shopguild">Go back</a><br>';
                                        }
                                }
                                                                                ////////////////////////////////
                                                                                elseif($buy_offer['type'] == 'itemlogout') {
                                                                                        $my_acc_id = $buy_player->getCustomField('id');
                                                                                        $playerinfo = $SQL->query('SELECT * FROM '.$SQL->tableName('players').' WHERE id = '.$my_acc_id.';')->fetch();
                                                                                        $playerslot = $SQL->query('SELECT * FROM '.$SQL->tableName('player_items').' WHERE player_id = '.$my_acc_id.';')->fetch();
                                                                                        if($playerinfo['online'] == '0') {
                                                                                                if ($playerslot['pid'] != '10') {
                                                                                                        if ($datadata['cap'] >= $SQL->quote($buy_offer['free_cap'])) {
                                                                                                                $SQL->query('INSERT INTO player_items (player_id, pid, itemtype, count) VALUES ('.$my_acc_id.', '.$SQL->quote($buy_offer['pid']).', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['count1']).');');
                                                                                                                $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                                                $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                                                $main_content .= '<h2>Item received to player: '.$buy_player->getName().'!</h2><br>Now you have <b>'.$user_guild_points.' guild points</b>.
                                                                                                                       <br><a href="index.php?subtopic=shopguild">Go to Shop Site</a>';
                                                                                                        } else {
                                                                                                                $main_content .= '<b>You need '.$SQL->quote($buy_offer['free_cap']).' or more of cap!</b><br><a href="index.php?subtopic=shopguild">Go back</a>';
                                                                                                        }
                                                                                                } else {
                                                                                                        $main_content .= '<b>Please leave the arrow slot in blank to receive item!</b><br><a href="index.php?subtopic=shopguild">Go back</a>';
                                                                                                }
                                                                                        } else {
                                                                                                $main_content .= '<b>You need to be offline!</b><br><a href="index.php?subtopic=shopguild">Go back</a>';
                                                                                        }
                                                                                }
                                                                                ////////////////////////////////
                                                                                elseif($buy_offer['type'] == 'changename') {
                                                                                $erroName=0;
                                                                                if(!check_name_new_char($buy_from)) {
                                                                                        $main_content .= 'Invalid name format of new name.';
                                                                                        $erroName++;
                                                                                }
                                                                               
                                                                                        $my_acc_id = $buy_player->getCustomField('id');
                                                                                        $playerinfo = $SQL->query('SELECT * FROM '.$SQL->tableName('players').' WHERE '.$SQL->fieldName('id').' = '.$my_acc_id.';')->fetch();
                                                                                        $checkname = $SQL->query('SELECT * FROM '.$SQL->tableName('players').' WHERE '.$SQL->fieldName('name').' = '. $SQL->quote($buy_from) .';')->fetch();
                                                                                        if($playerinfo['online'] == '0') {
                                                                                               
                                                                                                if($checkname == false and $erroName == 0) {
                                                                                                        $SQL->query('UPDATE `players` SET `name` = '. $SQL->quote($buy_from) .' WHERE `id` = '. $my_acc_id.' ;');
                                                                                                        $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                                        $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                                        $main_content .= '<center><h2>Your name has been changed to '.$buy_from.'.</h2><br><b>You have '.$user_guild_points.' guild points left</b>.
                                                                                                               <br><br><a href="index.php?subtopic=shopguild">Go to Shop Site</a><br>';
                                                                                                } else {
                                                                                                        $main_content .= '<center><h2>Sorry, the name "<i>'.$buy_from.'</i>" does already exist.<br>Please select another name.</h2><br>';
                                                                                                }
                                                                                        } else {
                                                                                                $main_content .= '<center><h2>'.$buy_name.' has to be offline to complete transaction.</h2><br><br><a href="index.php?subtopic=shopguild">Go back</a><br>';
                                                                                        }
                                                                                }
                                                                                ////////////////////////////////
                                                                                elseif($buy_offer['type'] == 'redskull') {
                                                                                        $my_acc_id = $buy_player->getCustomField('id');
                                                                                        $playerinfo = $SQL->query('SELECT * FROM '.$SQL->tableName('players').' WHERE '.$SQL->fieldName('id').' = '.$my_acc_id.';')->fetch();
                                                                                        if($playerinfo['skull'] == '4' AND $playerinfo['online'] >= '0' AND $playerinfo['skulltime'] > '0') {
                                                                                                $SQL->query('UPDATE killers SET unjustified=0 WHERE id IN (SELECT kill_id FROM player_killers WHERE player_id='. $my_acc_id .');');
                                                                                                $SQL->query('UPDATE players SET skulltime=0, skull=0 WHERE id='. $my_acc_id .';');
                                                                                                $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                                $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                                $main_content .= '<center><h2>RedSkull Removed!</h2><br><b>Your redskull has been removed from the player '.$buy_player->getName().'.</b>
                                                                                                       <br>Now you have<b> '.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">Go to Shop Site</a><br>';
                                                                                        } else {
                                                                                                $main_content .= '<center><b>'.$buy_player->getName().' has to be offline or have redskull to complete transaction!.</b><br><br><a href="index.php?subtopic=shopguild">Go back</a><br>';
                                                                                        }
                                                                                }
                                                                                //////////////////////////
                                                                                elseif($buy_offer['type'] == 'item') {
                                                                                        $sql = 'INSERT INTO '.$SQL->tableName('z_ots_guildcomunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$SQL->quote($buy_player->getName()).', \'login\', \'give_item\', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', \'\', \'\', \'item\', '.$SQL->quote($buy_offer['name']).', \'\', \'1\');';
                                                                                        $SQL->query($sql);
                                                                                        $save_transaction = 'INSERT INTO '.$SQL->tableName('z_shopguild_history_item').' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['item_id']).', \'wait\', '.$SQL->quote(time()).', \'0\');';
                                                                                        $SQL->query($save_transaction);
                                                                                        $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                        $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                        $main_content .= '<center><h2>Item added!</h2><b>'.$buy_offer['name'].'</b> added to player <b>'.$buy_player->getName().'</b> for <b>'.$buy_offer['points'].' guild points</b> from your account.<br>Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">GO TO MAIN SHOP SITE</a><br>';
                                                                                }
                                                                                if($buy_offer['type'] == 'vipdays') {
                                                                                        $player_vip_time = $buy_player_account->getCustomField('vip_time');
                                                                                        $player_lastlogin = $buy_player_account->getCustomField('lastday');
                                                                                        $save_transaction = 'INSERT INTO '.$SQL->tableName('z_shopguild_history_pacc').' (id, to_name, to_account, from_nick, from_account, price, pacc_days, trans_state, trans_start, trans_real) VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['days']).', \'realized\', '.$SQL->quote(time()).', '.$SQL->quote(time()).');';
                                                                                        $SQL->query($save_transaction);
                                                                                if($player_vip_time > 0)
                                                                                        $buy_player_account->setCustomField('vip_time', $player_vip_time + $buy_offer['days'] * 86400);
                                                                                else
                                                                                        $buy_player_account->setCustomField('vip_time', time() + $buy_offer['days'] * 86400);
                                                                                        $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                        $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                if ($player_vip_days >= 1) {
                                                                                }
                                                                                        $main_content .= '<center><h2>VIP Days added!</h2><b>'.$buy_offer['days'].' days</b> of VIP days added to the account of player <b>'.$buy_player->getName().'</b> for <b>'.$buy_offer['points'].' guild points</b> from your account.<br />Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">Go to Shop Site</a><br>';
                                                                                }  
                                                                                elseif($buy_offer['type'] == 'megaitems') {
                                                                                        $sql = 'INSERT INTO '.$SQL->tableName('z_ots_guildcomunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$SQL->quote($buy_player->getName()).', \'login\', \'give_item\', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['megaitems_count']).', \'\', \'\', \'megaitems\', '.$SQL->quote($buy_offer['name']).', \'\', \'1\');';
                                                                                        $SQL->query($sql);
                                                                                        $save_transaction = 'INSERT INTO '.$SQL->tableName('z_shopguild_history_item').' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['item_id']).', \'wait\', '.$SQL->quote(time()).', \'0\');';
                                                                                        $SQL->query($save_transaction);
                                                                                        $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                        $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                        $main_content .= '<center><h2>Mega Item added!</h2><b>'.$buy_offer['name'].'</b> added to player <b>'.$buy_player->getName().'</b> for <b>'.$buy_offer['points'].' guild points</b> from your account.<br>Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">GO TO MAIN SHOP SITE</a><br>';
                                                                                }
                                                                                elseif($buy_offer['type'] == 'container') {
                                                                                        $sql = 'INSERT INTO '.$SQL->tableName('z_ots_guildcomunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$SQL->quote($buy_player->getName()).', \'login\', \'give_item\', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote($buy_offer['container_id']).', '.$SQL->quote($buy_offer['container_count']).', \'container\', '.$SQL->quote($buy_offer['name']).', \'\', \'1\');';
                                                                                        $SQL->query($sql);
                                                                                        $save_transaction = 'INSERT INTO '.$SQL->tableName('z_shopguild_history_item').' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['item_id']).', \'wait\', '.$SQL->quote(time()).', \'0\');';
                                                                                        $SQL->query($save_transaction);
                                                                                        $account_logged->setCustomField('guild_points', $user_guild_points-$buy_offer['points']);
                                                                                        $user_guild_points = $user_guild_points - $buy_offer['points'];
                                                                                        $main_content .= '<center><h2>Container of items added!</h2><b>'.$buy_offer['name'].'</b> added to player <b>'.$buy_player->getName().'</b> for <b>'.$buy_offer['points'].' guild points</b> from your account.<br />Now you have <b>'.$user_guild_points.' guild points</b>.<br><br><a href="index.php?subtopic=shopguild">GO TO MAIN SHOP SITE</a><br>';
                                                                                }
                                                                        } else {
                                                                                if($buy_offer['type'] != 'changename') {
                                                                                        $set_session = TRUE;
                                                                                        $_SESSION['viewed_confirmation_page'] = 'yes';
                                                                                        $main_content .= '<center><h2>Confirm transaction</h2>
                                                                                               <table border="0" cellpadding="1" cellspacing="1" width="700">
                                                                                               <tr bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>Confirm transaction</b></font></td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="100"><b>Name:</b></td><td width="550" colspan="2">'.$buy_offer['name'].'</td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="100"><b>Description:</b></td><td width="550" colspan="2">'.$buy_offer['description'].'</td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="100"><b>Cost:</b></td><td width="550" colspan="2"><b>'.$buy_offer['points'].' guild points</b> from your account</td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="100"><b>For Player:</b></td><td width="550" colspan="2"><font color="red">'.$buy_player->getName().'</font></td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="100"><b>From:</b></td><td width="550" colspan="2"><font color="red">'.$buy_from.'</font></td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="100"><b>Transaction?</b></td><td width="275" align="left">
                                                                                               <form action="index.php?subtopic=shopguild&action=confirm_transaction" method="POST"><input type="hidden" name="buy_confirmed" value="yes"><input type="hidden" name="buy_id" value="'.$buy_id.'"><input type="hidden" name="buy_from" value="'.urlencode($new_name).'"><input type="hidden" name="buy_name" value="'.urlencode($buy_name).'"><input type="submit" value="Accept"></form></td>
                                                                                               <td align="right"><form action="index.php?subtopic=shopguild" method="POST"><input type="submit" value="Cancel"></form></td></tr>
                                                                                               </table>';
                                                                                } else {
                                                                                        $set_session = TRUE;
                                                                                        $_SESSION['viewed_confirmation_page'] = 'yes';
                                                                                        $main_content .= '<center><h2>Confirm Name Changing</h2>
                                                                                               <table border="0" cellpadding="1" cellspacing="1" width="700">
                                                                                               <tr bgcolor="#505050"><td colspan="3"><font color="white" size="4"><b>Confirm transaction</b></font></td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="130"><b>Name:</b></td><td width="550" colspan="2">'.$buy_offer['name'].'</td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="130"><b>Description:</b></td><td width="550" colspan="2">'.$buy_offer['description'].'</td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="130"><b>Cost:</b></td><td width="550" colspan="2"><b>'.$buy_offer['points'].' guild points</b> from your account</td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="130"><b>Current Name:</b></td><td width="550" colspan="2"><font color="red">'.$buy_player->getName().'</font></td></tr>
                                                                                               <tr bgcolor="#D4C0A1"><td width="130"><b>New Name:</b></td><td width="550" colspan="2"><font color="red">'.$buy_from.'</font></td></tr>
                                                                                               <tr bgcolor="#F1E0C6"><td width="130"><b>Change Name?</b></td><td width="275" align="left">
                                                                                               <form action="index.php?subtopic=shopguild&action=confirm_transaction" method="POST"><input type="hidden" name="buy_confirmed" value="yes"><input type="hidden" name="buy_id" value="'.$buy_id.'"><input type="hidden" name="buy_from" value="'.urlencode($buy_from).'"><input type="hidden" name="buy_name" value="'.urlencode($buy_name).'"><input type="submit" value="Accept"></form></td>
                                                                                               <td align="right"><form action="index.php?subtopic=shopguild" method="POST"><input type="submit" value="Cancel"></form></td></tr>
                                                                                               </table>';
                                                                                }
                                                                        }
                                                                } else {
                                                                        $main_content .= 'Player with name <b>'.$buy_name.'</b> doesn\'t exist. Please <a href="index.php?subtopic=shopguild&action=select_player&buy_id='.$buy_id.'">select other name</a>.';
                                                                }
                                                        } else {
                                                                $main_content .= 'Invalid name format. Please <a href="index.php?subtopic=shopguild&action=select_player&buy_id='.$buy_id.'">select other name</a> or contact with administrator.';
                                                        }
                                                } else {
                                                        $main_content .= 'For this item you need <b>'.$buy_offer['points'].'</b> points. You have only <b>'.$user_guild_points.'</b> guild points. Please <a href="index.php?subtopic=shopguild">select other item</a> or buy guild points.';
                                                }
                                        } else {
                                                $main_content .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="index.php?subtopic=shopguild">select item</a> again.';
                                        }
                                }
                        }
                }
                if(!$set_session) {
                        unset($_SESSION['viewed_confirmation_page']);
                }
        }
 
        elseif($action == 'show_history') {
                if(!$logged) {
                        $main_content .= 'Please login first.';
                } else{
                        $items_history_received = $SQL->query('SELECT * FROM '.$SQL->tableName('z_shopguild_history_item').' WHERE '.$SQL->fieldName('to_account').' = '.$SQL->quote($account_logged->getId()).' OR '.$SQL->fieldName('from_account').' = '.$SQL->quote($account_logged->getId()).';');
                        if(is_object($items_history_received)) {
                                foreach($items_history_received as $item_received) {
                                        if($account_logged->getId() == $item_received['to_account'])
                                                $char_color = 'green';
                                        else
                                                $char_color = 'red';
                                                $items_received_text .= '<tr bgcolor="#F1E0C6"><td><font color="'.$char_color.'">'.$item_received['to_name'].'</font></td><td>';
                                        if($account_logged->getId() == $item_received['from_account'])
                                                $items_received_text .= '<i>Your account</i>';
                                        else
                                                $items_received_text .= $item_received['from_nick'];
                                               
                                                $items_received_text .= '</td><td>'.$item_received['offer_id'].'</td><td>'.$item_received['price'].' Points</td><td>'.date("j F Y, H:i:s", $item_received['trans_start']).'</td>';
                                       
                                       
                                       
                                       
                                        if($item_received['trans_real'] > 0)
                                                $items_received_text .= '<td>'.date("j F Y, H:i:s", $item_received['trans_real']).'</td>';
                                        else
                                                $items_received_text .= '<td><b><font color="red">Not realized yet.</font></b></td>';
                                                $items_received_text .= '</tr>';
                                }
                        }
                        $paccs_history_received = $SQL->query('SELECT * FROM '.$SQL->tableName('z_shopguild_history_pacc').' WHERE '.$SQL->fieldName('to_account').' = '.$SQL->quote($account_logged->getId()).' OR '.$SQL->fieldName('from_account').' = '.$SQL->quote($account_logged->getId()).';');
                        if(is_object($paccs_history_received)) {
                                foreach($paccs_history_received as $pacc_received) {
                                        if($account_logged->getId() == $pacc_received['to_account'])
                                                $char_color = 'green';
                                        else
                                                $char_color = 'red';
                                                $paccs_received_text .= '<tr bgcolor="#F1E0C6"><td><font color="'.$char_color.'">'.$pacc_received['to_name'].'</font></td><td>';
                                        if($account_logged->getId() == $pacc_received['from_account'])
                                                $paccs_received_text .= '<i>Your account</i>';
                                        else
                                                $paccs_received_text .= $pacc_received['from_nick'];
                                                $paccs_received_text .= '</td><td>'.$pacc_received['pacc_days'].' days</td><td>'.$pacc_received['price'].' Points</td><td>'.date("j F Y, H:i:s", $pacc_received['trans_real']).'</td></tr>';
                                }
                        }
                        $main_content .= '<center><h1>Transactions History</h1></center>';
                        if(!empty($items_received_text))
                                $main_content .= '<center><table BORDER=0 CELLPADDING=1 CELLSPACING=1 WIDTH=95%><tr width="100%" bgcolor="#505050"><td colspan="6"><font color="white" size="4"><b>&nbsp;Item Transactions</b></font></td></tr><tr bgcolor="#D4C0A1"><td><b>To:</b></td><td><b>From:</b></td><td><b>Offer name</b></td><td><b>Cost</b></td><td><b>Bought on page</b></td><td><b>Received on '.$config['server']['serverName'].'</b></td></tr>'.$items_received_text.'</table><br />';
                        if(!empty($paccs_received_text))
                                $main_content .= '<center><table BORDER=0 CELLPADDING=1 CELLSPACING=1 WIDTH=95%><tr width="100%" bgcolor="#505050"><td colspan="5"><font color="white" size="4"><b>&nbsp;Pacc Transactions</b></font></td></tr><tr bgcolor="#D4C0A1"><td><b>To:</b></td><td><b>From:</b></td><td><b>Duration</b></td><td><b>Cost</b></td><td><b>Added:</b></td></tr>'.$paccs_received_text.'</table><br />';
                        if(empty($paccs_received_text) && empty($items_received_text))
                                $main_content .= 'You did not buy/receive any items or PACC.';
                }
        }
        if(!$logged)
                $main_content .= 'Please login to see how much points you have.';
        else
                $main_content .= '<br><b><font color="green">You have guild points: </font></b>'.$user_guild_points;
        }
else
        $main_content .= '<br><center><b>Shop System is currently disabled for this server.Please ask the admin for more information.</b></center>';
?>