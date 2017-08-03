<?php
if(!defined('INITIALIZED'))
    exit;
 
$changeNameCost = 20;
 
if($logged)
{
    if($account_logged->getCustomField('coins') >= $changeNameCost)
    {
        if($action == "")
        {
            echo '<span style="color:red;font-weight:bold">CHANGE NAME COSTS ' . $changeNameCost . ' PREMIUM POINTS!</span><br />';
            echo '<form action="" mathod="post">';
            echo '<input type="hidden" name="subtopic" value="changename" />';
            echo '<input type="hidden" name="action" value="change" />';
            echo '<b>Select player: </b><select name="player_id">';
            $account_players = $account_logged->getPlayersList();
            foreach($account_players as $player)
            {
                echo '<option value="' . $player->getID() . '">' . htmlspecialchars($player->getName()) . '</option>';
            }
            echo '</select><br />';
            echo '<b>New name: </b><input type="text" name="new_name" value="" /><br />';
            echo '<input type="submit" value="Change name" />';
            echo '</form>';
        }
        elseif($action == "change")
        {
            $newchar_errors = array();
            $newchar_name = ucwords(strtolower(trim($_REQUEST['new_name'])));
            if(empty($newchar_name))
                $newchar_errors[] = 'Please enter a new name for your character!';
            if(!check_name_new_char($newchar_name))
                $newchar_errors[] = 'This name contains invalid letters, words or format. Please use only a-Z, - , \' and space.';
            $check_name_in_database = new Player();
            $check_name_in_database->find($newchar_name);
            if($check_name_in_database->isLoaded())
                $newchar_errors[] = 'This name is already used. Please choose another name!';
 
            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';
 
            if(empty($newchar_errors))
            {
                echo 'Name of character <b>' . htmlspecialchars($charToEdit->getName()) . '</b> changed to <b>' . htmlspecialchars($newchar_name) . '</b>';
                $charToEdit->setName($newchar_name);
                $charToEdit->save();
                $account_logged->setCustomField('coins', $account_logged->getCustomField('coins') - $changeNameCost);
            }
            else
            {
                echo 'Some errors occured:<br />';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '<br /><a href="?subtopic=changename"><b>BACK</b></a>';
            }
        }
    }
    else
        echo 'You don\'t have premium points. You need ' . $changeNameCost . '.';
}
else
    echo 'You must login first.';