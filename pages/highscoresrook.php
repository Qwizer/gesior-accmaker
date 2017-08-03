<?PHP
if(!defined('INITIALIZED'))
	exit;
		
$list = 'experience';
if(isset($_REQUEST['list']))
	$list = $_REQUEST['list'];

$page = 0;
if(isset($_REQUEST['page']))
	$page = min(50, $_REQUEST['page']);

$vocation = 'None';
if(isset($_REQUEST['vocation']))
	$vocation = $_REQUEST['vocation'];

switch($list)
{
	case "fist":
		$id=Highscores::SKILL_FIST;
		$list_name='Fist Fighting';
		break;
	case "club":
		$id=Highscores::SKILL_CLUB;
		$list_name='Club Fighting';
		break;
	case "sword":
		$id=Highscores::SKILL_SWORD;
		$list_name='Sword Fighting';
		break;
	case "axe":
		$id=Highscores::SKILL_AXE;
		$list_name='Axe Fighting';
		break;
	case "distance":
		$id=Highscores::SKILL_DISTANCE;
		$list_name='Distance Fighting';
		break;
	case "shield":
		$id=Highscores::SKILL_SHIELD;
		$list_name='Shielding';
		break;
	case "fishing":
		$id=Highscores::SKILL_FISHING;
		$list_name='Fishing';
		break;
	case "magic":
		$id=Highscores::SKILL__MAGLEVEL;
		$list_name='Magic';
		break;
	default:
		$id=Highscores::SKILL__LEVEL;
		$list_name='Experience';
		break;
}
if(count($config['site']['worlds']) > 1)
{
	foreach($config['site']['worlds'] as $idd => $world_n)
	{
		if($idd == (int) $_REQUEST['world'])
		{
			$world_id = $idd;
			$world_name = $world_n;
		}
	}
}
if(!isset($world_id))
{
	$world_id = 1;
	$world_name = $config['site']['worlds'][1];
}
if(count($config['site']['worlds']) > 1)
{
	$main_content ='
<form action="" method="post">
	<div class="TableContainer">
		<table class="Table1" cellpadding="0" cellspacing="0">
			<div class="CaptionContainer">
				<div class="CaptionInnerContainer">
					<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<div class="Text">World Selection</div>
					<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
				</div>
			</div>
			<tr>
				<td>
					<div class="InnerTableContainer">
						<table width="100%">
							<tr>
								<td style="vertical-align:middle" class="LabelV150">World:</td>
								<td style="width:170px">
									<select size="1" name="world" style="width:165px">';
foreach($config['site']['worlds'] as $wid => $world_n)
{
if($wid == $world_id)
	$main_content .= '
		<OPTION VALUE="'.htmlspecialchars($wid).'" selected="selected">'.htmlspecialchars($world_n).'</OPTION>';
else
	$main_content .= '
		<OPTION VALUE="'.htmlspecialchars($wid).'">'.htmlspecialchars($world_n).'</OPTION>';
}

$main_content .= '


									</select>
								</td>
								<td style="text-align:left">
									<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)">
										<div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif)"></div>
											<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif"/>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</form><br/>
';
	}
					$offset = $page * 100;
					$skills = new Highscores($id, 100, $page, $world_id, $vocation);
					$main_content .= '
						<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%>
							<TR>
								<TD WIDTH=100% ALIGN=right VALIGN=bottom>
									<CENTER><H2>Ranking Rookgaard for '.htmlspecialchars($list_name).' on '.htmlspecialchars($world_name).'</H2></CENTER><BR>';
					
					$main_content .= '
						<br><TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%></TABLE>
						<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%>
							<TR BGCOLOR="'.$config['site']['vdarkborder'].'">
								<TD CLASS=whites><strong>Rank</strong></TD>
								<TD WIDTH=75% CLASS=whites><B>Name</B></TD>
								<TD WIDTH=15% CLASS=whites><b>Level</B></TD>';
						if($list == "experience")
							$main_content .= '
								<TD CLASS=whites><b>Points</B></TD>';
						$main_content .= '
							</TR>';
						$number_of_rows = 0;
					foreach($skills as $skill)
					{
						if($list == "magic")
							$value = $skill->getMagLevel();
						elseif($list == "experience")
							$value = $skill->getLevel();
						else
							$value = $skill->getScore();
						$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
						$main_content .= '
							<tr bgcolor="'.$bgcolor.'">
								<td>'.($offset + $number_of_rows).'</td>
								<td><a href="?subtopic=characters&name='.urlencode($skill->getName()).'">'.htmlspecialchars($skill->getName()).'</a></td>
								<td>'.$value.'</td>';
						if($list == "experience")
							$main_content .= '
								<td>'.$skill->getExperience().'</td>';
						$main_content .= '
							</tr>';
					}
					$main_content .= '
						</TABLE>
						<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%>';
					if($page > 0)
						$main_content .= '
							<TR>
								<TD WIDTH=100% ALIGN=right VALIGN=bottom>
									<A HREF="?subtopic=highscoresrook&list='.urlencode($list).'&page='.($page - 1).'&vocation=' . urlencode($vocation) . '&world=' . urlencode($world_id) . '" CLASS="size_xxs">Previous Page</A>
								</TD>
							</TR>';
					if($page < 50)
						$main_content .= '
							<TR>
								<TD WIDTH=100% ALIGN=right VALIGN=bottom>
									<A HREF="?subtopic=highscoresrook&list='.urlencode($list).'&page='.($page + 1).'&vocation=' . urlencode($vocation) . '&world=' . urlencode($world_id) . '" CLASS="size_xxs">Next Page</A>
								</TD>
							</TR>';
					$main_content .= '
						</TABLE>
					</TD>
					<TD WIDTH=5%>
						<IMG SRC="'.$layout_name.'/images/blank.gif" WIDTH=1 HEIGHT=1 BORDER=0>
					</TD>
					<TD WIDTH=15% VALIGN=top ALIGN=right>
						<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1>
							<TR BGCOLOR="'.$config['site']['vdarkborder'].'">
								<TD CLASS=whites><B>Choose a category</B></TD>
							</TR>
							<TR BGCOLOR="'.$config['site']['lightborder'].'">
								<TD>
									<A HREF="?subtopic=highscoresrook&list=experience&world='.$world_id.'" CLASS="size_xs">Experience</A><BR>
									<A HREF="?subtopic=highscoresrook&list=magic&world='.$world_id.'" CLASS="size_xs">Magic</A><BR>
									<A HREF="?subtopic=highscoresrook&list=shield&world='.$world_id.'" CLASS="size_xs">Shielding</A><BR>
									<A HREF="?subtopic=highscoresrook&list=distance&world='.$world_id.'" CLASS="size_xs">Distance</A><BR>
									<A HREF="?subtopic=highscoresrook&list=club&world='.$world_id.'" CLASS="size_xs">Club</A><BR>
									<A HREF="?subtopic=highscoresrook&list=sword&world='.$world_id.'" CLASS="size_xs">Sword</A><BR>
									<A HREF="?subtopic=highscoresrook&list=axe&world='.$world_id.'" CLASS="size_xs">Axe</A><BR>
									<A HREF="?subtopic=highscoresrook&list=fist&world='.$world_id.'" CLASS="size_xs">Fist</A><BR>
									<A HREF="?subtopic=highscoresrook&list=fishing&world='.$world_id.'" CLASS="size_xs">Fishing</A><BR>
								</TD>
							</TR>
						</TABLE>
					</TD>
					<TD><IMG SRC="'.$layout_name.'/images/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
				</TR>
			</TABLE>
';
?>