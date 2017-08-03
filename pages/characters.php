<img id="ContentBoxHeadline" class="Title" src="layouts/tibiacom/images/header/headline-characters.gif" alt="Contentbox headline">
<?php
if(!defined('INITIALIZED'))
	exit;

$name = '';
if(isset($_REQUEST['name']))
	$name = (string) $_REQUEST['name'];

if(!empty($name))
{
	$player = new Player();
	$player->find($name);
	if($player->isLoaded())
	{
		$number_of_rows = 0;
		$account = $player->getAccount();
		$skull = '';
		if ($player->getSkull() == 4)
			$skull = "<img style='border: 0;' src='./images/skulls/redskull.gif'/>";
		else if ($player->getSkull() == 5)
			$skull = "<img style='border: 0;' src='./images/skulls/blackskull.gif'/>";
		$main_content .= '<table border="0" cellspacing="1" cellpadding="4" width="100%"><tr bgcolor="'.$config['site']['vdarkborder'].'"><td colspan="2" style="font-weight:bold;color:white">Character Information</td></tr>';
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td width="20%">Name:</td><td>' . htmlspecialchars($player->getName()) . ' ' . $skull . '';
		if($player->isBanned() || $account->isBanned())
			$main_content .= '<span style="color:red">[BANNED]</span>';
		if($player->isNamelocked())
			$main_content .= '<span style="color:red">[NAMELOCKED]</span>';
		$main_content .= '<br /></td></tr>';

        if(in_array($player->getGroup(), $config['site']['groups_support']))
        {
        $bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
        $main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Group:</td><td><span style="color:green">' . htmlspecialchars(Website::getGroupName($player->getGroup())) . '</span></td></tr>';
        }
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Sex:</td><td>' . htmlspecialchars((($player->getSex() == 0) ? 'female' : 'male')) . '</td></tr>';
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Profession:</td><td>' . htmlspecialchars(Website::getVocationName($player->getVocation())) . '</td></tr>';
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Level:</td><td>' . htmlspecialchars($player->getLevel()) . '</td></tr>';
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Residence:</td><td>' . htmlspecialchars($towns_list[$player->getTownID()]) . '</td></tr>';
		$rank_of_player = $player->getRank();
		if(!empty($rank_of_player))
		{
			$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Guild Membership:</td><td>' . htmlspecialchars($rank_of_player->getName()) . ' of the <a href="?subtopic=guilds&action=view&GuildName=' . $rank_of_player->getGuild()->getName() . '">' . htmlspecialchars($rank_of_player->getGuild()->getName()) . '</a></td></tr>';
		}
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);

		$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Last login:</td><td>' . (($player->getLastLogin() > 0) ? date("j F Y, g:i a", $player->getLastLogin()) : 'Never logged in.') . '</td></tr>';

		$comment = $player->getComment();
		$newlines = array("\r\n", "\n", "\r");
		$comment_with_lines = str_replace($newlines, '<br />', $comment, $count);
		if($count < 50)
			$comment = $comment_with_lines;
		if(!empty($comment))
		{
			$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Comment:</td><td>' . $comment . '</td></tr>';
		}
		$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
		$main_content .= '<tr bgcolor="' . $bgcolor . '"><TD>Account&#160;Status:</TD><TD>';
		$main_content .= ($account->isPremium() > 0) ? 'Premium Account' : 'Premium Account';
		$main_content .= '</TABLE>';
		$main_content .= '</br>';

		if ($player->isHiddenSet() == 1) {
			$main_content .= '<table width=100%><tr>';
			$itemsList = $player->getItems();
			$main_content .= '<td align=center><table with=100% style="border: solid 1px #888888;" CELLSPACING="1"><TR>';		
			$list = array('2','1','3','6','4','5','9','7','10','8');
			foreach ($list as $number_of_items_showed => $slot)
			{
				if($slot == '8') // add Soul before show 'feet'
				{
					$main_content .= '<td style="background-color: '.$config['site']['darkborder'].'; text-align: center;">Soul:<br/>'. $player->getSoul() .'</td>';
				}
				if($itemsList->getSlot($slot) === false) // item does not exist in database
				{
					$main_content .= '<TD style="background-color: '.$config['site']['darkborder'].';"><img src="' . $config['site']['item_images_url'] . $slot . $config['site']['item_images_extension'] . '" width="45"/></TD>';
				}
				else
				{
					$main_content .= '<TD style="background-color: '.$config['site']['darkborder'].';"><img src="' . $config['site']['item_images_url'] . $itemsList->getSlot($slot)->getID() . $config['site']['item_images_extension'] . '" width="45"/></TD>';
				}
				if($number_of_items_showed % 3 == 2)
				{
					$main_content .= '</tr><tr>';
				}
				if($slot == '8') // add Capacity after show 'feet'
				{
					$main_content .= '<td style="background-color: '.$config['site']['darkborder'].'; text-align: center;">Cap:<br/>'. $player->getCap() .'</td>';
				}
			}
			$main_content .= '</tr></TABLE></td>';

			$hpPercent = max(0, min(100, $player->getHealth() / max(1, $player->getHealthMax()) * 100));
			$manaPercent = max(0, min(100, $player->getMana() / max(1, $player->getManaMax()) * 100));
			$main_content .= '<td align=center ><table width=100%><tr><td align=center><table CELLSPACING="1" CELLPADDING="4" width="100%"><tr><td BGCOLOR="'.$config['site']['lightborder'].'" align="left" width="20%"><b>Player Health:</b></td>
			<td BGCOLOR="'.$config['site']['lightborder'].'" align="left">'.$player->getHealth().'/'.$player->getHealthMax().'<div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: red; width: ' . $hpPercent . '%; height: 3px;"></td></tr>
			<tr><td BGCOLOR="'.$config['site']['darkborder'].'" align="left"><b>Player Mana:</b></td><td BGCOLOR="'.$config['site']['darkborder'].'" align="left">' . $player->getMana() . '/' . $player->getManaMax() . '<div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: blue; width: '.$manaPercent.'%; height: 3px;"></td></tr></table><tr>';

			$expCurrent = Functions::getExpForLevel($player->getLevel());
			$expNext = Functions::getExpForLevel($player->getLevel() + 1);
			$expLeft = bcsub($expNext, $player->getExperience(), 0);


			$expLeftPercent = max(0, min(100, ($player->getExperience() - $expCurrent) / ($expNext - $expCurrent) * 100));
			$main_content .= '<tr><table CELLSPACING="1" CELLPADDING="4"><tr><td BGCOLOR="'.$config['site']['lightborder'].'" align="left" width="20%"><b>Player Level:</b></td><td BGCOLOR="'.$config['site']['lightborder'].'" align="left">'.$player->getLevel().'</td></tr>
			<tr><td BGCOLOR="'.$config['site']['darkborder'].'" align="left"><b>Player Experience:</b></td><td BGCOLOR="'.$config['site']['darkborder'].'" align="left">' . $player->getExperience() . ' EXP.</td></tr>
			<tr><td BGCOLOR="' . $config['site']['lightborder'].'" align="left"><b>To Next Level:</b></td><td BGCOLOR="'.$config['site']['lightborder'].'" align="left">You need <b>' . $expLeft . ' EXP</b> to Level <b>' . ($player->getLevel() + 1) . '</b>.<div title="' . (100 - $expLeftPercent)  . '% left" style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: red; width: '.$expLeftPercent.'%; height: 3px;"></td></tr></table></td></tr></table></tr></TABLE></td>';
		}

		if ($player->isHiddenSkills() == 1) 
		{
			$main_content .= '<center><strong>Skills</strong><table cellspacing="0" cellpadding="0" border="1" width="200">
				
				<tbody>
					<tr>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=experience"><img src="images/skills/level.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=magic"><img src="images/skills/ml.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=fist"><img src="images/skills/fist.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=club"><img src="images/skills/club.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=sword"><img src="images/skills/sword.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=axe"><img src="images/skills/axe.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=distance"><img src="images/skills/dist.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=shield"><img src="images/skills/def.gif" alt="" style="border-style: none"/></td>
						<td style="text-align: center;"><a href="?subtopic=highscores&list=fishing"><img src="images/skills/fish.gif" alt="" style="border-style: none"/></td>
					</tr>
					<tr>
						<tr bgcolor="' . $config['site']['darkborder'] . '"><td style="text-align: center;"><strong>Level</strong></td>
						<td style="text-align: center;"><strong>ML</strong></td>
						<td style="text-align: center;"><strong>Fist</strong></td>
						<td style="text-align: center;"><strong>Mace</strong></td>
						<td style="text-align: center;"><strong>Sword</strong></td>
						<td style="text-align: center;"><strong>Axe</strong></td>
						<td style="text-align: center;"><strong>Dist</strong></td>
						<td style="text-align: center;"><strong>Def</strong></td>
						<td style="text-align: center;"><strong>Fish</strong></td>
					</tr>
					<tr>
						<tr bgcolor="' . $config['site']['lightborder'] . '"><td style="text-align: center;">' . $player->getLevel() . '</td>
						<td style="text-align: center;">' . $player->getMagLevel().'</td>
						<td style="text-align: center;">' . $player->getSkill(0) . '</td>
						<td style="text-align: center;">' . $player->getSkill(1) . '</td>
						<td style="text-align: center;">' . $player->getSkill(2) . '</td>
						<td style="text-align: center;">' . $player->getSkill(3) . '</td>
						<td style="text-align: center;">' . $player->getSkill(4) . '</td>
						<td style="text-align: center;">' . $player->getSkill(5) . '</td>
						<td style="text-align: center;">' . $player->getSkill(6) . '</td>
					</tr>
				</tbody>
			</table>
			<div style="text-align: center;">&nbsp;<br />&nbsp;</div></center>';
		}

		if(isset($config['site']['quests']) && is_array($config['site']['quests']) && count($config['site']['quests']) > 0)
		{
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD align="left" COLSPAN=2 CLASS=white><B>Quests</B></TD></TD align="right"></TD></TR>';		
			$number_of_quests = 0;
			foreach($config['site']['quests'] as $questName => $storageID)
			{
				$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
				$number_of_quests++;
				$main_content .= '<TR BGCOLOR="' . $bgcolor . '"><TD WIDTH=95%>' . $questName . '</TD>';
				if($player->getStorage($storageID) === null)
				{
					$main_content .= '<TD><img src="images/false.png"/></TD></TR>';
				}
				else
				{
					$main_content .= '<TD><img src="images/true.png"/></TD></TR>';
				}
			}
			$main_content .= '</TABLE></td></tr></table><br />';
		}

		$deads = 0;


		//deaths list
		$player_deaths = new DatabaseList('PlayerDeath');
		$player_deaths->setFilter(new SQL_Filter(new SQL_Filter(new SQL_Field('player_id'), SQL_Filter::EQUAL, $player->getId()), SQL_Filter::CRITERIUM_AND,new SQL_Filter(new SQL_Field('id', 'players'), SQL_Filter::EQUAL, new SQL_Field('player_id', 'player_deaths'))));
		$player_deaths->addOrder(new SQL_Order(new SQL_Field('time'), SQL_Order::DESC));
		$player_deaths->setLimit(5);

		foreach($player_deaths as $death)
		{
			$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
			$deads++;
			$dead_add_content .= "<tr bgcolor=\"".$bgcolor."\"><td width=\"20%\" align=\"center\">".date("j M Y, H:i", $death->getTime())."</td><td>Died at level " . $death->getLevel() . " by " . $death->getKillerString();
			if($death->getMostDamageString() != '' && $death->getKillerString() != $death->getMostDamageString())
				$dead_add_content .= ' and ' . $death->getMostDamageString();
			$dead_add_content .= "</td></tr>";
		}

		if($deads > 0)
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD COLSPAN=2 CLASS=white><B>Character Deaths</B></TD></TR>' . $dead_add_content . '</TABLE><br />';

		if(!$player->getHideChar())
		{
			$main_content .= '<TABLE BORDER=0><TR><TD></TD></TR></TABLE><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD COLSPAN=2 CLASS=white><B>Account Information</B></TD></TR>';
			if($account->getRLName())
			{
				$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
				$main_content .= '<TR BGCOLOR="' . $bgcolor . '"><TD WIDTH=20%>Real name:</TD><TD>' . $account->getRLName() . '</TD></TR>';
			}
			if($account->getLocation())
			{
				$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
				$main_content .= '<TR BGCOLOR="' . $bgcolor . '"><TD WIDTH=20%>Location:</TD><TD>' . $account->getLocation() . '</TD></TR>';
			}
			$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
			if($account->getCreateDate())
			{
				$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
				$main_content .= '<TR BGCOLOR="' . $bgcolor . '"><TD WIDTH=20%>Created:</TD><TD>' . date("j F Y, g:i a", $account->getCreateDate()) . '</TD></TR>';
			}
			$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);

			if($account->isBanned())
			{
				if($account->getBanTime() > 0)
					$main_content .= '<font color="red"> [Banished until '.date("j F Y, G:i", $account->getBanTime()).']</font>';
				else
					$main_content .= '<font color="red"> [Banished FOREVER]</font>';
			}
			$main_content .= '</TD></TR></TABLE>';
			$main_content .= '<br><TABLE BORDER=0><TR><TD></TD></TR></TABLE><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD COLSPAN=5 CLASS=white><B>Characters</B></TD></TR>
			<TR BGCOLOR="' . $bgcolor . '"><TD><B>Name</B></TD><TD><B>Level</B></TD><TD><b>Status</b></TD><TD><B>&#160;</B></TD></TR>';
			$account_players = $account->getPlayersList();
			$player_number = 0;
			foreach($account_players as $player_list)
			{
				if(!$player_list->getHideChar())
				{
					$player_number++;
					$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
					if(!$player_list->isOnline())
						$player_list_status = '<font color="red">Offline</font>';
					else
						$player_list_status = '<font color="green">Online</font>';
					$main_content .= '<TR BGCOLOR="' . $bgcolor . '"><TD WIDTH=52%><NOBR>'.$player_number.'.&#160;'.htmlspecialchars($player_list->getName());
					$main_content .= ($player_list->isDeleted()) ? '<font color="red"> [DELETED]</font>' : '';
					$main_content .= '</NOBR></TD><TD WIDTH=25%>'.$player_list->getLevel().' '.htmlspecialchars($vocation_name[$player_list->getVocation()]).'</TD><TD WIDTH="8%"><b>'.$player_list_status.'</b></TD><TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=characters" METHOD=post><TR><TD><INPUT TYPE="hidden" NAME="name" VALUE="'.htmlspecialchars($player_list->getName()).'"><INPUT TYPE=image NAME="View '.htmlspecialchars($player_list->getName()).'" ALT="View '.htmlspecialchars($player_list->getName()).'" SRC="'.$layout_name.'/images/buttons/sbutton_view.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></TD></TR>';
				}
			}
			$main_content .= '</TABLE></TD><TD><IMG SRC="'.$layout_name.'/images/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD></TR></TABLE>';
		}
	}
	else
		$search_errors[] = 'Character <b>'.htmlspecialchars($name).'</b> does not exist.';	
}
if(!empty($search_errors))
{
	$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
	foreach($search_errors as $search_error)
		$main_content .= '<li>'.$search_error;
	$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
}
$main_content .= '<div class="BoxContent" style="background-image:url(./layouts/tibiacom/images/content/scroll.gif);min-height:100px;"> <div class="TableContainer"> <div class="CaptionContainer"> <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiacom/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiacom/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiacom/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiacom/images/content/box-frame-vertical.gif);"></span> <div class="Text">Search Character</div> <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiacom/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiacom/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiacom/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiacom/images/content/box-frame-edge.gif);"></span> </div> </div><table class="Table4" cellpadding="0" cellspacing="0"> <tbody><tr> <td> <div class="InnerTableContainer"> <table style="width:100%;"> <tbody><tr> <td> <div class="TableShadowContainerRightTop"> <div class="TableShadowRightTop" style="background-image:url(./layouts/tibiacom/images/content/table-shadow-rt.gif);"></div> </div> <div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiacom/images/content/table-shadow-rm.gif);"> <div class="TableContentContainer"> <table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;"> <tbody> <form action="?subtopic=characters" method="post"> <tr><td bgcolor="#D4C0A1"><table border="0" cellpadding="1"><tbody><tr><td><b>Name:</b></td> <td><input name="name" value="" size="29" maxlength="29"></td><td><input type="image" name="Submit" src="./layouts/tibiacom/images/buttons/sbutton_submit.gif" border="0" width="120" height="18"></form></td></tr></tbody></table></td></tr> </tbody></table> </div> </div> <div class="TableShadowContainer"> <div class="TableBottomShadow" style="background-image:url(./layouts/tibiacom/images/content/table-shadow-bm.gif);"> <div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiacom/images/content/table-shadow-bl.gif);"></div> <div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiacom/images/content/table-shadow-br.gif);"></div> </div> </div> </td> </tr> </tbody></table> </div> </td></tr></tbody></table> </div></div>';
$main_content .= '</TABLE>';
