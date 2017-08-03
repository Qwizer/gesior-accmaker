<img id="ContentBoxHeadline" class="Title" src="layouts/tibiacom/images/header/headline-whoisonline.gif" alt="Contentbox headline">
<?php
if(!defined('INITIALIZED'))
	exit;

$orderby = 'name';
if(isset($_REQUEST['order']))
{
	if($_REQUEST['order']== 'level')
		$orderby = 'level';
	elseif($_REQUEST['order'] == 'vocation')
		$orderby = 'vocation';
}
$players_online_data = $SQL->query('SELECT ' . $SQL->tableName('accounts') . '.' . $SQL->fieldName('flag') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('name') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('vocation') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('level') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('skull') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('looktype') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookaddons') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookhead') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookbody') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('looklegs') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookfeet') . ' FROM ' . $SQL->tableName('accounts') . ', ' . $SQL->tableName('players') . ', ' . $SQL->tableName('players_online') . ' WHERE ' . $SQL->tableName('players') . '.' . $SQL->fieldName('id') . ' = ' . $SQL->tableName('players_online') . '.' . $SQL->fieldName('player_id') . ' AND ' . $SQL->tableName('accounts') . '.' . $SQL->fieldName('id') . ' = ' . $SQL->tableName('players') . '.' . $SQL->fieldName('account_id') . ' ORDER BY ' . $SQL->fieldName($orderby))->fetchAll();
$number_of_players_online = 0;
$vocations_online_count = array(0,0,0,0,0); // change it if you got more then 5 vocations
$players_rows = '';
foreach($players_online_data as $player)
{
	$vocations_online_count[$player['vocation']] += 1;
	$bgcolor = (($number_of_players_online++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
	$skull = '';
	if ($player['skull'] == 4)
		$skull = "<img style='border: 0;' src='./images/skulls/redskull.gif'/>";
	else if ($player['skull'] == 5)
		$skull = "<img style='border: 0;' src='./images/skulls/blackskull.gif'/>";

	$players_rows .= '<TR BGCOLOR='.$bgcolor.'><TD WIDTH=65%><A HREF="?subtopic=characters&name='.urlencode($player['name']).'">'.htmlspecialchars($player['name']).$skull.'<TD WIDTH=10%>'.$player['level'].'</TD><TD WIDTH=20%>'.htmlspecialchars($vocation_name[$player['vocation']]).'</TD></TR>';
}		
if($number_of_players_online == 0)
{
	//server status - server empty
	$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD CLASS=white><B>Server Status</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1><TR><TD>Currently no one is playing on <b>'.htmlspecialchars($config['server']['serverName']).'</b>.</TD></TR></TABLE></TD></TR></TABLE><BR>';
}
else
{
	//server status - someone is online
	$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD CLASS=white><B>Server Status</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1><TR><TD>Currently '.$number_of_players_online.' players are online on <b>'.htmlspecialchars($config['server']['serverName']).'</b>.</TD></TR></TABLE></TD></TR></TABLE><br>';
	//list of players
	$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD><A HREF="?subtopic=whoisonline&order=name" CLASS=white>Name</A></TD><TD><A HREF="?subtopic=whoisonline&order=level" CLASS=white>Level</A></TD><TD><A HREF="?subtopic=whoisonline&order=vocation" CLASS=white>Vocation</TD></TR>'.$players_rows.'</TABLE>';
	//search bar
	$main_content .= '<BR><FORM ACTION="?subtopic=characters" METHOD=post>  <TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4><TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Search Character</B></TD></TR><TR><TD BGCOLOR="'.$config['site']['darkborder'].'"><TABLE BORDER=0 CELLPADDING=1><TR><TD>Name:</TD><TD><INPUT NAME="name" VALUE="" SIZE="29" MAXLENGTH="29"></TD><TD><INPUT TYPE="image" NAME="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></TABLE></TD></TR></TABLE></FORM>';
}