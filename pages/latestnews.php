<?php

$main_content .= '
<div class="InnerTableContainer">
	<script>
var end = new Date("07/07/2017 09:00 PM");

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById("countdown").innerHTML = "EXPIRED!";

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        document.getElementById("countdown").innerHTML = days + "days ";
        document.getElementById("countdown").innerHTML += hours + "hrs ";
        document.getElementById("countdown").innerHTML += minutes + "mins ";
        document.getElementById("countdown").innerHTML += seconds + "secs";
    }

    timer = setInterval(showRemaining, 1000);
</script>
	
	<table>
		<tbody>
			<tr>
				<td>
					<div class="TableShadowContainerRightTop">
						<div class="TableShadowRightTop" style="background-image: url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
					</div>
						<div class="TableContentAndRightShadow" style="background-image: url('.$layout_name.'/images/content/table-shadow-rm.gif);">
							<div class="TableContentContainer">
								<table class="TableContent" style="border: 1px solid #faf0d7;">
									<tbody>
										<tr style="background-color: #505050;">
										</tr>
											<tr class="Table" style="background-color: #d4c0a1;">
												<td style="width: 800; border: 1px; border-style: solid; border-color: #FAF0D7;">
													<div class="NewsHeadline">
														<div class="NewsHeadlineBackground" style="background-image:url(' . $layout_name . '/images/news/newsheadline_background.gif)">
															<table border="0">
																<tr>
																	<td style="text-align: center; font-weight: bold;">
																		<font color="white">Most powerful guilds</font>
																	</td>
																</tr>
															</table>
														</div>
													</div>
													
												<table border="0" cellspacing="3" cellpadding="4" width="100%">
											<tr>';
												foreach($SQL->query('SELECT `g`.`id` AS `id`, `g`.`name` AS `name`, COUNT(`g`.`name`) as `frags` FROM `players` p LEFT JOIN `player_deaths` pd ON `pd`.`killed_by` = `p`.`name` LEFT JOIN `guild_membership` gm ON `p`.`id` = `gm`.`player_id` LEFT JOIN `guilds` g ON `gm`.`guild_id` = `g`.`id` WHERE `g`.`id` > 0 AND `pd`.`unjustified` = 1 GROUP BY `name` ORDER BY `frags` DESC, `name` ASC LIMIT 4;') as $guild)
												$main_content .= '              
													<td style="width: 25%; text-align: center;">
														<a href="?subtopic=guilds&action=view&GuildName=' . $guild['name'] . '"><img src="/guild_image.php?id=' . $guild['id'] . '" width="64" height="64" border="0"/><br />' . $guild['name'] . '</a><br />' . $guild['frags'] . ' kills
													</td>';
												$main_content .= '
																			</tr>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											<div class="TableShadowContainer">
										<div class="TableBottomShadow" style="background-image: url('.$layout_name.'/images/content/table-shadow-bm.gif);">
									<div class="TableBottomLeftShadow" style="background-image: url('.$layout_name.'/images/content/table-shadow-bl.gif);"></div>
								<div class="TableBottomRightShadow" style="background-image: url('.$layout_name.'/images/content/table-shadow-br.gif);"></div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<br />';
if(!defined('INITIALIZED'))
	exit;

$tickerSql = $SQL->query("SELECT ");
//NEWSTICKER
$time = time();
$vTick = $SQL->query("SELECT " .$SQL->fieldName('date'). " FROM " .$SQL->tableName('z_news_tickers'). " WHERE " .$SQL->fieldName('hide_ticker'). " = '0'")->fetch();
if(isset($vTick['date'])){
$news_content .= '
	<div id="NewsTicker" class="Box">
    	<div class="Corner-tl" style="background-image: url('.$layout_name.'/images/content/corner-tl.gif);"></div>
    	<div class="Corner-tr" style="background-image: url('.$layout_name.'/images/content/corner-tr.gif);"></div>
    	<div class="Border_1" style="background-image: url('.$layout_name.'/images/content/border-1.gif);"></div>
    	<div class="BorderTitleText" style="background-image: url('.$layout_name.'/images/content/title-background-green.gif);"></div>
    	<img class="Title" src="'.$layout_name.'/images/header/headline-newsticker.gif" alt="Contentbox headline" />
    		<div class="Border_2">
      			<div class="Border_3">
        			<div class="BoxContent" style="background-image: url('.$layout_name.'/images/content/scroll.gif);">';
					//##################### ADD NEW TICKER #####################
					if($action == "newticker") {
						if($group_id_of_acc_logged >= $config['site']['access_tickers']) {
							$ticker_text = stripslashes(trim($_POST['new_ticker']));
							$ticker_icon = (int) $_POST['icon_id'];
							if(empty($ticker_text)) {
								$news_content .= 'You can\'t add empty ticker.';
							}
							else
							{
							if(empty($ticker_icon)) {
								$news_icon = 0;
							}
					$SQL->query('INSERT INTO '.$SQL->tableName('z_news_tickers').' (date, author, image_id, text, hide_ticker) VALUES ('.$SQL->quote($time).', '.$account_logged->getId().', '.$ticker_icon.', '.$SQL->quote($ticker_text).', 0)');
					$news_content .= '
						<center>
							<h2>
								<font color="red">Added new ticker:</font>
							</h2>
						</center>
						<hr/>
						<div id="newsticker" class="Box">
							<div id="TickerEntry-1" class="Row" onclick=\'TickerAction("TickerEntry-1")\'>
  								<div class="Odd">
    								<div class="NewsTickerIcon" style="background-image: url('.$layout_name.'/images/news/icon_'.$ticker['image_id'].'.gif);"></div>
    								<div id="TickerEntry-1-Button" class="NewsTickerExtend" style="background-image: url('.$layout_name.'/images/general/plus.gif);"></div>
    								<div class="NewsTickerText">
      										<span class="NewsTickerDate">'.date("d/m/Y", $time).' -</span> 
      										<div id="TickerEntry-1-ShortText" class="NewsTickerShortText">';
					$news_content .= '
						<a href="?subtopic=latestnews&action=deleteticker&id='.$time.'">
							<img src="'.$layout_name.'/images/news/delete.png" border="0">
						</a>';
					$news_content .= short_text($ticker_text, 60).'</div>
      					<div id="TickerEntry-1-FullText" class="NewsTickerFullText">';
					$news_content .= '<a href="?subtopic=latestnews&action=deleteticker&id='.$time.'"><img src="'.$layout_name.'/images/news/delete.png" border="0"></a>';
					$news_content .= $ticker_text.'
						</div>
    				</div>
  				</div>
			</div>
		</div>
	<hr/>';
	}
}
else
{
	$news_content .= 'You don\'t have admin rights. You can\'t add new ticker.';
}
	$news_content .= '<form action="?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
}
//#################### DELETE (HIDE only!) TICKER ############################
if($action == "deleteticker") {
if($group_id_of_acc_logged >= $config['site']['access_tickers']) {
header("Location: ");
$date = (int) $_REQUEST['id'];
$SQL->query('UPDATE '.$SQL->tableName('z_news_tickers').' SET hide_ticker = 1 WHERE '.$SQL->fieldName('date').' = '.$date.';');
$news_content .= '<center>News tickets with <b>date '.date("j F Y, g:i a", $date).'</b> has been deleted.<form action="?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center></div></div>
    </div>
    <div class="Border_1" style="background-image: url('.$layout_name.'/images/content/border-1.gif);"></div>
    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image: url('.$layout_name.'/images/content/corner-bl.gif);"></div></div>
    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image: url('.$layout_name.'/images/content/corner-br.gif);"></div></div>
  </div>';
}
else
{
$news_content .= '<center>You don\'t have admin rights. You can\'t delete tickers.<form action="?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
}
//show tickers if any in database or not blocked (tickers limit = 0)
$tickers = $SQL->query('SELECT * FROM `z_news_tickers` WHERE hide_ticker != 1 ORDER BY date DESC LIMIT 5;');
$number_of_tickers = 3;
if(is_object($tickers)) {
foreach($tickers as $ticker) {
if(is_int($number_of_tickers / 2))
        $color = "Odd";
else
        $color = "Even";
$tickers_to_add .= '<div id="TickerEntry-'.$number_of_tickers.'" class="Row" onclick=\'TickerAction("TickerEntry-'.$number_of_tickers.'")\'>
  <div class="'.$color.'">
    <div class="NewsTickerIcon" style="background-image: url('.$layout_name.'/images/news/icon_'.$ticker['image_id'].'.gif);"></div>
    <div id="TickerEntry-'.$number_of_tickers.'-Button" class="NewsTickerExtend" style="background-image: url('.$layout_name.'/images/general/plus.gif);"></div>
    <div class="NewsTickerText">
      <span class="NewsTickerDate">'.date("j M Y", $ticker['date']).' - </span>
      <div id="TickerEntry-'.$number_of_tickers.'-ShortText" class="NewsTickerShortText">';
//if admin show button to delete (hide) ticker
if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
$tickers_to_add .= '<a href="?subtopic=latestnews&action=deleteticker&id='.$ticker['date'].'"><img src="'.$layout_name.'/images/news/delete.png" border="0"></a>';
}
$tickers_to_add .= short_text($ticker['text'], 60).'</div>
      <div id="TickerEntry-'.$number_of_tickers.'-FullText" class="NewsTickerFullText">';
//if admin show button to delete (hide) ticker
if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
$tickers_to_add .= '<a href="?subtopic=latestnews&action=deleteticker&id='.$ticker['date'].'"><img src="'.$layout_name.'/images/news/delete.png" border="0"></a>';
}
$tickers_to_add .= $ticker['text'].'</div>
    </div>
  </div>
</div>';
$number_of_tickers++;
}
}
}

//adding news
if($action == "newnews") {
if($group_id_of_acc_logged >= $config['site']['access_news']) {
$text = ($_REQUEST['text']);
$char_id = (int) $_REQUEST['char_id'];
$post_topic = stripslashes(trim($_REQUEST['topic']));
$smile = (int) $_REQUEST['smile'];
$news_icon = (int) $_REQUEST['icon_id'];
if(empty($news_icon)) {
$news_icon = 0;
}
if(empty($post_topic)) {
$an_errors[] .= 'You can\'t add news without topic.';
}
if(empty($text)) {
$an_errors[] .= 'You can\'t add empty news.';
}
if(empty($char_id)) {
$an_errors[] .= 'Select character.';
}
//execute query
if(empty($an_errors)) {
$SQL->query("INSERT INTO `z_forum` (`id` ,`first_post` ,`last_post` ,`section` ,`replies` ,`views` ,`author_aid` ,`author_guid` ,`post_text` ,`post_topic` ,`post_smile` ,`post_date` ,`last_edit_aid` ,`edit_date`, `post_ip`, `icon_id`) VALUES ('NULL', '0', '".time()."', '1', '0', '0', '".$account_logged->getId()."', '".(int) $char_id."', ".$SQL->quote($text).", ".$SQL->quote($post_topic).", '".(int) $smile."', '".time()."', '0', '0', '".$_SERVER['REMOTE_ADDR']."', '".$news_icon."')");
$thread_id = $SQL->lastInsertId();
$SQL->query("UPDATE `z_forum` SET `first_post`=".(int) $thread_id." WHERE `id` = ".(int) $thread_id);//show added data
$main_content .= '<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
}
else
{
//show errors
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($an_errors as $an_error) {
	$main_content .= '<li>'.$an_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
//okno edycji newsa z wpisanymi danymi przeslanymi wczesniej
$main_content .= '<form action="index.php?subtopic=latestnews&action=newnews" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="'.$layout_name.'/images/news/icon_0.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_1.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_2.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_3.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Topic:</b></td><td><input type="text" name="topic" maxlenght="50" style="width: 300px" value="'.$post_topic.'"></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>News<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="text" rows="6" cols="60">'.$text.'</textarea></td></tr><tr><td width="180"><b>Character:</b></td><td><select name="char_id"><option value="0">(Choose character)</option>'.$str.'</select></td></tr><tr><td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="location.href=\'index.php?subtopic=latestnews\';" alt="CancelAddNews" /></div></div></td></tr></table>';
}
}
else
{
$main_content .= 'You don\'t have site-admin rights. You can\'t add news.';}
}

if(!empty($tickers_to_add)) {
//show table with tickers

if($group_id_of_acc_logged >= $config['site']['access_admin_panel'] && $action!=newticker)
$news_content .= '<script type="text/javascript">
var showednewticker_state = "0";
function showNewTickerForm()
{
if(showednewticker_state == "0") {
document.getElementById("newtickerform").innerHTML = \'<form action="?subtopic=latestnews&action=newticker" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>New<br>ticker<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="new_ticker" rows="3" cols="45"></textarea></td></tr><tr><td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddTicker" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="showNewTickerForm()" alt="AddTicker" /></div></div></td></tr></table>\';
document.getElementById("jajo").innerHTML = \'\';
showednewticker_state = "1";
}
else {
document.getElementById("newtickerform").innerHTML = \'\';
document.getElementById("jajo").innerHTML = \'<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddTicker" src="'.$layout_name.'/images/buttons/addticker.gif" onClick="showNewTickerForm()" alt="AddTicker" /></div></div>\';
showednewticker_state = "0";
}
}
</script><div id="newtickerform"></div><div id="jajo"><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddTicker" src="'.$layout_name.'/images/buttons/addticker.gif" onClick="showNewTickerForm()" alt="AddTicker" /></div></div></div><hr/>';
//add tickers list
$news_content .= $tickers_to_add;
//koniec
$news_content .= '</div>
      </div>
    </div>
    <div class="Border_1" style="background-image: url('.$layout_name.'/images/content/border-1.gif);"></div>
    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image: url('.$layout_name.'/images/content/corner-bl.gif);"></div></div>
    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image: url('.$layout_name.'/images/content/corner-br.gif);"></div></div>
  </div>';
}
//NEWSTICKER END

//featured article
//sem creditos do autor, apenas postado por Dhenyz Shady no X-tibia.
///Queries ///
$query = $SQL->query('SELECT `name`,`id`,`level`,`experience`,`group_id` FROM `players` WHERE `group_id` < 2 ORDER BY `level` DESC LIMIT 1;')->fetch(); 
$query2 = $SQL->query('SELECT `id`, `name` FROM `players` ORDER BY `id` DESC LIMIT 1;')->fetch();
$housesfree = $SQL->query('SELECT COUNT(*) FROM `houses` WHERE `owner`=0;')->fetch();
$housesrented = $SQL->query('SELECT COUNT(*) FROM `houses` WHERE `owner`=1;')->fetch();
$players = $SQL->query('SELECT COUNT(*) FROM `players` WHERE `id`>0;')->fetch();
$accounts = $SQL->query('SELECT COUNT(*) FROM `accounts` WHERE `id`>0;')->fetch();
$banned = $SQL->query('SELECT COUNT(*) FROM `account_bans` WHERE `account_id`>0;')->fetch();
$guilds = $SQL->query('SELECT COUNT(*) FROM `guilds` WHERE `id`>0;')->fetch();

///End Queries ///
$news_content .= '
    <div id="FeaturedArticle" class="Box">
					<div class="Corner-tl" style="background-image:url(./layouts/tibiacom/images/content/corner-tl.gif);"></div>
					<div class="Corner-tr" style="background-image:url(./layouts/tibiacom/images/content/corner-tr.gif);"></div>
					<div class="Border_1" style="background-image:url(./layouts/tibiacom/images/content/border-1.gif);"></div>
					<div class="BorderTitleText" style="background-image:url(./layouts/tibiacom/images/content/title-background-green.gif);"></div>
					<img id="ContentBoxHeadline" class="Title" src="./layouts/tibiacom/images/header/headline-featuredarticle.gif" alt="Contentbox headline" />
					<div class="Border_2">
						<div class="Border_3">
							<div class="BoxContent" style="background-image:url(./layouts/tibiacom/images/content/scroll.gif);">
								<div id="TeaserThumbnail">
									<a href="index.php?subtopic=createaccount">
										<img src="/images/featuredthumb_3720.jpg" width="150" height="100" border=0 alt="" />
									</a>
								</div>
								
								<div id="TeaserText">
								<div style="position: relative; top: -9px; margin-bottom: 10px;"></br>
								<b><font size="5px"><center><b><font style="text-decoration: inherit; text-shadow:#000 1px -1px 2px, #000 -1px 1px 2px, #000 1px 1px 2px, #000 -1px -1px 2px" size="1px" color="white">| IP: <font color="#00FF00">seu-global.com</font> / Port: <font color="#00FF00">7171</font> / Client: <font color="#00FF00">10 ~ 11.0</font> / Client Proprio: </font><font size="2px"><a href="?subtopic=downloads">DOWNLOAD</a></b></font></center><br></b><font size="2px">Seja bem vindo ao <b><font color="green">seu-global.com</font></b>, servidor feito especialmente para jogadores que gostam de um bom servidor. Oferecemos: <b>Prey System</b>, <b>Imbuing System</b>, quests, outfits, ORAMOND FULL, <b>Anti-entrosa system</b>, eventos e miss&otilde;es tudo para proporcionar a voces jogadores uma gameplay mais envolvente.<br><br><br><br>	
     
	 
									</div>
								</div>        
							<fieldset><legend><font face=tahoma>Curta nossa FanPage Oficial!</font></legend>
<div class="fb-like" data-href="https://www.facebook.com/nareviaMMORPG" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
							
							
							</div>


						
						
						</div>
					

					
					
					</div>					
					<div class="Border_1" style="background-image:url(./layouts/tibiacom/images/content/border-1.gif);"></div>
					<div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url(./layouts/tibiacom/images/content/corner-bl.gif);"></div></div>
					<div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url(./layouts/tibiacom/images/content/corner-br.gif);"></div></div>
	</div>

';
//Fim do featured Article
		
function replaceSmile($text, $smile)
{
    $smileys = array(
						':p' => 1, 
						':eek:' => 2, 
						':rolleyes:' => 3, 
						';)' => 4, 
						':o' => 5, 
						':D' => 6,  
						':(' => 7, 
						':mad:' => 8,
						':)' => 9,
						':cool:' => 10
					);
    if($smile == 1)
        return $text;
    else
    {
        foreach($smileys as $search => $replace)
            $text = str_replace($search, '<img src="layouts/tibiarl/images/forum/smile/'.$replace.'.gif" />', $text);
        return $text;
    }
}

function replaceAll($text, $smile)
{
    $rows = 0;
    while(stripos($text, '[code]') !== false && stripos($text, '[/code]') !== false )
    {
        $code = substr($text, stripos($text, '[code]')+6, stripos($text, '[/code]') - stripos($text, '[code]') - 6);
        if(!is_int($rows / 2)) { $bgcolor = 'ABED25'; } else { $bgcolor = '23ED25'; } $rows++;
        $text = str_ireplace('[code]'.$code.'[/code]', '<i>Code:</i><br /><table cellpadding="0" style="background-color: #'.$bgcolor.'; width: 480px; border-style: dotted; border-color: #CCCCCC; border-width: 2px"><tr><td>'.$code.'</td></tr></table>', $text);
    }
    $rows = 0;
    while(stripos($text, '[quote]') !== false && stripos($text, '[/quote]') !== false )
    {
        $quote = substr($text, stripos($text, '[quote]')+7, stripos($text, '[/quote]') - stripos($text, '[quote]') - 7);
        if(!is_int($rows / 2)) { $bgcolor = 'AAAAAA'; } else { $bgcolor = 'CCCCCC'; } $rows++;
        $text = str_ireplace('[quote]'.$quote.'[/quote]', '<table cellpadding="0" style="background-color: #'.$bgcolor.'; width: 480px; border-style: dotted; border-color: #007900; border-width: 2px"><tr><td>'.$quote.'</td></tr></table>', $text);
    }
    $rows = 0;
    while(stripos($text, '[url]') !== false && stripos($text, '[/url]') !== false )
    {
        $url = substr($text, stripos($text, '[url]')+5, stripos($text, '[/url]') - stripos($text, '[url]') - 5);
        $text = str_ireplace('[url]'.$url.'[/url]', '<a href="'.$url.'" target="_blank">'.$url.'</a>', $text);
    }
    while(stripos($text, '[player]') !== false && stripos($text, '[/player]') !== false )
    {
        $player = substr($text, stripos($text, '[player]')+8, stripos($text, '[/player]') - stripos($text, '[player]') - 8);
        $text = str_ireplace('[player]'.$player.'[/player]', '<a href="?subtopic=&name='.urlencode($player).'">'.$player.'</a>', $text);
    }
	 while(stripos($text, '[letter]') !== false && stripos($text, '[/letter]') !== false )
    {
        $letter = substr($text, stripos($text, '[letter]')+8, stripos($text, '[/letter]') - stripos($text, '[letter]') - 8);
        $text = str_ireplace('[letter]'.$letter.'[/letter]', '<img src="images/letters/letter_martel_'.$letter.'.gif">', $text);
    }
    while(stripos($text, '[img]') !== false && stripos($text, '[/img]') !== false )
    {
        $img = substr($text, stripos($text, '[img]')+5, stripos($text, '[/img]') - stripos($text, '[img]') - 5);
        $text = str_ireplace('[img]'.$img.'[/img]', '<img src="'.$img.'">', $text);
    }
    while(stripos($text, '[b]') !== false && stripos($text, '[/b]') !== false )
    {
        $b = substr($text, stripos($text, '[b]')+3, stripos($text, '[/b]') - stripos($text, '[b]') - 3);
        $text = str_ireplace('[b]'.$b.'[/b]', '<b>'.$b.'</b>', $text);
    }
    while(stripos($text, '[i]') !== false && stripos($text, '[/i]') !== false )
    {
        $i = substr($text, stripos($text, '[i]')+3, stripos($text, '[/i]') - stripos($text, '[i]') - 3);
        $text = str_ireplace('[i]'.$i.'[/i]', '<i>'.$i.'</i>', $text);
    }
    while(stripos($text, '[u]') !== false && stripos($text, '[/u]') !== false )
    {
        $u = substr($text, stripos($text, '[u]')+3, stripos($text, '[/u]') - stripos($text, '[u]') - 3);
        $text = str_ireplace('[u]'.$u.'[/u]', '<u>'.$u.'</u>', $text);
    }
    return replaceSmile($text, $smile);
}

function showPost($topic, $text, $smile)
{
    $text = nl2br($text);
    $post = '';
    if(!empty($topic))
        $post .= '<b>'.replaceSmile($topic, $smile).'</b>';
    $post .= replaceAll($text, $smile);
    return $post;
}

if($group_id_of_acc_logged >= $config['site']['access_admin_panel'] && $action != 'newnews')
	{
		$main_content .= '
			<font style="font-size: 16px; font-weight: bold; margin-left: 20px;">Adding News</font>
			<form action="index.php?subtopic=latestnews&action=newnews" method="post" >
				<table border="0">
					<tr>
						<td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td>
						<td>
							<table border="0">
								<tr bgcolor="F1E0C6">
									<td><img src="'.$layout_name.'/images/news/icon_0.gif" width="20"></td>
									<td><img src="'.$layout_name.'/images/news/icon_1.gif" width="20"></td>
									<td><img src="'.$layout_name.'/images/news/icon_2.gif" width="20"></td>
									<td><img src="'.$layout_name.'/images/news/icon_3.gif" width="20"></td>
									<td><img src="'.$layout_name.'/images/news/icon_4.gif" width="20"></td>
								</tr>
								<tr bgcolor="D4C0A1">
									<td><input type="radio" name="icon_id" value="0" checked="checked"></td>
									<td><input type="radio" name="icon_id" value="1" /></td>
									<td><input type="radio" name="icon_id" value="2" /></td>
									<td><input type="radio" name="icon_id" value="3" /></td>
									<td><input type="radio" name="icon_id" value="4" /></td>
								</tr>
							</table>
						</td>
					</tr>
				<tr>
					<td align="center" bgcolor="F1E0C6"><b>Topic:</b></td>
					<td><input type="text" name="topic" maxlenght="50" style="width: 300px" ></td>
				</tr>
				<tr>
					<td align="center" bgcolor="D4C0A1"><b>News<br>text:</b></td>';
				//Tiny Editor
				$main_content .= '
					<script type="text/javascript" src="'.$layout_name.'/tiny_mce/tiny_mce.js"></script>
					<script type="text/javascript">
						tinyMCE.init({
							// General options
							mode : "textareas",
							theme : "advanced",
							plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
					
							// Theme options
							theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
							theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
							theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl",
							theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							theme_advanced_resizing : true,
					
							// Example content CSS (should be your site CSS)
							content_css : "css/content.css",
					
							// Drop lists for link/image/media/template dialogs
							template_external_list_url : "lists/template_list.js",
							external_link_list_url : "lists/link_list.js",
							external_image_list_url : "lists/image_list.js",
							media_external_list_url : "lists/media_list.js",
					
							// Style formats
							style_formats : [
								{title : \'Bold text\', inline : \'b\'},
								{title : \'Red text\', inline : \'span\', styles : {color : \'#ff0000\'}},
								{title : \'Red header\', block : \'h1\', styles : {color : \'#ff0000\'}},
								{title : \'Example 1\', inline : \'span\', classes : \'example1\'},
								{title : \'Example 2\', inline : \'span\', classes : \'example2\'},
								{title : \'Table styles\'},
								{title : \'Table row 1\', selector : \'tr\', classes : \'tablerow1\'}
							],
					
							// Replace values for the template plugin
							template_replace_values : {
								username : "Some User",
								staffid : "991234"
							}
						});
					</script>';
				$main_content .= '
					<td bgcolor="F1E0C6">
						<textarea name="text" id="elm1" rows="6" cols="60"></textarea>
					</td>
				</tr>
				<tr>
					<td width="180"><b>Character:</b></td>
					<td>
						<select name="char_id">
						   <option value="0">(Choose character)</option>';
							foreach($account_logged->getPlayers() as $player)
							{
							 $main_content .= '<option value="'.$player->getID().'">'.$player->getName().'</option>';
							}       
							$main_content .= '       
						  </select>
					</td>
				</tr>
				<tr>
					<td>
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div>
						<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" >
					</div>
				</div>
			</form>
		</td>
	</tr>
</table>
<hr/>';
}


    $last_threads = $SQL->query('SELECT ' . $SQL->tableName('players') . '.' . $SQL->fieldName('name') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('post_text') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('post_topic') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('icon_id') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('post_smile') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('id') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('replies') . ', ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('post_date') . ' FROM ' . $SQL->tableName('players') . ', ' . $SQL->tableName('z_forum') . ' WHERE ' . $SQL->tableName('players') . '.' . $SQL->fieldName('id') . ' = ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('author_guid') . ' AND ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('section') . ' = 1 AND ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('first_post') . ' = ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('id') . ' ORDER BY ' . $SQL->tableName('z_forum') . '.' . $SQL->fieldName('last_post') . ' DESC LIMIT ' . $config['site']['news_limit'])->fetchAll();
	
	//Here start news
    if(isset($last_threads[0]))
    {
        foreach($last_threads as $thread)
        {
            $main_content .= '
				<div class="NewsHeadline">
					<div class="NewsHeadlineBackground" style="background-image:url('.$layout_name.'/images/news/newsheadline_background.gif)">
					 	<img id="ContentBoxHeadline" class="Title" src="./layouts/tibiacom/images/header/headline-news23.gif" alt="Contentbox headline" />
					</div>
				</div>
				<table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
				<tr>';
            $main_content .= '
				<td style=\'padding-left:10px;padding-right:10px;\' >' . showPost('', $thread['post_text'], $thread['post_smile']) . '<p align="right"><a href="https://www.facebook.com/nareviaMMORPG/">->Veja em nossa Pagina.</a></p></td>';
        
			$main_content .= '
				<td>
					
				</td>
			</tr>
		</table><br />';
		}
    }
    else
        $main_content .= '<h3>No news. :( </h3>';