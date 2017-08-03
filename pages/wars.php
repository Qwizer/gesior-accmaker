<?php
if(!defined('INITIALIZED'))
	exit;
			/*
		$main_content .= '
			<div class="TableContainer" >
				<table class="Table5" cellpadding="0" cellspacing="0" >
					<div class="CaptionContainer" >
						<div class="CaptionInnerContainer" > 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
							<div class="Text" >Declarations of War</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						</div>
					</div>
					<tr>
						<td><div class="InnerTableContainer" >
								<table style="width:100%;" >
									<tr>
										<td>The guild Lino Lucky has currently no open war declarations.</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<br/>';
			*/
			$main_content .= "<script type=\"text/javascript\"><!--
		function show_hide(flip)
		{
				var tmp = document.getElementById(flip);
				if(tmp)
						tmp.style.display = tmp.style.display == 'none' ? '' : 'none';
		}
		--></script>";
	$main_content .= '
		<div class="TableContainer" >
			<table class="Table5" cellpadding="0" cellspacing="0" >
				<div class="CaptionContainer" >
					<div class="CaptionInnerContainer" > 
						<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
						<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
						<div class="Text" >Guild Wars</div>
						<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
						<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
						<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
					</div>
				</div>
				<tr>
					<td>
						<div class="InnerTableContainer" >
							<table style="width:100%;" >';
							$main_content .= '
								<tr>
									<td>
										<div class="TableShadowContainerRightTop" >
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
												<div class="TableContentContainer" >
													<table class="TableContent" width="100%" >
														<tr class="LabelV">
															<td>Aggressor</td>
															<td>Information</td>
															<td>Enemy</td>
														</tr>';
														$warFrags = array();
														foreach($SQL->query('SELECT * FROM `guildwar_kills` ORDER BY `time` DESC')->fetchAll() as $frag)
														{
															$warFrags[$frag['warid']][] = $frag;
														}
												
														$count = 0;
														foreach($SQL->query('SELECT `guild_wars`.`id`, `guild_wars`.`guild1`, `guild_wars`.`guild2`, `guild_wars`.`name1`, `guild_wars`.`name2`, `guild_wars`.`status`, `guild_wars`.`started`, `guild_wars`.`ended`, (SELECT COUNT(1) FROM `guildwar_kills` WHERE `guildwar_kills`.`warid` = `guild_wars`.`id` AND `guildwar_kills`.`killerguild` = `guild_wars`.`guild1`) guild1_kills, (SELECT COUNT(1) FROM `guildwar_kills` WHERE `guildwar_kills`.`warid` = `guild_wars`.`id` AND `guildwar_kills`.`killerguild` = `guild_wars`.`guild2`) guild2_kills FROM `guild_wars` ORDER BY `started` DESC') as $war)
														{
															$count++;
															$main_content .= "<tr style=\"background: " . (is_int($count / 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
														<td align=\"center\"><a href=\"?subtopic=guilds&action=view&GuildName=".$war['name1']."\"><img src=\"guild_image.php?id=" . $war['guild1'] . "\" width=\"64\" height=\"64\" border=\"0\"/><br />".htmlspecialchars($war['name1'])."</a></td>
														<td align=\"center\">";
															switch($war['status'])
															{
																case 0:
																{
																	$main_content .= "<b>Pending acceptation</b><br />Invited on " . date("M d Y, H:i:s", $war['started']) . " for 2 hours war.<br />";
																	if($guild_leader && $war['guild2'] == $guild->getID())
																	{
																		$main_content .= '<br /><a href="?subtopic=guilds&action=guildwar_accept&GuildName=' . $guild_name . '&war=' . $war['id'] . '" onclick="return confirm(\'Are you sure that you want ACCEPT that invitation for 2 hours war?\');" style="cursor: pointer;">accept invitation to war</a>';
																		$main_content .= '<br /><br /><a href="?subtopic=guilds&action=guildwar_reject&GuildName=' . $guild_name . '&war=' . $war['id'] . '" onclick="return confirm(\'Are you sure that you want REJECT that invitation for 2 hours war?\');" style="cursor: pointer;">reject invitation to war</a>';
																	}
																	if($guild_leader && $war['guild1'] == $guild->getID())
																	{
																		$main_content .= '<br /><br /><a href="?subtopic=guilds&action=guildwar_cancel&GuildName=' . $guild_name . '&war=' . $war['id'] . '" onclick="return confirm(\'Are you sure that you want CANCEL that invitation for 2 hours war?\');" style="cursor: pointer;">cancel invitation to war</a>';
																	}
																	$main_content .= '</font>';
																	break;
																}
																case 1:
																{
																	$main_content .= "<font size=\"12\"><span style=\"color: red;\">" . $war['guild1_kills'] . "</span><font color=black> : </font><span style=\"color: lime;\">" . $war['guild2_kills'] . "</span></font><br /><br /><span style=\"color: darkred; font-weight: bold;\">On a brutal war</span><br /><font color=black>Began on " . date("M d Y, H:i:s", $war['started']) . ", will end up after server restart after " . date("M d Y, H:i:s", $war['started'] + (2*3600)) . ".<br /></font>";
																	$main_content .= "<br /><br />";
																	if(in_array($war['status'], array(1,4)))
																	{
																		$main_content .= "<a onclick=\"show_hide('war-details:" . $war['id'] . "'); return false;\" style=\"cursor: pointer;\">War Details</a>";
																	}
																	break;
																}
																case 2:
																{
																	$main_content .= "<b>Rejected invitation</b><br />Invited on " . date("M d Y, H:i:s", $war['started']) . ", rejected on " . date("M d Y, H:i:s", $war['ended']) . ".</font>";
																	break;
																}
																case 3:
																{
																	$main_content .= "<b>Canceled invitation</b><br />Sent invite on " . date("M d Y, H:i:s", $war['started']) . ", canceled on " . date("M d Y, H:i:s", $war['ended']) . ".</font>";
																	break;
																}
																case 4:
																{
																	$main_content .= "<b><i>Ended</i></b><br />Began on " . date("M d Y, H:i:s", $war['started']) . ", ended on " . date("M d Y, H:i:s", $war['ended']) . ". Frag statistics: <span style=\"color: red;\">" . $war['guild1_kills'] . "</span> to <span style=\"color: lime;\">" . $war['guild2_kills'] . "</span>.";
																	$main_content .= "<br /><br />";
																	if(in_array($war['status'], array(1,4)))
																	{
																		$main_content .= "<a onclick=\"show_hide('war-details:" . $war['id'] . "'); return false;\" style=\"cursor: pointer;\">&raquo; Details &laquo;</a>";
																	}
																	$main_content .= "</font>";
																	break;
																}
																default:
																{
																	$main_content .= "Unknown, please contact with gamemaster.";
																	break;
																}
															}
															$main_content .= "</td>
														<td align=\"center\"><a href=\"?subtopic=guilds&action=view&GuildName=".$war['name2']."\"><img src=\"guild_image.php?id=" . $war['guild2'] . "\" width=\"64\" height=\"64\" border=\"0\"/><br />".htmlspecialchars($war['name2'])."</a></td>
														</tr>
														<tr id=\"war-details:" . $war['id'] . "\" style=\"display: none; background: " . (is_int($count / 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
														<td colspan=\"3\">";
															if(in_array($war['status'], array(1,4)))
															{
																if(isset($warFrags[$war['id']]))
																{
																	foreach($warFrags[$war['id']] as $frag)
																	{
																		$main_content .= date("j M Y, H:i", $frag['time']) . " <span style=\"font-weight: bold; color: " . ($frag['killerguild'] == $war['guild1'] ? "red" :"lime") . ";\">+</span><a href=\"?subtopic=characters&name=" . urlencode($frag['killer']) . "\"><b>".htmlspecialchars($frag['killer'])."</b></a> killed <a href=\"?subtopic=characters&name=".urlencode($frag['target'])."\"> " . htmlspecialchars($frag['target']) . "</a><br>";
																	}
																}
																else
																	$main_content .= "<center>There were no frags on this war so far.</center>";
															}
															else
																$main_content .= "</td></tr>";
														}
												$main_content .= '
													</table>
												</div>
											</div>
										</div>
									</td>
								</tr>';
						if($count == 0)
							$main_content .= "
								<tr>
									<td>The guild ".$guild_name." is currently not involved in a guild war.</td>
								</tr>";
						$main_content .= '
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<br/>';
		/*
	$main_content .= '
		<div class="TableContainer" >
			<table class="Table5" cellpadding="0" cellspacing="0" >
				<div class="CaptionContainer" >
					<div class="CaptionInnerContainer" > 
						<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
						<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
						<div class="Text" >Guild War History</div>
						<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
						<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
						<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
					</div>
				</div>
				<tr>
					<td>
						<div class="InnerTableContainer">
							<table style="width:100%;">
								<tr>
									<td>The guild Lino Lucky has never participated in a guild war.</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<br/>';
		*/
	$main_content .= '
		<center>
			<table border="0" cellspacing="0" cellpadding="0" >
				<form action="?subtopic=guilds&action=view" method="post" >
					<tr>
						<td style="border:0px;" >
							<input type="hidden" name=GuildName value="'.$_REQUEST['GuildName'].'" >
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</td>
					</tr>
				</form>
			</table>
		</center>
		';