<?php
if(!defined('INITIALIZED'))
	exit;

//CREATE ACCOUNT FORM PAGE
if($action == "")
{
	$main_content .= '
	<script type="text/javascript">

var accountHttp;

function checkAccount()
{
	if(document.getElementById("account_name").value=="")
	{
		document.getElementById("acc_name_check").innerHTML = \'<b><font color="red">Please enter account name.</font></b>\';
		return;
	}
	accountHttp=GetXmlHttpObject();
	if (accountHttp==null)
	{
		return;
	}
	var account = document.getElementById("account_name").value;
	var url="?subtopic=ajax_check_account&account=" + account + "&uid="+Math.random();
	accountHttp.onreadystatechange=AccountStateChanged;
	accountHttp.open("GET",url,true);
	accountHttp.send(null);
} 

function AccountStateChanged() 
{ 
	if (accountHttp.readyState==4)
	{ 
		document.getElementById("acc_name_check").innerHTML=accountHttp.responseText;
	}
}

var emailHttp;

//sprawdza czy dane konto istnieje czy nie
function checkEmail()
{
	if(document.getElementById("email").value=="")
	{
		document.getElementById("email_check").innerHTML = \'<b><font color="red">Please enter e-mail.</font></b>\';
		return;
	}
	emailHttp=GetXmlHttpObject();
	if (emailHttp==null)
	{
		return;
	}
	var email = document.getElementById("email").value;
	var url="?subtopic=ajax_check_email&email=" + email + "&uid="+Math.random();
	emailHttp.onreadystatechange=EmailStateChanged;
	emailHttp.open("GET",url,true);
	emailHttp.send(null);
} 

function EmailStateChanged() 
{
	if (emailHttp.readyState==4)
	{
		document.getElementById("email_check").innerHTML=emailHttp.responseText;
	}
}

	function validate_required(field,alerttxt)
	{
		with (field)
			{
			if (value==null||value==""||value==" ")
			{
				alert(alerttxt);
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	function validate_email(field,alerttxt)
	{
		with (field)
		{
			apos=value.indexOf("@");
			dotpos=value.lastIndexOf(".");
			if (apos<1||dotpos-apos<2) 
			{
				alert(alerttxt);
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	function validate_form(thisform)
	{
		with (thisform)
		{
			if(validate_required(account_name,"Please enter name of new account!")==false)
			{
				account_name.focus();
				return false;
			}
			if(validate_required(email,"Please enter your e-mail!")==false)
			{
				email.focus();
				return false;
			}
			if(validate_email(email,"Invalid e-mail format!")==false)
			{
				email.focus();
				return false;
			}
			if(verifpass==1)
			{
				if(validate_required(passor,"Please enter password!")==false)
				{
					passor.focus();
					return false;
				}
				if (validate_required(passor2,"Please repeat password!")==false)
				{
					passor2.focus();
					return false;
				}
				if(passor2.value!=passor.value)
				{
					alert(\'Repeated password is not equal to password!\');
					return false;
				}
			}
			if(verifya==1)
			{
				if (validate_required(verify,"Please enter verification code!")==false)
				{
					verify.focus();return false;
				}
			}
			if(rules.checked==false)
			{
				alert(\'To create account you must accept server rules!\');
				return false;
			}
			if(agreement.checked==false)
			{
				alert(\'To create account you must accept server agreement!\');
				return false;
			}
			if(privacy.checked==false)
			{
				alert(\'To create account you must accept server privacy!\');
				return false;
			}
		}
	}
	</script>';
	$main_content .= '<script type="text/javascript">
			var nameHttp;

function checkName()
{
		if(document.getElementById("newcharname").value=="")
		{
			document.getElementById("name_check").innerHTML = \'<b><font color="red">Please enter new character name.</font></b>\';
			return;
		}
		nameHttp=GetXmlHttpObject();
		if (nameHttp==null)
		{
			return;
		}
		var newcharname = document.getElementById("newcharname").value;
		var url="?subtopic=ajax_check_name&name=" + newcharname + "&uid="+Math.random();
		nameHttp.onreadystatechange=NameStateChanged;
		nameHttp.open("GET",url,true);
		nameHttp.send(null);
} 

function NameStateChanged() 
{ 
		if (nameHttp.readyState==4)
		{ 
			document.getElementById("name_check").innerHTML=nameHttp.responseText;
		}
}
</script>';
	
	$main_content .= '<script src="account/create_character.js"></script>
	To play on '.htmlspecialchars($config['server']['serverName']).' you need an account. 
						All you have to do to create your new account is to enter your email address, password to new account, verification code from picture and to agree to the terms presented below. 
						If you have done so, your account name, password and e-mail address will be shown on the following page and your account and password will be sent 
						to your email address along with further instructions.<BR><BR>
	<div style="position:relative;top:0px;left:0px;">
				<FORM ACTION="?subtopic=createaccount&action=saveaccount" onsubmit="return validate_form(this)" METHOD=post>
					<div class="TableContainer">
						<div class="CaptionContainer">
								<div class="CaptionInnerContainer"> 
									<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
									<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>								
									<div class="Text">Create an Account</div>
									<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
									<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
									<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
								</div>
							</div><table class="Table5" cellpadding="0" cellspacing="0">
							
							<tbody><tr>
								<td>
									<div class="InnerTableContainer">
										<table style="width:100%;">
											<tbody><tr>
												<td>
													<div class="TableShadowContainerRightTop">
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
														<div class="TableContentContainer">
															<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
																<tbody><tr>
																	<td class="LabelV150">
																		<span id="accountname_label">Account Name:</span>
																	</td>
																	<td>
																		<input id="accountname" name="accountname" class="CipAjaxInput" style="width:206px;float:left;" value="" size="30" maxlength="30" onblur="SendAjaxCip({DataType: \'Container\'}, {Href: \'account/ajax_accountname.php\',PostData: \'a_AccountName=\'+this.value,Method: \'POST\'});">
																		<div id="accountname_indicator" class="InputIndicator" style="background-image:url(account/nok.gif);"></div>
																	</td>
																</tr>
																<tr>
																	<td></td>
																	<td><span id="accountname_errormessage" class="FormFieldError"></span></td>
																</tr>
																<tr>
																	<td class="LabelV150">
																		<span id="email_label">Email Address:</span>
																	</td>
																	<td>
																		<input id="email" name="email" class="CipAjaxInput" style="width:206px;float:left;" value="" size="30" maxlength="50" onblur="SendAjaxCip({DataType: \'Container\'}, {Href: \'account/ajax_email.php\',PostData: \'a_EMail=\'+encodeURIComponent(this.value),Method: \'POST\'});">
																		<div id="email_indicator" class="InputIndicator" style="background-image:url(account/nok.gif);"></div>
																	</td>
																</tr>
																<tr>
																	<td></td>
																	<td><span id="email_errormessage" class="FormFieldError"></span></td>
																</tr>';
											if(!$config['site']['create_account_verify_mail'])
												$main_content.= '<script type="text/javascript">var verifpass=1;</script>
																<tr>
																	<td class="LabelV150">
																		<span id="password1_label">Password:</span>
																	</td>
																	<td>
																		<input id="password1" type="password" name="password1" style="width:206px;float:left;" value="" size="30" maxlength="30" onblur="SendAjaxCip({DataType: \'Container\'}, {Href: \'./account/ajax_password.php\',PostData: \'a_Password1=\'+getElementById(\'password1\').value+\'&amp;a_Password2=\'+getElementById(\'password2\').value,Method: \'POST\'});">
																		<div id="password1_indicator" class="InputIndicator" style="background-image:url(account/nok.gif);"></div>
																	</td>
																</tr>
																<tr>
																	<td class="LabelV150">
																		<span id="password2_label">Password Again:</span>
																	</td>
																	<td>
																		<input id="password2" type="password" name="password2" style="width:206px;float:left;" value="" size="30" maxlength="30" onblur="SendAjaxCip({DataType: \'Container\'}, {Href: \'./account/ajax_password.php\',PostData: \'a_Password1=\'+getElementById(\'password1\').value+\'&amp;a_Password2=\'+getElementById(\'password2\').value,Method: \'POST\'});">
																		<div id="password2_indicator" class="InputIndicator" style="background-image:url(account/nok.gif);"></div>
																	</td>
																</tr>
																<tr>
																	<td></td>
																	<td><span id="password_errormessage" class="FormFieldError"></span></td>
																</tr>';
											else
												$main_content .= '<script type="text/javascript">var verifpass=0;</script>';
															$main_content .= '</tbody></table>
														</div>
													</div>
													<div class="TableShadowContainer">
														<div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);">
															<div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);"></div>
															<div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);"></div>
														</div>
													</div>
												</td>
											</tr>';
											
							if($config['site']['verify_code'])
							$main_content.= '<script type="text/javascript">var verifya=1;</script>
											<tr>
												<td>
													<div class="TableShadowContainerRightTop">
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
														<div class="TableContentContainer">
															<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
																<tbody><TR><TD width="150"><B>Code: </B></TD><TD colspan="2"><img src="?subtopic=imagebuilder&image_refresher='.mt_rand(1,99999).'" border="0" alt="Image Verification is missing, please contact the administrator"></TD></TR>
						  <TR><TD width="150" valign="top"><B>Verification Code: </B></TD><TD colspan="2"><INPUT id="verify" NAME="reg_code" VALUE="" SIZE=30 MAXLENGTH=50><BR><font size="1" face="verdana,arial,helvetica">(Here write verification code from picture)</font></TD></TR>
															</tbody></table>
														</div>
													</div>
													<div class="TableShadowContainer">
														<div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);">
															<div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);"></div>
															<div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);"></div>
														</div>
													</div>
												</td>
											</tr>';
							else
							$main_content .= '<script type="text/javascript">var verifya=0;</script>';
							$main_content .= '<tr><td><div class="TableShadowContainerRightTop">  <div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div></div><div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">  <div class="TableContentContainer">    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;"><tbody><tr><td><b>Please select the following check box:</b></td></tr><tr><td><input type="checkbox" name="agreeagreements" value="true" onclick="if(this.checked == true) {  document.getElementById(\'agreeagreements_errormessage\').innerHTML = \'\';} else {  document.getElementById(\'agreeagreements_errormessage\').innerHTML = \'You have to agree to the '.htmlspecialchars($config['server']['serverName']).' Rules, '.htmlspecialchars($config['server']['serverName']).' Service Agreement and '.htmlspecialchars($config['server']['serverName']).' Privacy Policy in order to create an account!\';}"> I agree to the <a href="?subtopic=tibiarules" target="_blank">'.htmlspecialchars($config['server']['serverName']).' Rules</a>, <a href="?subtopic=tibiarules&action=agreement" target="_blank">'.htmlspecialchars($config['server']['serverName']).' Services Agreement</a> and <a href="?subtopic=tibiarules&action=privacy" target="_blank">'.htmlspecialchars($config['server']['serverName']).' Privacy Policy</a>.</td></tr><tr><td><span id="agreeagreements_errormessage" class="FormFieldError"></span></td></tr>    </tbody></table>  </div></div><div class="TableShadowContainer">  <div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);">    <div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);"></div>    <div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);"></div>  </div></div></td></tr>
										</tbody></table>
									</div>
								</td>
							</tr>
						</tbody></table>
					</div>
					<br>
					<center>
						<table border="0" cellspacing="0" cellpadding="0">
						<tbody><tr>
							<td style="border:0px;">
								<input type="hidden" name="step" value="docreate">
								<input type="hidden" name="noframe" value="">
								<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
									<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
										<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif">
									</div>
								</div>
							</td>
						</tr><tr>
					
				</tr></tbody></table>
			</center>
		
	</form></div>';
}
//CREATE ACCOUNT PAGE (save account in database)
if($action == "saveaccount")
{
	$reg_name = strtoupper(trim($_POST['accountname']));
	$reg_email = trim($_POST['email']);
	$reg_password = trim($_POST['password1']);
	$reg_code = trim($_POST['reg_code']);
	$reg_agreeagreements = trim($_POST['agreeagreements']);
	//FIRST check
	//check e-mail
	if ($_POST['agreeagreements'] <> 'true')
		$reg_form_errors[] = "Please accept ".htmlspecialchars($config['server']['serverName'])."  Agreeagreements.";
	if(empty($reg_name))
		$reg_form_errors[] = "Please enter account name.";
	elseif(!check_account_name($reg_name))
		$reg_form_errors[] = "Invalid account name format. Use only A-Z and numbers 0-9.";
	if(empty($reg_email))
		$reg_form_errors[] = "Please enter your email address.";
	else
	{
		if(!check_mail($reg_email))
			$reg_form_errors[] = "E-mail address is not correct.";
	}
	if($config['site']['verify_code'])
	{
		//check verification code
		$string = strtoupper($_SESSION['string']);
		$userstring = strtoupper($reg_code);
		session_destroy();
		if(empty($string))
			$reg_form_errors[] = "Information about verification code in session is empty.";
		else
		{
			if(empty($userstring))
				$reg_form_errors[] = "Please enter verification code.";
			else
			{
				if($string != $userstring)
					$reg_form_errors[] = "Verification code is incorrect.";
			}
		}
	}
	//check password
	if(empty($reg_password) && !$config['site']['create_account_verify_mail'])
		$reg_form_errors[] = "Please enter password to your new account.";
	elseif(!$config['site']['create_account_verify_mail'])
	{
		if(!check_password($reg_password))
			$reg_form_errors[] = "Password contains illegal chars (a-z, A-Z and 0-9 only!) or lenght.";
	}
	//SECOND check
	//check e-mail address in database
	if(empty($reg_form_errors))
	{
		if($config['site']['one_email'])
		{
			$test_email_account = new Account();
			//load account with this e-mail
			$test_email_account->findByEmail($reg_email);
			if($test_email_account->isLoaded())
				$reg_form_errors[] = "Account with this e-mail address already exist in database.";
		}
		$account_db = new Account();
		$account_db->find($reg_name);
		if($account_db->isLoaded())
			$reg_form_errors[] = 'Account with this name already exist.';
	}
	// ----------creates account-------------(save in database)
	if(empty($reg_form_errors))
	{
		//create object 'account' and generate new acc. number
		if($config['site']['create_account_verify_mail'])
		{
			$reg_password = '';
			for ($i = 1; $i <= 6; $i++)
				$reg_password .= mt_rand(0,9);
		}
		$reg_account = new Account();
		// saves account information in database
		$reg_account->setName($reg_name);
		$reg_account->setPassword($reg_password);
		$reg_account->setEMail($reg_email);
		$reg_account->setCreateDate(time());
		$reg_account->setCreateIP(Visitor::getIP());
		$reg_account->setFlag(Website::getCountryCode(long2ip(Visitor::getIP())));
		if(isset($config['site']['newaccount_premdays']) && $config['site']['newaccount_premdays'] > 0)
		{
			$reg_account->set("premdays", $config['site']['newaccount_premdays']);
			$reg_account->set("lastday", time());
		}
		$reg_account->save();
		//show information about registration
		if($config['site']['send_emails'] && $config['site']['create_account_verify_mail'])
		{
			$mailBody = '<html>
<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="61"><a href= "http://ot-br.com/" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_01.jpg" width="61" height="76" border="0" alt=""/></a></td>
                <td width="144"><a href= "http://ot-br.com/" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_02.jpg" width="144" height="76" border="0" alt=""/></a></td>
                <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                    </tr>
                    <tr>
                      <td height="30"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_04.jpg" width="393" height="30" border="0" alt=""/></td>
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
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>Registered Successfully!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
			You or someone else registred on server <a href="'.$config['server']['url'].'"><b>'.htmlspecialchars($config['server']['serverName']).'</b></a> with this e-mail.
			</br>Account name: <b>'.htmlspecialchars($reg_name).'</b>
			</br>Password: <b>'.htmlspecialchars(trim($reg_password)).'</b>
			<br /></br>
			</br>After login you can:
			<li>Create new characters
			<li>Change your current password
			<li>Change your current e-mail
			
<br /><br />
Best regards,<br />
Team OT-BR.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#ffffff; font-size:15px"><strong><a href="http://'.$config['server']['url'].'/?subtopic=accountmanagement" target="_blank" style="color:#ffffff; text-decoration:none"><em>Go to MyAccount</em></a></strong></font></td>
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
          <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" align="center">&nbsp;</td>
                <td width="14%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?sutopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="9%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?sutopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="11%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="17%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>CONNECT</strong></font></td>
                <td width="4%" align="right"><a href="https://www.facebook.com/OpenTibiaBR" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#231f20; font-size:12px"><strong>*Do not reply to this email, to get in touch with the staff use: contato@ot-br.com</strong></font></td>
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
			$mail->AddAddress($reg_email);
			$mail->Subject = $config['server']['serverName']." - Registration";
			$mail->Body = $mailBody;
			if($mail->Send())
			{
				$main_content .= 'Your account has been created. Check your e-mail. See you in Tibia!<BR><BR>';
				$main_content .= '<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
				<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Account Created</B></TD></TR>
				<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
				  <TABLE BORDER=0 CELLPADDING=1><TR><TD>
				    <BR>Your account name is <b>'.$reg_name.'</b>.
					<BR><b><i>You will receive e-mail (<b>'.htmlspecialchars($reg_email).'</b>) with your password.</b></i><br>';
				$main_content .= 'You will need the account name and your password to play on '.htmlspecialchars($config['server']['serverName']).'.
				    Please keep your account name and password in a safe place and
				    never give your account name or password to anybody.<BR><BR>';
				$main_content .= '<br /><small>These informations were send on email address <b>'.htmlspecialchars($reg_email).'</b>. Please check your inbox/spam folder.';
			}
			else
			{
				$main_content .= '<br /><small>An error occorred while sending email! Account not created. Try again.</small>';
				$reg_account->delete();
			}
		}
		else
		{
			$main_content .= 'Your account has been created. Now you can login and create your first character. See you in Tibia!<BR><BR>';
			$main_content .= '<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
			<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Account Created</B></TD></TR>
			<TR><TD BGCOLOR="'.$config['site']['darkborder'].'">
			  <TABLE BORDER=0 CELLPADDING=1><TR><TD>
			    <BR>Your account name is <b>'.htmlspecialchars($reg_name).'</b><br>You will need the account name and your password to play on '.htmlspecialchars($config['server']['serverName']).'.
			    Please keep your account name and password in a safe place and
			    never give your account name or password to anybody.<BR><BR>';
			if($config['site']['send_emails'] && $config['site']['send_register_email'])
			{
				$mailBody = '<html>
<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="61"><a href= "http://ot-br.com/" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_01.jpg" width="61" height="76" border="0" alt=""/></a></td>
                <td width="144"><a href= "http://ot-br.com/" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_02.jpg" width="144" height="76" border="0" alt=""/></a></td>
                <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                    </tr>
                    <tr>
                      <td height="30"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_01_04.jpg" width="393" height="30" border="0" alt=""/></td>
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
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>Registered Successfully!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
			You or someone else registred on server <a href="'.$config['server']['url'].'"><b>'.htmlspecialchars($config['server']['serverName']).'</b></a> with this e-mail.
			</br>Account name: <b>'.htmlspecialchars($reg_name).'</b>
			</br>Password: <b>'.htmlspecialchars(trim($reg_password)).'</b>
			<br /></br>
			</br>After login you can:
			<li>Create new characters
			<li>Change your current password
			<li>Change your current e-mail
			
<br /><br />
Best regards,<br />
Team OT-BR.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#ffffff; font-size:15px"><strong><a href="http://'.$config['server']['url'].'/?subtopic=accountmanagement" target="_blank" style="color:#ffffff; text-decoration:none"><em>Go to MyAccount</em></a></strong></font></td>
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
          <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" align="center">&nbsp;</td>
                <td width="14%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?sutopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="9%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?sutopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="11%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="2%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="17%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>CONNECT</strong></font></td>
                <td width="4%" align="right"><a href="https://www.facebook.com/OpenTibiaBR" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#231f20; font-size:12px"><strong>*Do not reply to this email, to get in touch with the staff use: contato@ot-br.com</strong></font></td>
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
				$mail->AddAddress($reg_email);
				$mail->Subject = $config['server']['serverName']." - Registration";
				$mail->Body = $mailBody;
				if($mail->Send())
					$main_content .= '<br /><small>These informations were send on email address <b>'.htmlspecialchars($reg_email).'</b>.';
				else
					$main_content .= '<br /><small>An error occorred while sending email (<b>'.htmlspecialchars($reg_email).'</b>)!</small>';
			}
		}
		$main_content .= '</TD></TR></TABLE></TD></TR></TABLE><BR><BR>
		<script type="text/javascript">
 $(function(){  // document.ready function...
   setTimeout(function(){
      $(\'#autologin\').submit();
    },1);
});
</script>
		<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=100%><FORM action="?subtopic=accountmanagement" method="post" id="autologin"><input type="hidden" name="account_login" value="'.$reg_name.'"><input type="hidden" name="password_login" value="'.$reg_password.'">
				<TR><TD><center>
								<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/sbutton_login.gif" BORDER=0 WIDTH=120 HEIGHT=18></center>
								</TD></TR></FORM></TABLE>';
	}
	else
	{
		//SHOW ERRORs if data from form is wrong
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($reg_form_errors as $show_msg)
		{
					$main_content .= '<li>'.$show_msg.'</li>';
		}
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>
		<BR>
		<CENTER>
		<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION=?subtopic=createaccount METHOD=post><TR><TD>
		<INPUT TYPE=hidden NAME=email VALUE="">

		<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE>
		</CENTER>';
	}
}