<?PHP
if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
    $main_content .= '<center><h2><font color=red>Reports List</font></h2></center><br /><br />
<center><table border="0" cellspacing="1" cellpadding="4" width="100%">
    <tr bgcolor="'.$config['site']['vdarkborder'].'">
        <td width="5%"><b><font color=white><center>#</font></center></b></td>
        <td width="10%"><b><font color=white><center>Name</center></b></font></td>
        <td width="20%"><b><font color=white><center>Position</center></b></font></td>
        <td width="40%"><b><font color=white><center>Description</center></b></font></td>
        <td width="20%"><b><font color=white><center>Date</center></b></font></td>
    </tr>';
$i = 0;
foreach($SQL->query('SELECT id, name, posx, posy, posz, report_description, date FROM player_reports GROUP BY name ORDER BY id DESC limit 20;') as $report)
{
    $i++;
    $main_content .= '<tr bgcolor="' . (is_int($i / 2) ? $config['site']['lightborder'] : $config['site']['darkborder']). '">
        <td>          
            <center>'.$i.'</center>
        </td>
        <td>          
            <center><a href=?subtopic=characters&name='.$report['name'].'>'.$report['name'].'</a></center>
        </td>
        <td>
            <center>'.$report['posx'].', '.$report['posy'].', '.$report['posz'].'</center>
        </td>
        <td>
            <center>'.$report['report_description'].'</center>
        </td>
        <td>
            <center>'.$report['date'].'</center>
        </td>
    </tr>';
}
$main_content .='
</table>
    <a href="?subtopic=adminreport&action=reward">Reward Players for reporting.</a>';
if($action == "reward") {
        $player = stripslashes(ucwords(strtolower(trim($_REQUEST['character']))));
        $points = $_POST['points'];
        if(empty($player)) {
            $main_content .= '<form action="" method="post"><B>Enter Character Name:</B><input type="textbox" name="character"><br>
                <B>Enter Points Amount:</B><input type="textbox" name="points"><br><br><input type="submit" value="Submit">
                </form></center><form action="?subtopic=adminreport" method="post" ><input name="submit" type="submit" value="Close" title="Close"/></form>';
        } else {
            $player_data = $SQL->query("SELECT * FROM `players` WHERE `name` = '".$player."';")->fetch();
            $SQL->query("UPDATE `accounts` SET `coins` = `coins` + '".$points."' WHERE `id` = '".$player_data['account_id']."'");
            $main_content .= '<b><center>'.$points.' Premium Points added to the account of <i>'.$player.'</i> !</b></center><br>
                <form action="?subtopic=adminreport" method="post" ><input name="submit" type="submit" value="Close" title="Close"/></form>';
        }
    }
} else {
    $main_content .= 'Sorry, you have not the rights to access this page.';
}
?>