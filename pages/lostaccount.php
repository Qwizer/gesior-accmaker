<?php
if(!defined('INITIALIZED'))
	exit;

if($config['site']['send_emails'])
{
	if($action == '')
	{
	if($logged)
	$main_content .= '<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Lost Account?</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table1" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">          <table style="width:100%;"><tbody><tr><td>You can not use the lost account interface as long as you are logged in to your account.</td></tr>          </tbody></table>        </div>      </td>    </tr>  </tbody></table></div><br><center><form action="?subtopic=accountmanagement&action=logout" method="post" style="padding:0px;margin:0px;"><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="visibility: hidden; background-image: url('.$layout_name.'/images/buttons/sbutton_red_over.gif);"></div><input class="ButtonText" type="image" name="Logout" alt="Logout" src="'.$layout_name.'/images/buttons/_sbutton_logout.gif"></div></div></form></center>';
	else
		$main_content .= 'The Lost Account Interface can help you to get back your account name and password. Please enter your character name and select what you want to do.<BR>
		<FORM ACTION="?subtopic=lostaccount&action=step1" METHOD=post>
		<INPUT TYPE=hidden NAME="character" VALUE="">
		<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
		<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Please enter your character name</B></TD></TR>
		<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
		<INPUT TYPE=text NAME="nick" VALUE="" SIZE="40"><BR>
		</TD></TR>
		</TABLE>
		<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
		<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>What do you want?</B></TD></TR>
		<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
		<INPUT TYPE=radio NAME="action_type" VALUE="email"> Send me new password and my account name to account e-mail adress.<BR>
		<INPUT TYPE=radio NAME="action_type" VALUE="reckey"> I got <b>recovery key</b> and want set new password and e-mail adress to my account.<BR>
		</TD></TR>
		</TABLE>
		<BR>
		<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
		<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
		</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'step1' && $_REQUEST['action_type'] == '')
		$main_content .= 'Please select action.
		<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	elseif($action == 'step1' && $_REQUEST['action_type'] == 'email')
	{
		$nick = $_REQUEST['nick'];
		if(check_name($nick))
		{
			$player = new Player();
			$account = new Account();
			$player->find($nick);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				if($account->getCustomField('next_email') < time())
					$main_content .= 'Please enter e-mail to account with this character.<BR>
					<FORM ACTION="?subtopic=lostaccount&action=sendcode" METHOD=post>
					<INPUT TYPE=hidden NAME="character" VALUE="">
					<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
					<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Please enter e-mail to account</B></TD></TR>
					<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
					Character: <INPUT TYPE=text NAME="nick" VALUE="'.htmlspecialchars($nick).'" SIZE="40" readonly="readonly"><BR>
					E-mail to account:<INPUT TYPE=text NAME="email" VALUE="" SIZE="40"><BR>
					</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
				else
				{
					$insec = $account->getCustomField('next_email') - time();
					$minutesleft = floor($insec / 60);
					$secondsleft = $insec - ($minutesleft * 60);
					$timeleft = $minutesleft.' minutes '.$secondsleft.' seconds';
					$main_content .= 'Account of selected character (<b>'.htmlspecialchars($nick).'</b>) received e-mail in last '.ceil($config['site']['email_lai_sec_interval'] / 60).' minutes. You must wait '.$timeleft.' before you can use Lost Account Interface again.';
				}
			}
			else
				$main_content .= 'Player or account of player <b>'.htmlspecialchars($nick).'</b> doesn\'t exist.';
		}
		else
			$main_content .= 'Invalid player name format. If you have other characters on account try with other name.';
		$main_content .= '<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'sendcode')
	{
		$email = $_REQUEST['email'];
		$nick = $_REQUEST['nick'];
		if(check_name($nick))
		{
			$player = new Player();
			$account = new Account();
			$player->find($nick);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				if($account->getCustomField('next_email') < time())
				{
					if($account->getEMail() == $email)
					{
						$acceptedChars = '123456789zxcvbnmasdfghjklqwertyuiop';
						$newcode = NULL;
						for($i=0; $i < 30; $i++) {
							$cnum[$i] = $acceptedChars{mt_rand(0, 33)};
							$newcode .= $cnum[$i];
						}
						$mailBody = '<html>
<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="590"><a href= "http://relembra-global.com/" target="_blank"><img src="http://relembra-global.com/images/mail/relembra_logo.png" width="590" height="209" border="0" alt=""/></a></td>
                <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                    </tr>
                    <tr>
                      </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>Lost Account Interface!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
						You or someone else requested new password for  your account on server <a href="http://'.$config['server']['url'].'"><b>'.htmlspecialchars($config['server']['serverName']).'</b></a> with this e-mail.</br>
						</br>Account name: '.htmlspecialchars($account->getName()).'
						</br>Password: <i>You will set new password when you press on link.</i>
<br /><br />
Just click on the Button.</br>
						Or open page: <i>http://'.$config['server']['url'].'/?subtopic=lostaccount&action=checkcode</i> and in field "code" write <b>'.htmlspecialchars($newcode).'</b></br>
						<br />If you don\'t want to change password to your account just delete this e-mail.
						</br><u>It\'s automatic e-mail from OTS Lost Account System. Do not reply!</u></br>
<br /><br />
Best regards,<br />
Team Relembra-Global.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#ffffff; font-size:15px"><strong><a href="http://'.$config['server']['url'].'/?subtopic=lostaccount&action=checkcode&code='.urlencode($newcode).'&character='.urlencode($nick).'" target="_blank" style="color:#ffffff; text-decoration:none"><em>Change Password</em></a></strong></font></td>
                  </tr>
                  <tr>
                    <td height="10" align="center" valign="middle" bgcolor="#6ebe44"> </td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" align="center">&nbsp;</td>
                <td width="14%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="9%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="11%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="17%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>CONNECT</strong></font></td>
                <td width="4%" align="right"><a href="https://www.facebook.com/relembraoficial/" target="_blank"><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#231f20; font-size:12px"><strong>*Do not reply to this email, to get in touch with the staff use: contato@relembra-global.com</strong></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
						</html>';
						$mail = new PHPMailer();
						if ($config['site']['smtp_enabled'])
						{
							$mail->IsSMTP();
							$mail->SMTPDebug  = 0; 
							$mail->SMTPSecure = "ssl"; 
							$mail->Host = $config['site']['smtp_host'];
							$mail->Port = (int)$config['site']['smtp_port'];
							$mail->SMTPAuth = $config['site']['smtp_auth'];
							$mail->Username = $config['site']['smtp_user'];
							$mail->Password = $config['site']['smtp_pass'];
						}
						else
							$mail->IsMail();
						$mail->IsHTML(true);
						$mail->From = $config['site']['mail_address'];
						$mail->AddAddress($account->getCustomField('email'));
						$mail->Subject = $config['server']['serverName']." - Link to >set new password to account<";
						$mail->Body = $mailBody;
						if($mail->Send())
						{
							$account->set('email_code', $newcode);
							$account->set('next_email', (time() + $config['site']['email_lai_sec_interval']));
							$account->save();
							$main_content .= '<br />Link with informations needed to set new password has been sent to account e-mail address. You should receive this e-mail in 15 minutes. Please check your inbox/spam directory.';
						}
						else
						{
							$account->set('next_email', (time() + 60));
							$account->save();
							$main_content .= '<br />An error occorred while sending email! Try again or contact with admin.';
						}
					}
					else
						$main_content .= 'Invalid e-mail to account of character <b>'.htmlspecialchars($nick).'</b>. Try again.';
				}
				else
				{
					$insec = $account->getCustomField('next_email') - time();
					$minutesleft = floor($insec / 60);
					$secondsleft = $insec - ($minutesleft * 60);
					$timeleft = $minutesleft.' minutes '.$secondsleft.' seconds';
					$main_content .= 'Account of selected character (<b>'.htmlspecialchars($nick).'</b>) received e-mail in last '.ceil($config['site']['email_lai_sec_interval'] / 60).' minutes. You must wait '.$timeleft.' before you can use Lost Account Interface again.';
				}
			}
			else
				$main_content .= 'Player or account of player <b>'.htmlspecialchars($nick).'</b> doesn\'t exist.';
		}
		else
			$main_content .= 'Invalid player name format. If you have other characters on account try with other name.';
		$main_content .= '<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount&action=step1&action_type=email&nick='.urlencode($nick).'" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'step1' && $_REQUEST['action_type'] == 'reckey')
	{
		$nick = $_REQUEST['nick'];
		if(check_name($nick))
		{
			$player = new Player();
			$account = new Account();
			$player->find($nick);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				$account_key = $account->getCustomField('key');
				if(!empty($account_key))
				{
							$main_content .= 'If you enter right recovery key you will see form to set new e-mail and password to account. To this e-mail will be send your new password and account name.<BR>
							<FORM ACTION="?subtopic=lostaccount&action=step2" METHOD=post>
							<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
							<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Please enter your recovery key</B></TD></TR>
							<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
							Character name:&nbsp;<INPUT TYPE=text NAME="nick" VALUE="'.htmlspecialchars($nick).'" SIZE="40" readonly="readonly"><BR />
							Recovery key:&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=text NAME="key" VALUE="" SIZE="40"><BR>
							</TD></TR>
							</TABLE>
							<BR>
							<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
							<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
							</TD></TR></FORM></TABLE></TABLE>';
				}
				else
					$main_content .= 'Account of this character has no recovery key!';
			}
			else
				$main_content .= 'Player or account of player <b>'.htmlspecialchars($nick).'</b> doesn\'t exist.';
		}
		else
			$main_content .= 'Invalid player name format. If you have other characters on account try with other name.';
		$main_content .= '<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'step2')
	{
		$rec_key = trim($_REQUEST['key']);
		$nick = $_REQUEST['nick'];
		if(check_name($nick))
		{
			$player = new Player();
			$account = new Account();
			$player->find($nick);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				$account_key = $account->getCustomField('key');
				if(!empty($account_key))
				{
					if($account_key == $rec_key)
					{
						$main_content .= '<script type="text/javascript">
						function validate_required(field,alerttxt)
						{
						with (field)
						{
						if (value==null||value==""||value==" ")
						  {alert(alerttxt);return false;}
						else {return true}
						}
						}
						function validate_email(field,alerttxt)
						{
						with (field)
						{
						apos=value.indexOf("@");
						dotpos=value.lastIndexOf(".");
						if (apos<1||dotpos-apos<2) 
						  {alert(alerttxt);return false;}
						else {return true;}
						}
						}
						function validate_form(thisform)
						{
						with (thisform)
						{
						if (validate_required(email,"Please enter your e-mail!")==false)
						  {email.focus();return false;}
						if (validate_email(email,"Invalid e-mail format!")==false)
						  {email.focus();return false;}
						if (validate_required(passor,"Please enter password!")==false)
						  {passor.focus();return false;}
						if (validate_required(passor2,"Please repeat password!")==false)
						  {passor2.focus();return false;}
						if (passor2.value!=passor.value)
						  {alert(\'Repeated password is not equal to password!\');return false;}
						}
						}
						</script>';
						$main_content .= 'Set new password and e-mail to your account.<BR>
						<FORM ACTION="?subtopic=lostaccount&action=step3" onsubmit="return validate_form(this)" METHOD=post>
						<INPUT TYPE=hidden NAME="character" VALUE="">
						<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
						<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Please enter new password and e-mail</B></TD></TR>
						<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
						Account of character:&nbsp;&nbsp;<INPUT TYPE=text NAME="nick" VALUE="'.htmlspecialchars($nick).'" SIZE="40" readonly="readonly"><BR />
						New password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT id="passor" TYPE=password NAME="passor" VALUE="" SIZE="40"><BR>
						Repeat new password:&nbsp;&nbsp;<INPUT id="passor2" TYPE=password NAME="passor" VALUE="" SIZE="40"><BR>
						New e-mail address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT id="email" TYPE=text NAME="email" VALUE="" SIZE="40"><BR>
						<INPUT TYPE=hidden NAME="key" VALUE="'.htmlspecialchars($rec_key).'">
						</TD></TR>
						</TABLE>
						<BR>
						<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
						<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
						</TD></TR></FORM></TABLE></TABLE>';
					}
					else
						$main_content .= 'Wrong recovery key!';
				}
				else
					$main_content .= 'Account of this character has no recovery key!';
			}
			else
				$main_content .= 'Player or account of player <b>'.htmlspecialchars($nick).'</b> doesn\'t exist.';
		}
		else
			$main_content .= 'Invalid player name format. If you have other characters on account try with other name.';
		$main_content .= '<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount&action=step1&action_type=reckey&nick='.urlencode($nick).'" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'step3')
	{
		$rec_key = trim($_REQUEST['key']);
		$nick = $_REQUEST['nick'];
		$new_pass = trim($_REQUEST['passor']);
		$new_email = trim($_REQUEST['email']);
		if(check_name($nick))
		{
			$player = new Player();
			$account = new Account();
			$player->find($nick);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				$account_key = $account->getCustomField('key');
				if(!empty($account_key))
				{
					if($account_key == $rec_key)
					{
						if(check_password($new_pass))
						{
							if(check_mail($new_email))
							{
								$account->setEMail($new_email);
								$account->setPassword($new_pass);
								$account->save();
								$main_content .= 'Your account name, new password and new e-mail.<BR>
								<FORM ACTION="?subtopic=accountmanagement" onsubmit="return validate_form(this)" METHOD=post>
								<INPUT TYPE=hidden NAME="character" VALUE="">
								<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
								<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Your account name, new password and new e-mail</B></TD></TR>
								<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
								Account name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.htmlspecialchars($account->getName()).'</b><BR>
								New password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.htmlspecialchars($new_pass).'</b><BR>
								New e-mail address:&nbsp;<b>'.htmlspecialchars($new_email).'</b><BR>';
								if($account->getCustomField('next_email') < time())
								{
									$mailBody = '<html>
									<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
<td width="590"><a href= "http://relembra-global.com/" target="_blank"><img src="http://relembra-global.com/images/mail/relembra_logo.png" width="590" height="209" border="0" alt=""/></a></td>               <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                    </tr>
                    <tr>
                      </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>Changed Password and Email!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  		Changed password and e-mail to your account in Lost Account Interface on server <a href="http://'.$config['server']['url'].'"><b>'.$config['server']['serverName'].'</b></a>
						</br>Account name: <b>'.htmlspecialchars($account->getName()).'</b>
						</br>New password: <b>'.htmlspecialchars($new_pass).'</b>
						</br>E-mail: <b>'.htmlspecialchars($new_email).'</b> (this e-mail)
<br /><br />
<u>It\'s automatic e-mail from OTS Lost Account System. Do not reply!</u></br>
<br /><br />
Best regards,<br />
Team Relembra Global.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" align="center">&nbsp;</td>
                <td width="14%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="9%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="11%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="17%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>CONNECT</strong></font></td>
                <td width="4%" align="right"><a href="https://www.facebook.com/relembraoficial/" target="_blank"><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#231f20; font-size:12px"><strong>*Do not reply to this email, to get in touch with the staff use: contato@relembra-global.com</strong></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
									</html>';
									$mail = new PHPMailer();
									if ($config['site']['smtp_enabled'])
									{
										$mail->IsSMTP();
										$mail->SMTPDebug  = 0; 
										$mail->SMTPSecure = "ssl"; 
										$mail->Host = $config['site']['smtp_host'];
										$mail->Port = (int)$config['site']['smtp_port'];
										$mail->SMTPAuth = $config['site']['smtp_auth'];
										$mail->Username = $config['site']['smtp_user'];
										$mail->Password = $config['site']['smtp_pass'];
									}
									else
										$mail->IsMail();
									$mail->IsHTML(true);
									$mail->From = $config['site']['mail_address'];
									$mail->AddAddress($account->getCustomField('email'));
									$mail->Subject = $config['server']['serverName']." - New password to your account";
									$mail->Body = $mailBody;
									if($mail->Send())
									{
										$main_content .= '<br /><small>Sent e-mail with your account name and password to new e-mail. You should receive this e-mail in 15 minutes. You can login now with new password!';
									}
									else
									{
										$main_content .= '<br /><small>An error occorred while sending email! You will not receive e-mail with this informations.';
									}
								}
								else
								{
									$main_content .= '<br /><small>You will not receive e-mail with this informations.';
								}
								$main_content .= '<INPUT TYPE=hidden NAME="account_login" VALUE="'.$account->getId().'">
								<INPUT TYPE=hidden NAME="password_login" VALUE="'.htmlspecialchars($new_pass).'">
								</TD></TR></TABLE><BR>
								<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
								<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/sbutton_login.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
								</TD></TR></FORM></TABLE></TABLE>';
							}
							else
								$main_content .= 'Wrong e-mail format.';
						}
						else
							$main_content .= 'Wrong password format. Use only a-Z, A-Z, 0-9';
					}
					else
						$main_content .= 'Wrong recovery key!';
				}
				else
					$main_content .= 'Account of this character has no recovery key!';
			}
			else
				$main_content .= 'Player or account of player <b>'.htmlspecialchars($nick).'</b> doesn\'t exist.';
		}
		else
			$main_content .= 'Invalid player name format. If you have other characters on account try with other name.';
		$main_content .= '<BR /><TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<a href="?subtopic=lostaccount&action=step1&action_type=reckey&nick='.urlencode($nick).'" border="0"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" NAME="Back" ALT="Back" BORDER=0 WIDTH=120 HEIGHT=18></a></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'checkcode')
	{
		$code = trim($_REQUEST['code']);
		$character = trim($_REQUEST['character']);
		if(empty($code) || empty($character))
			$main_content .= 'Please enter code from e-mail and name of one character from account. Then press Submit.<BR>
					<FORM ACTION="?subtopic=lostaccount&action=checkcode" METHOD=post>
					<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
					<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Code & character name</B></TD></TR>
					<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
					Your code:&nbsp;<INPUT TYPE=text NAME="code" VALUE="" SIZE="40")><BR />
					Character:&nbsp;<INPUT TYPE=text NAME="character" VALUE="" SIZE="40")><BR />
					</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
		else
		{
			$player = new Player();
			$account = new Account();
			$player->find($character);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				if($account->getCustomField('email_code') == $code)
				{
					$main_content .= '<script type="text/javascript">
					function validate_required(field,alerttxt)
					{
					with (field)
					{
					if (value==null||value==""||value==" ")
					  {alert(alerttxt);return false;}
					else {return true}
					}
					}

					function validate_form(thisform)
					{
					with (thisform)
					{
					if (validate_required(passor,"Please enter password!")==false)
					  {passor.focus();return false;}
					if (validate_required(passor2,"Please repeat password!")==false)
					  {passor2.focus();return false;}
					if (passor2.value!=passor.value)
					  {alert(\'Repeated password is not equal to password!\');return false;}
					}
					}
					</script>
					Please enter new password to your account and repeat to make sure you remember password.<BR>
					<FORM ACTION="?subtopic=lostaccount&action=setnewpassword" onsubmit="return validate_form(this)" METHOD=post>
					<INPUT TYPE=hidden NAME="character" VALUE="'.htmlspecialchars($character).'">
					<INPUT TYPE=hidden NAME="code" VALUE="'.htmlspecialchars($code).'">
					<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
					<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Code & account name</B></TD></TR>
					<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
					New password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=password ID="passor" NAME="passor" VALUE="" SIZE="40")><BR />
					Repeat new password:&nbsp;<INPUT TYPE=password ID="passor2" NAME="passor2" VALUE="" SIZE="40")><BR />
					</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
				}
				else
					$error= 'Wrong code to change password.';
			}
			else
				$error = 'Account of this character or this character doesn\'t exist.';
		}
		if(!empty($error))
					$main_content .= '<font color="red"><b>'.$error.'</b></font><br />Please enter code from e-mail and name of one character from account. Then press Submit.<BR>
					<FORM ACTION="?subtopic=lostaccount&action=checkcode" METHOD=post>
					<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
					<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Code & character name</B></TD></TR>
					<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
					Your code:&nbsp;<INPUT TYPE=text NAME="code" VALUE="" SIZE="40")><BR />
					Character:&nbsp;<INPUT TYPE=text NAME="character" VALUE="" SIZE="40")><BR />
					</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
	elseif($action == 'setnewpassword')
	{
		$newpassword = $_REQUEST['passor'];
		$code = $_REQUEST['code'];
		$character = $_REQUEST['character'];
		$main_content .= '';
		if(empty($code) || empty($character) || empty($newpassword))
			$main_content .= '<font color="red"><b>Error. Try again.</b></font><br />Please enter code from e-mail and name of one character from account. Then press Submit.<BR>
					<BR><FORM ACTION="?subtopic=lostaccount&action=checkcode" METHOD=post>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
		else
		{
			$player = new Player();
			$account = new Account();
			$player->find($character);
			if($player->isLoaded())
				$account = $player->getAccount();
			if($account->isLoaded())
			{
				if($account->getCustomField('email_code') == $code)
				{
					if(check_password($newpassword))
					{
						$account->setPassword($newpassword);
						$account->set('email_code', '');
						$account->save();
						$main_content .= 'New password to your account is below. Now you can login.<BR>
						<INPUT TYPE="hidden" NAME="character" VALUE="'.htmlspecialchars($character).'">
						<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
						<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Changed password</B></TD></TR>
						<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
						New password:&nbsp;<b>'.htmlspecialchars($newpassword).'</b><BR />
						Account name:&nbsp;&nbsp;&nbsp;<i>(Already on your e-mail)</i><BR />';
						$mailBody = '<html>
						<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                    <td width="590"><a href= "http://relembra-global.com/" target="_blank"><img src="http://relembra-global.com/images/mail/relembra_logo.png" width="590" height="209" border="0" alt=""/></a></td>               <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                    </tr>
                    <tr>
                      </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>Changed Password!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  		Changed password to your account in Lost Account Interface on server <a href="http://'.$config['server']['url'].'"><b>'.$config['server']['serverName'].'</b></a>
						</br>Account name: <b>'.htmlspecialchars($account->getName()).'</b>
						</br>New password: <b>'.htmlspecialchars($newpassword).'</b>
<br /><br />
<u>It\'s automatic e-mail from OTS Lost Account System. Do not reply!</u></br>
<br /><br />
Best regards,<br />
Team Relembra Global.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" align="center">&nbsp;</td>
                <td width="14%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="9%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?sutopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="11%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://relembra-global.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="17%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>CONNECT</strong></font></td>
                <td width="4%" align="right"><a href="https://www.facebook.com/relembraoficial/" target="_blank"><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><img src="http://relembra-global.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#231f20; font-size:12px"><strong>*Do not reply to this email, to get in touch with the staff use: contato@relembra-global.com</strong></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
						</html>';
						$mail = new PHPMailer();
						if ($config['site']['smtp_enabled'])
						{
							$mail->IsSMTP();
							$mail->SMTPDebug  = 0; 
							$mail->SMTPSecure = "ssl"; 
							$mail->Host = $config['site']['smtp_host'];
							$mail->Port = (int)$config['site']['smtp_port'];
							$mail->SMTPAuth = $config['site']['smtp_auth'];
							$mail->Username = $config['site']['smtp_user'];
							$mail->Password = $config['site']['smtp_pass'];

						}
						else
							$mail->IsMail();
						$mail->IsHTML(true);
						$mail->From = $config['site']['mail_address'];
						$mail->AddAddress($account->getCustomField('email'));
						$mail->Subject = $config['server']['serverName']." - New password to your account";
						$mail->Body = $mailBody;
						if($mail->Send())
						{
							$main_content .= '<br /><small>New password work! Sent e-mail with your password and account name. You should receive this e-mail in 15 minutes. You can login now with new password!';
						}
						else
						{
							$main_content .= '<br /><small>New password work! An error occorred while sending email! You will not receive e-mail with new password.';
						}
					$main_content .= '</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<FORM ACTION="?subtopic=accountmanagement" METHOD=post>
					<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/sbutton_login.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
					}
					else
						$error= 'Wrong password format. Use only a-z, A-Z, 0-9.';
				}
				else
					$error= 'Wrong code to change password.';
			}
			else
				$error = 'Account of this character or this character doesn\'t exist.';
		}
		if(!empty($error))
					$main_content .= '<font color="red"><b>'.$error.'</b></font><br />Please enter code from e-mail and name of one character from account. Then press Submit.<BR>
					<FORM ACTION="?subtopic=lostaccount&action=checkcode" METHOD=post>
					<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%>
					<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Code & character name</B></TD></TR>
					<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
					Your code:&nbsp;<INPUT TYPE=text NAME="code" VALUE="" SIZE="40")><BR />
					Character:&nbsp;<INPUT TYPE=text NAME="character" VALUE="" SIZE="40")><BR />
					</TD></TR>
					</TABLE>
					<BR>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><TR><TD><center>
					<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
					</TD></TR></FORM></TABLE></TABLE>';
	}
}
else
	$main_content .= '<b>Account maker is not configured to send e-mails, you can\'t use Lost Account Interface. Contact with admin to get help.</b>';