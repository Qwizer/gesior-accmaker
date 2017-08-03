<?PHP
if(!defined('INITIALIZED'))
  exit;

if($action == '')
{
    $main_content .='
    <div id="ProgressBar">
        <div id="Headline">Getting Started</div>
        <div id="MainContainer">
            <div id="BackgroundContainer">
                <div id="BackgroundContainerCenter">
                    <div id="BackgroundContainerCenterImage" style="background-image: url(layouts/tibiacom/images/content/stonebar-center.gif);">
                    </div>
                </div>
            </div>
            <img id="TubeLeftEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-left-blue.gif">
            <img id="TubeRightEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-right-blue.gif">
            <div id="FirstStep" class="Steps">
                <div class="SingleStepContainer">
                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-0-blue.gif">
                    <div class="StepText" style="font-weight: normal;">Donation Rules</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width: 33%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-1-blue.gif">
                            <div class="StepText" style="font-weight: normal;">Donation method</div>
                        </div>
                    </div>
                    <div class="Steps" style="width: 33%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-2-blue.gif">
                            <div class="StepText" style="font-weight: normal;">Request information</div>
                        </div>
                    </div>
                    <div class="Steps" style="width: 33.5%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-4-blue.gif">
                            <div class="StepText" style="font-weight: normal;">Request realized</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Initial information for your donation.</div>
                <span class="CaptionVerticalRight" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td align="Justify">
                                            We inform the players and employees who '.$config['server']['serverName'].' Alternate Tibia Server has no financial interest. All income earned is directly reapplied for server maintenance - this means that when making a donation, you are ensuring stability and increasing quality.</br></br>
                                            The points that are passed on to players who perform the donations are nothing beyond our gratification, that is, you are not buying points but getting a symbolic gratification (in form of points) that will benefit you in the game; you can use your points any way you want.</br></br>
                                            The spirit of this system is simple: in order to approach the players and make you feel at home, we understand your donation as a two-way street in the question credibility. To believe that it is worth investing in server maintenance, we invest in you by crediting them with points, which as mentioned above, they can be used in the way best fits them.</br></br>
                                            Check Vips Advantages</a> and '.$config['server']['serverName'].' Shop</a> and learn how to leverage their points in the most profitable way to your situation.</br>

                                            <h3>Frequently Asked questions</h3>
                                            <b>But what are Tibia Coins?</b><br>
                                            Tibia Coins is part of our donation system, with them you can get a VIP or something else that is available in '.$config['server']['serverName'].' Shop</a>.</br></br>

                                            <b>What is a VIP Account?</b><br>
                                            An Account VIP brings abilities and advantages inside and outside the game for a certain period of time. To learn more about the advantages please visit the section Vips Advantages</a>.</br></br>

                                            <b>How to make a donation?</b>
                                            <br>Click in <b>"Next"</b> and follow all procedures to make your donation.

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div><br>
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td style="border: 0px none;">
                        <div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif);"></div>
                            <a href="?subtopic=donate&action=rules">
                                <input class="ButtonText" name="next" alt="next" onclick=location.href="index.php?subtopic=donate&action=rules" src="layouts/tibiacom/images/buttons/_sbutton_submit.gif" type="image">
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</center>
';
}
elseif($action == 'rules')
{
    if(!$logged) {
      $main_content .= 'You are not logged in. <a href="?subtopic=accountmanagement">Log in</a> first to make a donate..';
  }
  else
  {
    $main_content .='
    <div id="ProgressBar">
        <div id="Headline">Rules and Information</div>
        <div id="MainContainer">
            <div id="BackgroundContainer">
                <div id="BackgroundContainerCenter">
                    <div id="BackgroundContainerCenterImage" style="background-image: url(layouts/tibiacom/images/content/stonebar-center.gif);">
                    </div>
                </div>
            </div>
            <img id="TubeLeftEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-left-green.gif">
            <img id="TubeRightEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-right-blue.gif">
            <div id="FirstStep" class="Steps">
                <div class="SingleStepContainer">
                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-0-green.gif">
                    <div class="StepText" style="font-weight: bold;">Donation Rules</div>
                </div>
            </div>
            <div id="StepsContainer1">
                <div id="StepsContainer2">
                    <div class="Steps" style="width: 33%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-1-blue.gif">
                            <div class="StepText" style="font-weight: normal;">DonationPayment method</div>
                        </div>
                    </div>
                    <div class="Steps" style="width: 33%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-2-blue.gif">
                            <div class="StepText" style="font-weight: normal;">Request information</div>
                        </div>
                    </div>
                    <div class="Steps" style="width: 33.5%;">
                        <div class="TubeContainer">
                            <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                        </div>
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-4-blue.gif">
                            <div class="StepText" style="font-weight: normal;">Request realized</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Read Donations Rules</div>
                <span class="CaptionVerticalRight" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td valign="middle" width="25px;" align="Justify">
                                            <B>Before making a donation, remember to comply with current rules and aware of all the necessary information.</B>
                                            <br><br>
                                            <TEXTAREA ROWS="5" WRAP="physical" COLS="80" READONLY="true" style="width:100%; height:400px; resize: none;">
1. General

a) The '.$config['server']['serverName'].' is an alternative Tibia server planned, built and implemented within the existing rules that allow the operation thereof without breaking any law (whether national or not).
b) All the money deposited and credited on the server is directly applied to their own maintenance, that is, all the capital rotated around the same is directly channeled to the direction of self-sufficiency.
c) The '.$config['server']['serverName'].' fight for its stability, however, we can not prevent mistakes will happen.
d) The history of donations is being saved, meaning you will never be forgotten.
e) The name assigned to the central points exchanges - '.$config['server']['serverName'].' Shop - it is fictitious; the '.$config['server']['serverName'].' not sell any kind of product.
e) The '.$config['server']['serverName'].' It is a non-profit company.

2. Losses & damages

a) Save your donate voucher. It is the only document that proves your help in server maintenance.
b) If resets all donations that were made within two months (counting from the day of the reset) will be fully recreditadas to player accounts. Remember that donation history is being saved, but you also need to prove their participation in donations.
c) In case of falls and (or) problems that make the '.$config['server']['serverName'].' go offline in safe mode or waiting for three consecutive days or more, players who have chosen to charge your VIP time points will be re-credited in the same way, the lost days (counting from the third day).
d) In case of unexpected stoppage of activities, there will be no replacement or recreditaусo of invested capital on the server, since every donation is directly sent to maintenance. In this case, players will be notified by the vehicle information (official site or forum).
e) In case of pre-programmed stoppage of activities, players will be informed through our vehicle information and the date that the donation system will be out of the air.
f) The '.$config['server']['serverName'].' provides and invests in basic security for the server, up to you to keep it safe; ie not responsible for their pertencens, characters and accounts.

3. Denotation # Donation
a) Act or effect of giving.
b) What gives himself.
c) The contract or document that ensures and legalizes the simple gift: that is made by unique resolution of the donor.
                                            </TEXTAREA>
                                            <br><br>
                                            The rules and information set forth in the above dialog box can be modified without notice.
                                            If you do not agree with the hiring of the simple donation please do not proceed.
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><br>

            <table width="100%"><tbody><tr align="center"><td><table border="0" cellpadding="0" cellspacing="0">
                <tbody><tr><td style="border: 0px none;">
                  <a href="javascript:void();" onclick=location.href="?subtopic=donate">
                    <div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
                      <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif);"></div>
                      <input class="ButtonText" name="Back" alt="Back" src="layouts/tibiacom/images/vips/_sbutton_back.gif" type="image">

                  </div></div></a></td></tr><tr></tr></tbody></table></td>

                  <td><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="border: 0px none;">
                      <a href="javascript:void();" onclick=location.href="?subtopic=donate&action=pag_form"><div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif); visibility: hidden;"></div>
                        <input class="ButtonText" name="Next" alt="Next" src="layouts/tibiacom/images/buttons/_sbutton_submit.gif" type="image">
                    </table></td></tr></tbody></table>';
                }
            }
            elseif($action == 'selectchar')
            {
             if(!$logged) {
                $main_content .= 'You are not logged in. <a href="?subtopic=accountmanagement">Log in</a> first to make a donate..';
            }
            else
            {

                $main_content .= '

                <h1>Selecione o player</h1><BR>
                <form action="index.php?subtopic=donate&action=pag_form" method=POST>
                   <table border="0" cellpadding="1" cellspacing="1" width="100%">
                     <tr bgcolor="#505050"><td colspan="2"><font color="#FFFFFF"><b>Select the character you want receive the donate.</b></font></td></tr>
                     <tr bgcolor="#D4C0A1"><td width="110"><b>Nome:</b></td><td width="550"><select name="buy_name">';
                        $players_from_logged_acc = $account_logged->getPlayersList();
                        if(count($players_from_logged_acc) > 0)
                        {
                          $players_from_logged_acc->orderBy('name');
                          foreach($players_from_logged_acc as $player)
                          {
                            $main_content .= '<option>'.$player->getName().'</option>';
                        }
                    }
                    else
                    {
                      $main_content .= 'Voce nсo tem nenhum char nessa account.';
                  }
                  $main_content .= '</table>
                  <br><center><input type="image" value="submit" src="layouts/tibiacom/images/buttons/sbutton_submit.gif"/>
              </form>';
          }


      }
      elseif($action == 'pag_form')
      {
         if(!$logged) {
            $main_content .= 'You are not logged in. <a href="?subtopic=accountmanagement">Log in</a> first to make a donate..';
        }
        else
        {
            $buy_name = stripslashes(urldecode($_POST['buy_name']));
            $main_content .= '
            <div id="ProgressBar">
                <div id="Headline">Donation method</div>
                <div id="MainContainer">
                    <div id="BackgroundContainer">
                        <div id="BackgroundContainerCenter">
                            <div id="BackgroundContainerCenterImage" style="background-image: url(layouts/tibiacom/images/content/stonebar-center.gif);">
                            </div>
                        </div>
                    </div>
                    <img id="TubeLeftEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-left-green.gif">
                    <img id="TubeRightEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-right-blue.gif">
                    <div id="FirstStep" class="Steps">
                        <div class="SingleStepContainer">
                            <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-0-green.gif">
                            <div class="StepText" style="font-weight: normal;">Donation Rules</div>
                        </div>
                    </div>
                    <div id="StepsContainer1">
                        <div id="StepsContainer2">
                            <div class="Steps" style="width: 33%;">
                                <div class="TubeContainer">
                                    <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                </div>
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-1-green.gif">
                                    <div class="StepText" style="font-weight: bold;">Donation method</div>
                                </div>
                            </div>
                            <div class="Steps" style="width: 33%;">
                                <div class="TubeContainer">
                                    <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green-blue.gif">
                                </div>
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-2-blue.gif">
                                    <div class="StepText" style="font-weight: normal;">Request information</div>
                                </div>
                            </div>
                            <div class="Steps" style="width: 33.5%;">
                                <div class="TubeContainer">
                                    <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-blue.gif">
                                </div>
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-4-blue.gif">
                                    <div class="StepText" style="font-weight: normal;">Request realized</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><p><strong>Portugues</strong>: No momento apenas o Pagseguro esta liberado para aceitarmos doa&ccedil;&otilde;es, caso voc&ecirc; nao consiga utilizar o pagseguro, entre em contato com nossa staff utilizando nosso sistema de ticket!</p>
<p><strong>Ingl&ecirc;s:&nbsp;</strong>At the moment only the Pagseguro is released to accept donations, in case you can not use the pagseguro, contact our staff using our ticket system!</p>
<p><strong>Espanhol</strong>:&nbsp;Actualmente, s&oacute;lo a conocer esta PagSeguro para aceptar donaciones, si no se puede utilizar el PagSeguro, por favor, p&oacute;ngase en contacto con nuestro personal usando nuestro sistema de tickets</p><br><br>
	<div class="TableContainer">
		<div class="CaptionContainer">
			<div class="CaptionInnerContainer">
				<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
				<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
				<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>
				<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
				<div class="Text">Donate now using Pagseguro</div>
				<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
				<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>
				<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
				<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
					</div>
						</div>
							<table class="Table3" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td>
										<div class="InnerTableContainer">
											<table style="width:100%;">
												<tbody>
	
	
	
	
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
            <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%>
              <form action="index.php?subtopic=donate&action=tipo" method="POST"><input type="hidden" name="char_name" value="">  ';
               if ($config['site']['usePagseguro']) {
                $main_content .= '   <TR BGCOLOR=#D4C0A1>
                <TD><input type="radio" name="method" value="1" checked="checked"> PagSeguro - Cartão de crédito/boleto</TD>
            </TR>';
        }
        if ($config['site']['usePaypal']) {
          $main_content .= '
          <TR BGCOLOR="#505050">
            <TR BGCOLOR=#D4C0A1>
              <TD><input type="radio" name="method" value="2"> Paypal - Credit Cards/International Transactions</TD>
          </TR>';
      }
      if ($config['site']['useDeposit']) {
        $main_content .= '
        <TR BGCOLOR="#505050">
          <TR BGCOLOR=#D4C0A1>
            <TD><input type="radio" name="method" value="3"> Depósito bancário - Depósitos/DOCS/Transferências bancárias</TD>
        </TR>';
    }

    if ($config['site']['useOnebip']) {
      $main_content .= '<TR BGCOLOR="#505050">
      <TR BGCOLOR=#D4C0A1>
        <TD><input type="radio" name="method" value="4"> Onebip - Crédito de celular/SMS</TD>
    </TR>';
}
if ($config['site']['useZaypay']) {
  $main_content .= '
  <TR BGCOLOR="#505050">
    <TR BGCOLOR=#D4C0A1>
      <TD><input type="radio" name="method" value="5"> ZayPay - Credit Cards/International Transactions</TD>
  </TR>';
}
if ($config['site']['useContenidopago']) {
    $main_content .= '
    <TR BGCOLOR="#505050">
      <TR BGCOLOR=#D4C0A1>
        <TD><input type="radio" name="method" value="6"> Contenidopago - Credit Cards/International Transactions</TD>
    </TR>';
}

$main_content .= '
</TABLE>
															</div>
														</div>											
														<div class="TableShadowContainer" >
															<div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-bm.gif);" >
																<div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-bl.gif);" ></div>
																<div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-br.gif);" ></div>
															</div>
														</div>
													</td>
												</tr>
	
	
	
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</tbody></table>
<br><table width="100%"><tbody><tr align="center"><td><table border="0" cellpadding="0" cellspacing="0">
<tbody><tr><td style="border: 0px none;">
  <a href="javascript:void();" onclick=location.href="?subtopic=donate&action=pag_form">
    <div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
      <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif);"></div>
      <input class="ButtonText" name="Continue" alt="Continue" src="layouts/tibiacom/images/buttons/_sbutton_submit.gif" type="image">

  </table></td></tr></tbody></table>';
}$_SESSION["nome"] = stripslashes(urldecode($_POST['method']));
}
elseif($action == 'tipo')
{
    if(!$logged) {
        $main_content .= 'You are not logged in. <a href="?subtopic=accountmanagement">Log in</a> first to make a donate..';
    }
    else
    {
        $buy_tipo = stripslashes(urldecode($_POST['method']));
        $main_content .= '
            <table border="0" cellpadding="4" cellspacing="1" width="100%" id="#estilo">
                <tbody>
                    <div id="ProgressBar">
                        <div id="Headline">Request information</div>
                        <div id="MainContainer">
                            <div id="BackgroundContainer">
                                <div id="BackgroundContainerCenter">
                                    <div id="BackgroundContainerCenterImage" style="background-image: url(layouts/tibiacom/images/content/stonebar-center.gif);">
                                    </div>
                                </div>
                            </div>
                            <img id="TubeLeftEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-left-green.gif">
                            <img id="TubeRightEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-right-blue.gif">
                            <div id="FirstStep" class="Steps">
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-0-green.gif">
                                    <div class="StepText" style="font-weight: normal;">Donation Rules</div>
                                </div>
                            </div>
                            <div id="StepsContainer1">
                                <div id="StepsContainer2">
                                    <div class="Steps" style="width: 33%;">
                                       <div class="TubeContainer">
                                         <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                     </div>
                                     <div class="SingleStepContainer">
                                         <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-1-green.gif">
                                         <div class="StepText" style="font-weight: normal;">Donation method</div>
                                     </div>
                                 </div>
                                 <div class="Steps" style="width: 33%;">
                                     <div class="TubeContainer">
                                         <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                     </div>
                                     <div class="SingleStepContainer">
                                         <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-2-green.gif">
                                         <div class="StepText" style="font-weight: bold;">Request information</div>
                                     </div>
                                 </div>
                                 <div class="Steps" style="width: 33.5%;">
                                    <div class="TubeContainer">
                                        <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green-blue.gif">
                                    </div>
                                    <div class="SingleStepContainer">
                                        <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-4-blue.gif">
                                        <div class="StepText" style="font-weight: normal;">Request realized</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>';
        if($buy_tipo == 1) {// donate form pagseguro.php
            include_once 'donate_forms/pagseguro.php';
        }
        else if($buy_tipo == 2) {// donate form paypal.php
            include_once 'donate_forms/paypal.php';
        }
        else if($buy_tipo == 3) {// donate form deposito.php
            include_once 'donate_forms/deposito.php';
        }
        else if($buy_tipo == 4) {// donate form onebip.php
            include_once 'donate_forms/onebip.php';
        }
        else if($buy_tipo == 5) {// donate form zaypay.php
            include_once 'donate_forms/zaypay.php';
        }
        else if($buy_tipo == 6){// donate form contenidopago.php
            include_once 'donate_forms/contenidopago.php';
        }

        $main_content .= '
            </tbody></table><br><br>
            </tbody></table><br>
            <table width="100%"><tbody><tr align="center"><td><table border="0" cellpadding="0" cellspacing="0">
            <tbody><tr><td style="border: 0px none;">
            </div></div></a></td></tr><tr></tr></tbody></table></td><td><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="border: 0px none;">
            <a href="javascript:void();" onclick=location.href="?subtopic=donate&action=pag_form"><div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif); visibility: hidden;"></div>
                <input class="ButtonText" name="Back" alt="Back" src="layouts/tibiacom/images/vips/_sbutton_back.gif" type="image">
            </table></td></tr></tbody></table>';
    }
}
elseif($action == 'final') {
    $main_content .= '
            <table border="0" cellpadding="4" cellspacing="1" width="100%" id="#estilo">
                <tbody>
                    <div id="ProgressBar">
                        <div id="Headline">Request information</div>
                        <div id="MainContainer">
                            <div id="BackgroundContainer">
                                <div id="BackgroundContainerCenter">
                                    <div id="BackgroundContainerCenterImage" style="background-image: url(layouts/tibiacom/images/content/stonebar-center.gif);">
                                    </div>
                                </div>
                            </div>
                            <img id="TubeLeftEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-left-green.gif">
                            <img id="TubeRightEnd" src="layouts/tibiacom/images/vips/progress-bar-tube-right-green.gif">
                            <div id="FirstStep" class="Steps">
                                <div class="SingleStepContainer">
                                    <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-0-green.gif">
                                    <div class="StepText" style="font-weight: normal;">Donation Rules</div>
                                </div>
                            </div>
                            <div id="StepsContainer1">
                                <div id="StepsContainer2">
                                    <div class="Steps" style="width: 33%;">
                                       <div class="TubeContainer">
                                         <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                     </div>
                                     <div class="SingleStepContainer">
                                         <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-1-green.gif">
                                         <div class="StepText" style="font-weight: normal;">Donation method</div>
                                     </div>
                                 </div>
                                 <div class="Steps" style="width: 33%;">
                                     <div class="TubeContainer">
                                         <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                     </div>
                                     <div class="SingleStepContainer">
                                         <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-2-green.gif">
                                         <div class="StepText" style="font-weight: bold;">Request information</div>
                                     </div>
                                 </div>
                                 <div class="Steps" style="width: 33.5%;">
                                    <div class="TubeContainer">
                                        <img class="Tube" src="layouts/tibiacom/images/vips/progress-bar-tube-green.gif">
                                    </div>
                                    <div class="SingleStepContainer">
                                        <img class="StepIcon" src="layouts/tibiacom/images/vips/progress-bar-icon-4-green.gif">
                                        <div class="StepText" style="font-weight: normal;">Request realized</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br/><br/><br/><br/>
                <center>
                Thank you for your donation!<br/>
                When our systems confirm your donation will be automatically added points in your account as a thank you.<br/>
                Continue contributing to our server reporting bugs in the forum.<br/><br/>

                Have fun!<br/><br/><br/>
            </tbody></table><br><br>
            </tbody></table><br>
            <table width="100%"><tbody><tr align="center"><td><table border="0" cellpadding="0" cellspacing="0">
            <tbody><tr><td style="border: 0px none;">
            </div></div></a></td></tr><tr></tr></tbody></table></td><td><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="border: 0px none;">
            <a href="javascript:void();" onclick=location.href="/"><div class="BigButton" style="background-image: url(layouts/tibiacom/images/buttons/sbutton.gif);">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(layouts/tibiacom/images/buttons/sbutton_over.gif); visibility: hidden;"></div>
                <input class="ButtonText" name="Back" alt="Back" src="layouts/tibiacom/images/vips/_sbutton_back.gif" type="image">
            </table></td></tr></tbody></table>';
}
?>

