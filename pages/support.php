<img id="ContentBoxHeadline" class="Title" src="layouts/tibiacom/images/header/cast.png" alt="Contentbox headline">
<?php
	if(!defined('INITIALIZED'))
		exit;
	if($group_id_of_acc_logged < $config['site']['access_admin_panel']) {
		header("location:index.php?subtopic=latestnews");
		return false;
	}
	
	if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
	if (isset($_POST["+"])) {
		mysql_connect('127.0.0.1', 'root','9kVdoTsfuzyEKog7')or die();	//Conecta com o MySQL
		mysql_select_db('CaterNEW');
		$reportID = $_POST["reportid"];
		$charNAME = $_POST["charname"];		
		
		
		$sqlBuscarID = "SELECT account_id FROM players WHERE name = '".$charNAME."'";
		$resultadoId = mysql_query($sqlBuscarID)or die (mysql_error());
		$row = mysql_fetch_assoc($resultadoId);
		$accountID = $row["account_id"];
		 
		$SQL->query('UPDATE accounts SET coins = coins + 25 WHERE id = '.$accountID.'');
		$SQL->query('UPDATE support SET status = "RESOLVIDO" WHERE id = '.$reportID.'');
		
		echo "<center><h2>O report #".$reportID." foi marcado como resolvido e foi dado uma recompensa ao jogador!<h2></center>";

	} 
	if (isset($_POST["-"])) {
		$reportID = $_POST["reportid"];
		$SQL->query('UPDATE support SET status = "RESOLVIDO" WHERE id = '.$reportID.'');
		
		$main_content .= '<center><h2>O report #'.$reportID.' foi marcado como resolvido e não foi dado recompensa ao jogador!<h2></center>';
	} 
	
	//list of players$playercast = $SQL->query('SELECT cast_name FROM live_casts WHERE player_id > 0 ORDER BY '.$orderby);
	$allreports = $SQL->query('SELECT * FROM support');
	foreach($allreports as $report)
	{
		if ($report['status'] == "PENDENTE") {
			$number_of_reports++;
			if(is_int($number_of_reports / 2)) 
			{
				$bgcolor = $config['site']['darkborder'];
			}
			else
			{
				$bgcolor = $config['site']['lightborder'];
			}
			$reportName = $report['name'];
			$reportId = $report['id'];
			$players_rows .= '
			<TR BGCOLOR='.$bgcolor.'>
				<td witdth=10%>
				<form name="acoes" id="acoes'.$number_of_reports.'" action="?subtopic=support" method="post">
					<input type="hidden" name="reportid" value="'.$reportId.'">	
					<input type="hidden" name="charname" value="'.$reportName.'">						
				<button type="submit" name="+" form="acoes'.$number_of_reports.'">+</button>
				</form>
				
				<form name="acoes1" id="acoes'.$number_of_reports.'" action="?subtopic=support" method="post" >
					<input type="hidden" name="reportid" value="'.$report['id'].'">					
				<button type="submit" name="-" form="acoes'.$number_of_reports.'">-</button>
				</form>
				</td>
				<TD WIDTH=10%>ID: ' .$report['id'].'<br><A HREF="index.php?subtopic=characters&name='.urlencode($report['name']).'">'.$report['name'].'</A><br/></TD>
				<TD WIDTH=60%><b>'.$report['description'].'</b></TD>
				<TD WIDTH=20%><font color="#008000">(' .$report['posx']. ', ' .$report['posy']. ', ' .$report['posz']. ')</font></TD>
			</TR>';
		}
	}
	$main_content .= '
	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%>
		<TR BGCOLOR="'.$config['site']['vdarkborder'].'">
			<TD><A HREF="index.php?subtopic=whoisonline&order=name" CLASS=white>Acoes</A></TD>
			<TD><A HREF="index.php?subtopic=whoisonline&order=name" CLASS=white>Nome</A></TD>
			<TD><A HREF="index.php?subtopic=whoisonline&order=vocation" CLASS=white>Descrição</TD>
			<TD><A HREF="index.php?subtopic=whoisonline&order=vocation" CLASS=white>Position</TD>
		</TR>
	'.$players_rows.'</TABLE>';
	}
	
		
?>
