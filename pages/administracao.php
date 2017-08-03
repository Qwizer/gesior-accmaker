<?php
if(!defined('INITIALIZED'))
	exit;
if($logged)
{
	if(($account_logged->getPageAccess() == $config['site']['access_admin_panel']))
	{
		if ($action == "") {
			$main_content .= '
				<center>
					<table>
						<tbody>
							<tr>
								<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
								<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Admin Panel, welcome '.$account_logged->getRLName().'!<br></td>
								<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
							</tr>
						</tbody>
					</table>
				</center>
				<br>';				
				
				$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">General Information</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >';
														$playersCount = $SQL->query("SELECT COUNT(*) FROM `players`")->fetch();
														$accountsCount = $SQL->query("SELECT COUNT(*) FROM `accounts`")->fetch();
														$guildsCount = $SQL->query("SELECT COUNT(*) FROM `guilds`")->fetch();
														$shopsCount = $SQL->query("SELECT COUNT(*) FROM `z_shop_offer`")->fetch();
														$namelocksCount = $SQL->query("SELECT COUNT(*) FROM `player_namelocks` where `player_new_name` != ''")->fetch();
														$main_content .= '
															<table class="TableContent" width="100%">
																<tr style="background-color:#D4C0A1;" >
																	<td class="LabelV" >Accounts on database:</td>
																	<td style="width:90%;" >'.$accountsCount[0].' accounts</td>
																</tr>
																<tr style="background-color:#F1E0C6;" >
																	<td class="LabelV" >Players on database:</td>
																	<td style="width:90%;" >'.$playersCount[0].' players - <a href="./?subtopic=adminpanel&action=manageplayers">Manage</a></td>
																</tr>
																<tr style="background-color:#D4C0A1;" >
																	<td class="LabelV" >Guilds on database:</td>
																	<td style="width:90%;" >'.$guildsCount[0].' guilds</td>
																</tr>
																<tr style="background-color:#F1E0C6;" >
																	<td class="LabelV" >Products on shop:</td>
																	<td style="width:90%;" >'.$shopsCount[0].' products</td>
																</tr>
																<tr style="background-color:#F1E0C6;" >
																	<td class="LabelV" >Namelocks:</td>
																	<td style="width:90%;" >'.$namelocksCount[0].' Namelocks - <a href="./?subtopic=adminpanel&action=managenamelocks">Manage</a></td>
																</tr>
															</table>
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
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>';
				if(isset($_REQUEST['acc_id'])) {
								$update_coin = $SQL->query("UPDATE `accounts` SET `coins` = coins + ".$_REQUEST['qnt_coin']." WHERE `id` = ".$_REQUEST['acc_id']."");
								$main_content .= '<center>COINS ADD!!!!!!</center></br></br>';
								}
				$main_content .= '	
<img id="ContentBoxHeadline" class="Title" src="headline.php?text=Worlds" alt="Contentbox headline">
	<div class="TableContainer">
		<table class="Table1" cellpadding="0" cellspacing="0">
			<div class="CaptionContainer">
				<div class="CaptionInnerContainer">
					<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<div class="Text">Adicionar Coin por Account ID (Para items que tiramos Shop)</div>
					<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
				</div>
			</div>
			<tr>
				<td>
					<div class="InnerTableContainer">
						<form action="?subtopic=adminpanel" method="post">
						<table width="100%">
							<tr>
								<td>
								<b>Account ID (Não é acc name, é account ID!!!!):</b> <input name="acc_id" value="" maxlenght="15"><br>
								<b>Coins:</b> <input name="qnt_coin" value="" maxlenght="15"><br>
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
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div><br>
';
				
				$main_content .= '	
<img id="ContentBoxHeadline" class="Title" src="headline.php?text=Worlds" alt="Contentbox headline">
	<div class="TableContainer">
		<table class="Table1" cellpadding="0" cellspacing="0">
			<div class="CaptionContainer">
				<div class="CaptionInnerContainer">
					<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<div class="Text">Checar Pagamento Pagseguro</div>
					<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif)"></span>
					<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif)"></span>
					<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
					<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif)"></span>
				</div>
			</div>
			<tr>
				<td>
					<div class="InnerTableContainer">
						<form action="?subtopic=adminpanel&action=pagseguro" method="post">
						<table width="100%">
							<tr>
								<td>
								<b>ID Transação:</b> <input name="id_transacao" value="" maxlenght="36">
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
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div><br>
';
			$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Newsticker</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">
																<tr style="background-color:#D4C0A1;" >
																	<td class="LabelV" >The last one:</td>';
																$get_ticker = $SQL->query("SELECT * FROM `newsticker` ORDER BY `date` DESC LIMIT 1")->fetchAll();
																if (count($get_ticker) > 0)
																	foreach($get_ticker as $ticker)
																		$main_content .= '
																			<td style="width:90%;" >
																				<img src="'.$layout_name.'/images/global/content/'.$ticker['icon'].'_small.gif" style=" vertical-align: middle;"> '.$ticker['text'].'
																				<a href="?subtopic=adminpanel&action=deleteticker&id='.$ticker['id'].'"">Delete</a>
																				<input type="hidden" name="tickerID" value="'.$ticker['id'].'"><br />
																				<small><strong>Posted '.date("M d Y, H:i:s",$ticker['date']).'</strong></small>
																			</td>';
																else
																	$main_content .= '<td style="width:90%;" >No tickers added yet</td>';																
															$main_content .= '
																</tr>
																<tr style="background-color:#F1E0C6;" >
																	<td class="LabelV" >Ticker:<p>MOTD:</p><p>Icon:</p></td>
																	<td>		
																		<form action="?subtopic=adminpanel&action=newticker" method="post" >
																		<table class="TableContent" width="100%">
																			<tr>
																				<td width="100%">
																				<input type="text" name="tickerText" style="width:100%;" placeholder="Max lenght 255 characters" maxlenght="255"></td>
																			</tr>
																			<tr>
																				<td width="100%">
																				<input type="text" name="MOTDText" style="width:100%;" placeholder="Max lenght 255 characters" maxlenght="255"></td>
																			</tr>
																			<tr>
																				<td width="90%">
																					<select name="tickerIcon" style="width:100%;">
																						<option value="">Select an Icon</option>
																						<option value="newsicon_technical">Technical Icon</option>
																						<option value="newsicon_cipsoft">Staff Icon</option>
																						<option value="newsicon_development">Development Icon</option>
																						<option value="newsicon_community">Community Icon</option>
																					</select>
																				</td>
																				<td><input type="submit" value="Add Ticker"></form></td>
																			</tr>
																		</table>																												
																	</td>
																</tr>
															</table>
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
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>';
			
			$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Shop System</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>This Shop system have only four categories: Extra services, Mounts, Outfits and Items. You can activate or desactivate any categorie any time</td>
											</tr>
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">';
															
														$get_Categories = $SQL->query("SELECT * FROM `z_shop_category` ORDER BY `name` ASC");
														$cat_number = 0;
														foreach($get_Categories as $cat) {
															$bgcolor = (($cat_number++ % 2 == 1) ?  $config['site']['lightborder'] : $config['site']['darkborder']);
															$main_content .= '
																	<tr bgcolor="'.$bgcolor.'">
																		<td><strong>'.$cat['name'].'</strong></td>
																		<td width="70%">
																			<a href="#" id="categoryStatus">'.(($cat['hide'] == 0) ? 'Disable' : 'Enable').'</a>
																			<input type="hidden" class="ServiceId" name="ServiceId" value="'.$cat['id'].'">
																		</td>
																		<td>
																			<a '.(($cat['hide'] >= 1) ? 'style="display:none;"' : '').' class="manageAction" href="?subtopic=adminpanel&action=shopmanage&serviceId='.$cat['id'].'">Manage</a>
																		</td>
																	</tr>';
														}
														
														$main_content .= '
															</table>
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
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td align="center">
									<form method="post" action="?subtopic=adminpanel&action=history">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
											<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
												<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_viewhistory.gif" >
											</div>
										</div>
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>
					<center>
						<form method="post" action="?subtopic=accountmanagement">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center>';
			
		}
		if($action == "pagseguro") {
		if(isset($_REQUEST['id_transacao'])) {
			$id_transacao = $_REQUEST['id_transacao'];
			$url = 'https://ws.pagseguro.uol.com.br/v2/transactions/'.$id_transacao.'?email='.$config['pagseguro']['email'].'&token='.$config['pagseguro']['token'];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$executeCurl = curl_exec($curl);
			curl_close($curl);

			$transaction = simplexml_load_string($executeCurl);

			$explodeRef = explode("-",$transaction->reference);
			$ref = $explodeRef[0];
			$acc_name = htmlspecialchars($explodeRef[1]);
			$accInfo = new Account();
			$accInfo->loadByName($acc_name);
			
			$getServiceID = $SQL->query("SELECT `service_id` FROM `z_shop_payment` WHERE `ref` = '$ref'")->fetch();
			$getPointsQtd = $SQL->query("SELECT `points` FROM `z_shop_donates` WHERE `reference` = '$ref' AND `account_name` = '$acc_name'")->fetch();
			$points_bought = $getPointsQtd['points'];
			
			$getPayment = $SQL->query("SELECT COUNT(*) AS count FROM `pagseguro` WHERE `reference` = '".$transaction->reference."'")->fetch();
			
			if($getPayment['count'] > 0)
			{
				$update = $SQL->query("UPDATE `pagseguro` SET `status` = '".$transaction->status."' WHERE `code` = '".$transaction->code."' LIMIT 1");
			}
			else	
			{
				$add = $SQL->query("INSERT INTO `pagseguro` SET `date` = '".$transaction->date."', `code` = '".$transaction->code."', `reference` = '".$transaction->reference."', `type` = '".$transaction->type."', `status` = '".$transaction->status."', `lastEventDate` = '".$transaction->lastEventDate."'");
			}
			
			$checaentrega = $SQL->query("SELECT `status` FROM `z_shop_donates` WHERE `reference` = '$ref' AND `account_name` = '$acc_name'")->fetch();
	
			if ($checaentrega['status'] != 'received')
			{
				if ($transaction->status == 3 || $transaction->status == 4) {
					$accInfo->setPremiumPoints($accInfo->getPremiumPoints() + $points_bought);
					$accInfo->save();
					$update_payment = $SQL->query("UPDATE `z_shop_donates` SET `status` = 'received' WHERE `reference` = '$ref' AND `account_name` = '$acc_name'");
					$info_donation = 'Confirmado, pontos entregues';
				} elseif ($transaction->status == 7) {
					$update_payment = $SQL->query("UPDATE `z_shop_donates` SET `status` = 'canceled' WHERE `reference` = '$ref' AND `account_name` = '$acc_name'");
					$info_donation = 'cancelado';
				} elseif ($transaction->status == 5) {
					if ($checaentrega['status'] == 'received')
					{
						$info_donation = 'Entregue, porém em disputa';
					}
					else
					{
						$info_donation = 'Comprou antes do sistema automático. Assim que cancelar a disputa receberá os coins';
					}
				} else {
					$info_donation = 'Não Confirmado';
				}
			}
			else
			{
				$info_donation = 'Entregue';
			}
			
			$main_content .=
		'<div class="TableContainer" >
			<table class="Table3" cellpadding="0" cellspacing="0" >
				<div class="CaptionContainer" >
					<div class="CaptionInnerContainer" > 
						<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
						<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
						<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
						<div class="Text" >Informações de pagamento</div>
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
									<td><div class="TableShadowContainerRightTop" >
											<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
										</div>
										<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
											<div class="TableContentContainer" >
												<table class="TableContent" width="100%" >
												<tr>
													<td>
														<p><b>Account Name:</b> '.$acc_name.'</p>
														<p><b>Referencia:</b> '.$ref.'</p>
														<p><b>Código Transação:</b> '.$transaction->code.'</p>
														<p><b>Data:</b> '.$transaction->date.'</p>
														<p><b>Status:</b> '.$info_donation.'.</p>
													</td>
												</tr>
												</table>
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
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="SubmitButtonRow" >
						<div class="LeftButton" >
							<form action="?subtopic=adminpanel" method="post" style="padding:0px;margin:0px;" >
								<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
									<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
										<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
									</div>
								</div>
							</form>
						</div>
					</div>
					';
	}
}
		if($action == "newticker") {
					$ticker_text = stripslashes(trim($_POST['tickerText']));
					$ticker_icon = (string) $_POST['tickerIcon'];
					$motd = (string) $_POST['MOTDText'];
					if(empty($ticker_text) || empty($ticker_icon)) {
						$news_content .= 'You can\'t add empty ticker.';
					}
					else
					{
						$SQL->query('INSERT INTO '.$SQL->tableName('newsticker').' (date, icon, text, motd) VALUES ('.$SQL->quote(time()).', '.$SQL->quote($ticker_icon).', '.$SQL->quote($ticker_text).', '.$SQL->quote($motd).')');
					}
					header("location: /?subtopic=adminpanel");
		}
		if($action == "deleteticker") {
			$ticket_id = (int) $_REQUEST['id'];
			$SQL->query('DELETE FROM '.$SQL->tableName('newsticker').' WHERE id = '.$ticket_id.';');
			header("location: /?subtopic=adminpanel");
		}
		if($action == "managenamelocks") {
			if(!isset($_REQUEST['option'])) {
					$main_content .= '<div class="TableContainer" >
					<table class="Table3" cellpadding="0" cellspacing="0" >
						<div class="CaptionContainer" >
							<div class="CaptionInnerContainer" > 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
								<div class="Text" >Namelocks Review</div>
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
											<td><div class="TableShadowContainerRightTop" >
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%" >
																<TR BGCOLOR=#D4C0A1>
																	<TD WIDTH=40%><B>Nome Antigo</B></TD>
																	<TD WIDTH=40%><B>Novo Nome</B></TD>
																	<TD WIDTH=20%><B>Ação</B></TD>
																</TR>';
																$namelocks = $SQL->query("SELECT " . $SQL->fieldName('player_old_name') . ", " . $SQL->fieldName('player_new_name') . " FROM " . $SQL->tableName('player_namelocks') . " WHERE " . $SQL->fieldName('player_new_name') . " != '' and " . $SQL->fieldName('nameunlocked_at') . " = 0");
																foreach($namelocks as $i => $team)
																{
																	$bgcolor = (($i++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																	$main_content .= '<tr bgcolor="'.$bgcolor.'"><td>'.$team['player_old_name'].'</td><td>'.$team['player_new_name'].'</td><td><a href="./?subtopic=adminpanel&action=managenamelocks&oldname='.$team['player_old_name'].'&newname='.$team['player_new_name'].'&option=accept">Aceitar</a> - <a href="./?subtopic=adminpanel&action=managenamelocks&oldname='.$team['player_old_name'].'&newname='.$team['player_new_name'].'&option=reject">Rejeitar</a></td></tr>';
																}
															$main_content .= '
															</table>
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
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div></table>';
			}
			else
			{
				if(isset($_REQUEST['option']) == 'accept') {
					$releasenamelock = $SQL->query("UPDATE `player_namelocks` SET `nameunlocked_at` = 1 WHERE `player_old_name` = '".$_REQUEST['oldname']."'");							
					$updateplayername = $SQL->query("UPDATE `players` SET `name` = '".$_REQUEST['newname']."' WHERE `name` = '".$_REQUEST['oldname']."'");							
					$main_content .=
					'<div class="TableContainer" >
					<table class="Table3" cellpadding="0" cellspacing="0" >
						<div class="CaptionContainer" >
							<div class="CaptionInnerContainer" > 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
								<div class="Text" >Character Namelock</div>
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
											<td><div class="TableShadowContainerRightTop" >
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
													<div class="TableContentContainer" >
														<table class="TableContent" width="100%" >
														<tr>
															<td>
																New name approved.
															</td>
														</tr>
														</table>
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
									</table>
								</div>
							</td>
						</tr>
					</table>
					</div>

					<div class="SubmitButtonRow" >
								<div class="LeftButton" >
									<form action="?subtopic=adminpanel&action=managenamelocks" method="post" style="padding:0px;margin:0px;" >
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
											<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
												<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
											</div>
										</div>
									</form>
								</div>
							</div>';
				}
				else
				{
					$releasenamelock = $SQL->query("UPDATE `player_namelocks` SET `player_new_name` = '' WHERE `player_old_name` = '".$_REQUEST['oldname']."'");							
					$main_content .=
					'<div class="TableContainer" >
					<table class="Table3" cellpadding="0" cellspacing="0" >
						<div class="CaptionContainer" >
							<div class="CaptionInnerContainer" > 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>						
								<div class="Text" >Character Namelock</div>
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
											<td><div class="TableShadowContainerRightTop" >
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
													<div class="TableContentContainer" >
														<table class="TableContent" width="100%" >
														<tr>
															<td>
																New name rejected.
															</td>
														</tr>
														</table>
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
									</table>
								</div>
							</td>
						</tr>
					</table>
					</div>

					<div class="SubmitButtonRow" >
								<div class="LeftButton" >
									<form action="?subtopic=adminpanel&action=managenamelocks" method="post" style="padding:0px;margin:0px;" >
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
											<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
												<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
											</div>
										</div>
									</form>
								</div>
							</div>';
				}
			}
		}
		if($action == "manageplayers") {
			$main_content .= '
				<center>
					<table>
						<tbody>
							<tr>
								<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
								<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage Players</td>
								<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
							</tr>
						</tbody>
					</table>
				</center>
				<br>';
				
			if(!isset($_REQUEST['playerview'])) {
				$main_content .= '
					<form action="" method="post">
						<table width="100%" border="0" cellspacing="1" cellpadding="4">
							<tr>
								<td bgcolor="#505050" class="white"><b>Search Character</b></td>
							</tr>
							<tr>
								<td bgcolor="#D4C0A1">
									<table border="0" cellpading="1">
										<TR>
											<td>Name:</td>
											<td><input name="playerview" value="'.$_REQUEST['playerview'].'" size="29" maxlenght="29"></td>
											<td><input type="image" name="Submit" src="'.$layout_name.'/images/global/buttons/sbutton_submit.gif" border="0" width="120" height="18"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</form>';
			} else {
				$player_name = trim($_REQUEST['playerview']);
				$player = new Player();
				$player->find($player_name);
				if(!$player->isLoaded()) {
					$main_content .= '
							<div class="TableContainer" >
								<table class="Table1" cellpadding="0" cellspacing="0" >
									<div class="CaptionContainer" >
										<div class="CaptionInnerContainer" > 
											<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
											<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
											<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
											<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>							
											<div class="Text" >Player Page Error</div>
											<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
											<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
											<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
											<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										</div>
									</div>
									<tr>
										<td>
											<div class="InnerTableContainer" >
												<table style="width:100%;" >
													<tr>
														<td>The character with name '.$player_name.' doesn\'t exist. Please try again.</td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</div><BR>
							<TABLE BORDER=0 WIDTH=100%>
								<TR>
									<TD ALIGN=center>
										<table border="0" cellspacing="0" cellpadding="0" >
											<form action="?subtopic=adminpanel&action=manageplayers" method="post">
												<tr>
													<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
															<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
																<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
															</div>
														</div>
													</td>
												</tr>
											</form>
										</table>
									</TD>
								</TR>
							</TABLE>';
				} else {
					$main_content .= '
							<div class="TableContainer" >
								<table class="Table5" cellpadding="0" cellspacing="0">
									<div class="CaptionContainer" >
										<div class="CaptionInnerContainer" > 
											<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span> 
											<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span> 
											<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
											<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
											<div class="Text" >'.$player->getName().'</div>
											<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span> 
											<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
											<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span> 
											<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span> 
										</div>
									</div>
									<tr>
										<td>
											<div class="InnerTableContainer">
												<table style="width:100%;" >
													<tr>
														<td>
															<div class="TableShadowContainerRightTop" >
																<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
															</div>
															<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
																<div class="TableContentContainer" >
																	<table class="TableContent" width="100%"  style="border:1px solid #faf0d7;" >
																		<tr>
																			<td class="LabelV">Add Points</td>
																			<td>
																				<input type="number" name="addPoints">
																				<input type="hidden" name="accountPoints" value="'.$player->getAccount()->getName().'">
																				<button type="submit" id="addP" name="addP">Add</button>
																			</td>
																		</tr>
																	</table>
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
												</table>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<TABLE width="100%">
								<tr align="center">
									<td>
										<form action="?subtopic=adminpanel&action=manageplayers" method="post" style="padding:0px;margin:0px;" >
											<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
												<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
													<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
												</div>
											</div>
										</form>
									</td>
								</tr>
							</TABLE>';
				}
			}
		}
		if($action == "history") {
				$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Last 30 transactions made ​​by Points</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">
																<tr bgcolor="#D4C0A1">
																	<td class="LabelV">Purchased Service.</td>
																	<td class="LabelV">Date of purchase</td>
																	<td class="LabelV">Status</td>
																</tr>';
														$get_Orders = $SQL->query("SELECT * FROM `z_shop_payment` WHERE `payment_method_id` = '1' ORDER BY `date` DESC LIMIT 30")->fetchAll();
														$n = 0;
														if(count($get_Orders[0]) > 0)														
															foreach($get_Orders as $order) {
																$bgcolor = (($n++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr bgcolor="'.$bgcolor.'">
																		<td>';
																	$get_historyService = $SQL->query("SELECT `offer_name` FROM `z_shop_offer` WHERE `id` = '".$order['service_id']."'")->fetch();
																	$main_content .= $get_historyService['offer_name'];
																	$main_content .= '
																		</td>
																		<td>'.date("M d Y, H:i:s",$order['date']).'</td>
																		<td>'.$order['status'].'</td>';
																if($order['payment_method_id'] == 3)
																	$main_content .= '
																		<td>'.(($order['status'] == "confirmed") ? '[<a href="?subtopic=adminpanel&action=sendPoints&orderID='.$order['id'].'">view</a>]' : '').'</td>';
																$main_content .= '
																	</tr>';
															}
														else
															$main_content .= '
																<tr bgcolor="'.$config['site']['lightborder'].'">
																	<td colspan="5">No payments yet.</td>
																</tr>';
														$main_content .= '
															</table>
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
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>';
				
				$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Last 30 donates</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">
																<tr bgcolor="#D4C0A1">';
															$get_Orders = $SQL->query("SELECT * FROM `z_shop_donates` ORDER BY `date` DESC LIMIT 30")->fetchAll();
																$main_content .= '
																	<td class="LabelV">Date</td>
																	<td class="LabelV">Service</td>
																	<td class="LabelV">Price</td>																	
																	<td class="LabelV">Method</td>
																	<td class="LabelV">Bank Name</td>
																	<td class="LabelV">Status</td>
																	<td class="LabelV"></td>
																</tr>';
														
														$n = 0;
														if(count($get_Orders[0]) > 0)														
															foreach($get_Orders as $order) {
																$bgcolor = (($n++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr bgcolor="'.$bgcolor.'">
																		<td>'.date("M d Y, G:i:s", $order['date']).'</td>
																		<td>'.$order['points'].' Premium Points</td>
																		<td>'.$order['price'].' BRL</td>
																		<td>'.$order['method'].'</td>';
																		$bankref = explode("-",$order['reference']);
																		$bankName = $bankref[1];
																		$main_content .= '<td>'.$bankName.'</td>';
																$main_content .= '
																		<td>'.$order['status'].'</td>
																		<td>'.(($order['status'] == "confirmed") ? '[<a href="?subtopic=adminpanel&action=sendPoints&orderID='.$order['id'].'">view</a>]' : '').'</td>
																	</tr>';
															}
														else
															$main_content .= '
																<tr bgcolor="'.$config['site']['lightborder'].'">
																	<td colspan="5">No payments yet.</td>
																</tr>';
														$main_content .= '
															</table>
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
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>';
				
			$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Last 40 donates confirmed</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">
																<tr bgcolor="#D4C0A1">';
															$get_OrdersConfirmed = $SQL->query("SELECT * FROM `z_shop_donates` WHERE `status` = 'confirmed' ORDER BY `date` DESC LIMIT 40")->fetchAll();
																$main_content .= '
																	<td class="LabelV">Date</td>
																	<td class="LabelV">Service</td>
																	<td class="LabelV">Price</td>																	
																	<td class="LabelV">Method</td>
																	<td class="LabelV">Bank Name</td>
																	<td class="LabelV">Status</td>
																	<td class="LabelV"></td>
																</tr>';
														
														$n = 0;
														if(count($get_OrdersConfirmed[0]) > 0)														
															foreach($get_OrdersConfirmed as $order) {
																$bgcolor = (($n++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr bgcolor="'.$bgcolor.'">
																		<td>'.date("M d Y, G:i:s", $order['date']).'</td>
																		<td>'.$order['points'].' Premium Points</td>
																		<td>'.$order['price'].' BRL</td>
																		<td>'.$order['method'].'</td>';
																		$bankref = explode("-",$order['reference']);
																		$bankName = $bankref[1];
																		$main_content .= '<td>'.$bankName.'</td>';
																$main_content .= '
																		<td>'.$order['status'].'</td>
																		<td>'.(($order['status'] == "confirmed") ? '[<a href="?subtopic=adminpanel&action=sendPoints&orderID='.$order['id'].'">view</a>]' : '').'</td>
																	</tr>';
															}
														else
															$main_content .= '
																<tr bgcolor="'.$config['site']['lightborder'].'">
																	<td colspan="7">No payments confirmed.</td>
																</tr>';
														$main_content .= '
															</table>
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
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>';
			
			$main_content .= '
				<center>
					<form method="post" action="?subtopic=adminpanel">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
							<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
								<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
							</div>
						</div>
					</form>
				</center>';
		}
		if($action == "sendPoints") {
			if(!isset($_REQUEST['orderID']))
				$points_errors[] = "You must enter the order ID.";
			if(!empty($points_errors)) {
				$main_content .= '
						<div class="TableContainer" >
							<table class="Table1" cellpadding="0" cellspacing="0" >
								<div class="CaptionContainer" >
									<div class="CaptionInnerContainer" > 
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>							
										<div class="Text" >Send Points Errors</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
									</div>
								</div>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>';
													foreach($points_errors as $p_error)
														$main_content .= $p_error . '<br>';
												$main_content .= '
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</div><BR>
						<TABLE BORDER=0 WIDTH=100%>
							<TR>
								<TD ALIGN=center>
									<table border="0" cellspacing="0" cellpadding="0" >
										<form action="?subtopic=adminpanel&action=history" method="post">
											<input type="hidden" name="ServiceCategoryID" value="'.$serviceCategoryID.'" />
											<input type="hidden" name="step" value="1">
											<tr>
												<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
															<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
														</div>
													</div>
												</td>
											</tr>
										</form>
									</table>
								</TD>
							</TR>
						</TABLE>';
			} else {
				
				if($_REQUEST['confirm'] == "yes") {
					
					$orderID = $_REQUEST['orderID'];
					$orderAccount = $_REQUEST['orderAccName'];
					$orderPoints = $_REQUEST['orderPoints'];
					$account_points = new Account();
					$account_points->loadByName($orderAccount);
					
					$newPoints = $account_points->getPremiumPoints() + $orderPoints;
					$account_points->setPremiumPoints($newPoints);
					$account_points->save();
					
					$update_order = $SQL->query("UPDATE `z_shop_donates` SET `status` = 'received' WHERE `id` = '$orderID' AND `account_name` = '".$account_points->getName()."'");
					
					$main_content .= '
						<div class="TableContainer" >
							<table class="Table1" cellpadding="0" cellspacing="0" >
								<div class="CaptionContainer" >
									<div class="CaptionInnerContainer" > 
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>							
										<div class="Text" >Points Sent</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
									</div>
								</div>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>You sent <strong>'.$orderPoints.'</strong> points to account <strong>'.$orderAccount.'</strong>.</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</div><BR>
						<TABLE BORDER=0 WIDTH=100%>
							<TR>
								<TD ALIGN=center>
									<table border="0" cellspacing="0" cellpadding="0" >
										<form action="?subtopic=adminpanel&action=history" method="post">
											<tr>
												<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
															<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
														</div>
													</div>
												</td>
											</tr>
										</form>
									</table>
								</TD>
							</TR>
						</TABLE>';
					
				}elseif($_REQUEST['confirm'] == "no") {
					$orderID = $_REQUEST['orderID'];
					$orderAccount = $_REQUEST['orderAccName'];
					
					$update_order = $SQL->query("UPDATE `z_shop_donates` SET `status` = 'rejected' WHERE `id` = '$orderID' AND `account_name` = '$orderAccount'");
					
					$main_content .= '
						<div class="TableContainer" >
							<table class="Table1" cellpadding="0" cellspacing="0" >
								<div class="CaptionContainer" >
									<div class="CaptionInnerContainer" > 
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>							
										<div class="Text" >Confirmation Rejected</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);" /></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);" ></span> 
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);" /></span>
									</div>
								</div>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>You have rejected this confirmation succefully.</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</div><BR>
						<TABLE BORDER=0 WIDTH=100%>
							<TR>
								<TD ALIGN=center>
									<table border="0" cellspacing="0" cellpadding="0" >
										<form action="?subtopic=adminpanel&action=history" method="post">
											<tr>
												<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
															<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
														</div>
													</div>
												</td>
											</tr>
										</form>
									</table>
								</TD>
							</TR>
						</TABLE>';
					
				} else {
					$orderID = $_REQUEST['orderID'];
					$getpayInfo = $SQL->query("SELECT * FROM `z_shop_donates` WHERE `id` = '$orderID'")->fetch();
					$getorderInfo = $SQL->query("SELECT * FROM `z_shop_donate_confirm` WHERE `donate_id` = '$orderID'")->fetch();
					$getserviceInfo = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `id` = '".$getpayInfo['service_id']."'")->fetch();
					$main_content .= '
						<div class="TableContainer">
							<div class="CaptionContainer">
								<div class="CaptionInnerContainer"> 
									<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
									<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
									<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
									<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
									<div class="Text">Donate Confirmation</div>
									<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
									<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
									<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
									<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								</div>
							</div>
							<table class="Table3" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td>
											<div class="InnerTableContainer" >
												<table style="width:100%;" >
													<tr>
														<td>
															<div class="TableShadowContainerRightTop" >
																<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
															</div>
															<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
																<div class="TableContentContainer" >
																	<table class="TableContent" width="100%">
																		<tr bgcolor="'.$config['site']['darkborder'].'">
																			<td class="LabelV" width="50%">Service</td>
																			<td>'.$getserviceInfo['offer_name'].'</td>
																		</tr>
																		<tr bgcolor="'.$config['site']['lightborder'].'">
																			<td class="LabelV">Buyer\'s Account Name</td>
																			<td>'.$getpayInfo['account_name'].'</td>
																		</tr>
																		<tr bgcolor="'.$config['site']['darkborder'].'">
																			<td class="LabelV">Confirmation</td>
																			<td>"<i>'.$getorderInfo['msg'].'</i>"</td>
																		</tr>
																		<tr bgcolor="'.$config['site']['lightborder'].'">
																			<td class="LabelV">Send '.$getserviceInfo['count'].' points to account '.$getpayInfo['account_name'].' ?</td>
																			<td>																			
																				<table border="0" cellspacing="0" cellpadding="0" >
																					<form action="?subtopic=adminpanel&action=sendPoints" method="post">
																						<input type="hidden" name="orderID" value="'.$orderID.'">
																						<input type="hidden" name="orderAccName" value="'.$getpayInfo['account_name'].'">
																						<input type="hidden" name="orderPoints" value="'.$getserviceInfo['count'].'">
																						<input type="hidden" name="confirm" value="yes">
																						<tr>
																							<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
																								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
																										<input class="ButtonText" type="image" name="Confirm" alt="Confirm" src="'.$layout_name.'/images/global/buttons/_sbutton_confirm.gif" >
																									</div>
																								</div>
																							</td>
																						</tr>
																					</form>
																				</table>
																				<table border="0" cellspacing="0" cellpadding="0" >
																					<form action="?subtopic=adminpanel&action=sendPoints" method="post">
																						<input type="hidden" name="orderID" value="'.$orderID.'">
																						<input type="hidden" name="orderAccName" value="'.$getpayInfo['account_name'].'">
																						<input type="hidden" name="confirm" value="no">
																						<tr>
																							<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																										<input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/global/buttons/_sbutton_cancel.gif" >
																									</div>
																								</div>
																							</td>
																						</tr>
																					</form>
																				</table>																					
																			</td>
																		</tr>
																	</table>
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
												</table>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<TABLE BORDER=0 WIDTH=100%>
								<TR>
									<TD ALIGN=center>
										<table border="0" cellspacing="0" cellpadding="0" >
											<form action="?subtopic=adminpanel&action=history" method="post">
												<tr>
													<td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
															<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
																<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
															</div>
														</div>
													</td>
												</tr>
											</form>
										</table>
									</TD>
								</TR>
							</TABLE>';
				}
			}
		}
		if($action == "shopmanage") {
			if(isset($_REQUEST['serviceId']))
				$serviceId = $_REQUEST['serviceId'];
			else header("Location: ?subtopic=adminpanel");
			
			if ($serviceId == 2) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Managing Extra Services</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
				$main_content .= '
					<p>Below is a list of the extra server services. You can only edit the value, and enable or disable.</p>';
				$main_content .= '
				<div class="TableContainer">
					<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
							<div class="Text">Extra Services</div>
							<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
							<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
						</div>
					</div>
					<table class="Table3" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>
									<div class="InnerTableContainer" >
										<table style="width:100%;" >
											<tr>
												<td>
													<div class="TableShadowContainerRightTop" >
														<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
													</div>
													<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
														<div class="TableContentContainer" >
															<table class="TableContent" width="100%">
																<tr bgcolor="#D4C0A1">
																	<td class="LabelV">Name</td>
																	<td class="LabelV">Price</td>
																	<td class="LabelV">Status</td>
																	<td class="LabelV">*</td>
																</tr>';
															$getExtraServices = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_name` ASC")->fetchAll();
															$offer_number = 0;
															foreach($getExtraServices as $g_extra) {
																if($g_extra['offer_type'] != "changesex")
																$main_content .= '
																	<tr bgcolor="'.$config['site']['lightborder'].'">
																		<td width="46%">'.$g_extra['offer_name'].'</td>
																		<td>
																			<input type="number" name="extraValue" value="'.$g_extra['points'].'" '.(($g_extra['hide'] == 1) ? 'disabled' : '').'>
																			<input type="submit" name="extraUpdate" id="extraUpdate" value="Update" '.(($g_extra['hide'] == 1) ? 'disabled' : '').'>
																			<input type="hidden" name="offerID" value="'.$g_extra['id'].'">
																		</td>
																		<td class="settingStatus">'.(($g_extra['hide'] == 0) ? '<font style="color:green;">Enabled</font>' : '<font style="color:red;">Disabled</font>').'</td>
																		<td><a href="#" id="extraStatus">'.(($g_extra['hide'] == 0) ? 'Disable' : 'Enable').'</a></td>
																	</tr>';
															}
														$main_content .= '
															</table>
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
											<tr>
												<td>*Extra services have their prices on premium points.</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div><br>
				<div class="msgStatus" style="color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303; display:none;"></div><br>
				<center>
					<form method="post" action="?subtopic=adminpanel">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
							<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
								<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
							</div>
						</div>
					</form>
				</center><br>';
			}
			
			if($serviceId == 3) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage your Mounts Sales</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
				
				$main_content .= '
					<div class="mountStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;"></div>
					<div class="mountStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;"></div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Adding New Mount</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Select Mount</td>
																		<td class="LabelV">Points</td>
																	</tr>
																	<tr style="background-color:'.$config['site']['lightborder'].';" >
																		<td>
																			<select name="selectMount">
																				<option value="">Select an Mount</option>';
																		$mountsList = simplexml_load_file($config['site']['serverPath'].'/data/XML/mounts.xml'); //carrega o arquivo XML e retornando um Array
																		foreach($mountsList->mount as $mlist)
																			$main_content .= '
																				<option value="'.$mlist['id'].','.$mlist['name'].'">'.$mlist['name'].'</option>';
																		
																		$main_content .= '
																			</select>
																		</td>
																		<td><input type="number" name="mountPrice"></td>
																	</tr>
																</table>
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
												<tr>
													<td>
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
															<input id="mountSubmit" class="ButtonText" type="image" name="mountSubmit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif" >
														</div>
													</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br>
					<center>
						<form method="post" action="?subtopic=adminpanel">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center><br>';
				$main_content .= '
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Mounts list sale</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">*</td>
																		<td class="LabelV">Mount Name</td>
																		<td class="LabelV">Price</td>
																		<td class="LabelV">*</td>
																	</tr>';
															$get_Mounts = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_date` DESC")->fetchAll();
															$mount_number = 0;
															foreach($get_Mounts as $g_mount) {
																$bgcolor = (($mount_number++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr style="background-color:'.$bgcolor.';">
																		<td width="64px"><img src="'.$layout_name.'/images/shop/mounts/'.str_replace(" ","_",$g_mount['offer_name']).'.gif"</td>
																		<td>'.$g_mount['offer_name'].'</td>
																		<td>'.$g_mount['points'].' Points</td>
																		<td width="135px">
																			<form id="delMount" method="post" style="padding:0px;margin:0px;" >
																				<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																					<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																						<input type="hidden" class="delMountId" name="delMountId" value="'.$g_mount['id'].'">
																						<input class="ButtonText delOutfit" type="image" name="Delete" alt="Delete" src="'.$layout_name.'/images/global/buttons/_sbutton_delete.gif" >
																					</div>
																				</div>
																			</form>
																		</td>
																	</tr>';
															}
															$main_content .= '
																</table>
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
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
			}
			if ($serviceId == 4) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage your Outfit Sales</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
				$main_content .= '
					<div class="msgStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;">Success !</div>
					<div class="msgStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;">Error !</div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Adding New Outfit</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Select Outfit</td>
																		<td class="LabelV">Points</td>
																	</tr>
																	<tr style="background-color:'.$config['site']['lightborder'].';" >
																		<td>
																			<select name="selectOutfit">
																				<option value="">Select an Outfit</option>';
																		$outfitsList = simplexml_load_file($config['site']['serverPath'].'/data/XML/outfits.xml'); //carrega o arquivo XML e retornando um Array
																		foreach($outfitsList->outfit as $olist) {
																			if ($olist['type'] == 0)
																			$main_content .= '
																				<option value="'.$olist['name'].'">'.$olist['name'].'</option>';
																		}
																		$main_content .= '
																			</select>
																		</td>
																		<td><input type="number" name="outfitPrice"></td>
																	</tr>
																</table>
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
												<tr>
													<td>
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
															<input id="outfitSubmit" class="ButtonText" type="image" name="outfitSubmit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif" >
														</div>
													</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br>
					<center>
						<form method="post" action="?subtopic=adminpanel">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center><br>';
				$main_content .= '
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Outfits list sale</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">*</td>
																		<td class="LabelV">Ouftit Name</td>
																		<td class="LabelV">Price</td>
																		<td class="LabelV">*</td>
																	</tr>';
															$get_Outfits = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_date` DESC")->fetchAll();
															$outfit_number = 0;
															foreach($get_Outfits as $g_out) {
																$bgcolor = (($outfit_number++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr style="background-color:'.$bgcolor.';" >
																		<td width="64px"><img src="'.$layout_name.'/images/shop/outfits/'.strtolower(str_replace(" ","_",$g_out['addon_name'])).'_male.gif"</td>
																		<td>'.$g_out['addon_name'].'</td>
																		<td>'.$g_out['points'].' Points</td>
																		<td width="135px">
																			<form id="delOutfit" method="post" style="padding:0px;margin:0px;" >
																				<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																					<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																						<input type="hidden" class="delOutfitId" name="delOutfitId" value="'.$g_out['id'].'">
																						<input class="ButtonText delOutfit" type="image" name="Delete" alt="Delete" src="'.$layout_name.'/images/global/buttons/_sbutton_delete.gif" >
																					</div>
																				</div>
																			</form>
																		</td>
																	</tr>';
															}
															$main_content .= '
																</table>
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
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
			}
			if($serviceId == 5) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage your Items Sales</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
					
				$main_content .= '
					<div class="msgStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;"></div>
					<div class="msgStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;"></div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Adding New Item</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Item ID *</td>
																		<td class="LabelV">Item Name *</td>
																		<td class="LabelV">Item Description</td>
																		<td class="LabelV">Amount *</td>
																		<td class="LabelV">Points *</td>
																	</tr>
																	<tr bgcolor="'.$config['site']['lightborder'].'">
																		<td><input type="number" name="itemID" placeholder="Item Id"></td>
																		<td><input type="text" name="itemName" placeholder="Item Name"></td>
																		<td><input type="text" name="itemDesc" placeholder="Item Name" maxlenght="255"></td>
																		<td><input type="number" name="itemAmount" placeholder="Amount"></td>
																		<td><input type="number" name="itemPrice" placeholder="Item Price"></td>
																	</tr>
																</table>
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
												<tr>
													<td>
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
															<input id="itemSubmit" class="ButtonText" type="image" name="itemSubmit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif" >
														</div>
													</div>
													</td>
												</tr>
												<tr>
													<td>(*) Required fields</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br>
					<center>
						<form method="post" action="?subtopic=adminpanel">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center><br>';
					
				$main_content .= '
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Items list sale</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">*</td>
																		<td class="LabelV">Item ID</td>
																		<td class="LabelV">Item Name</td>
																		<td class="LabelV">Item Description</td>
																		<td class="LabelV">Price</td>
																		<td class="LabelV">*</td>
																	</tr>';
															$get_Items = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_date` DESC")->fetchAll();
															$item_number = 0;
															foreach($get_Items as $g_item) {
																$bgcolor = (($item_number++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr style="background-color:'.$bgcolor.';" >
																		<td width="32px"><img src="'.$layout_name.'/images/shop/items/'.strtolower($g_item['itemid']).'.gif"</td>
																		<td>'.$g_item['itemid'].'</td>
																		<td>'.$g_item['offer_name'].'</td>
																		<td>'.((!empty($g_item['offer_description'])) ? $g_item['offer_description'] : 'No description').'</td>
																		<td>'.$g_item['points'].' Points</td>																		
																		<td width="135px">
																			<form id="delItem" method="post" style="padding:0px;margin:0px;" >
																				<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																					<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																						<input type="hidden" class="delItemId" name="delItemId" value="'.$g_item['id'].'">
																						<input class="ButtonText delItem" type="image" name="Delete" alt="Delete" src="'.$layout_name.'/images/global/buttons/_sbutton_delete.gif" >
																					</div>
																				</div>
																			</form>

																		</td>
																	</tr>';
															}
															$main_content .= '
																</table>
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
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
			}
			if ($serviceId == 6) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage your premium points packages</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
				$main_content .= '<p>You must add a package of premium points for your player can buy products in your shop.</p>';
				$main_content .= '
					<div class="msgStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;"></div>
					<div class="msgStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;"></div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Adding new package of premium points</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Amount of points *</td>
																		<td class="LabelV">Price (R$) *</td>
																		<td class="LabelV">Description</td>
																	</tr>
																	<tr bgcolor="'.$config['site']['lightborder'].'">
																		<td><input type="number" name="pointsAmount" placeholder="Amount of points"></td>
																		<td><input id="campoMoney" type="text" name="pointsPrice" placeholder="Price Ex. 10.00"></td>
																		<td><input type="text" name="pointsDesc" placeholder="Points short description" maxlenght="255"></td>
																	</tr>
																</table>
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
												<tr>
													<td>
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
															<input id="pointsSubmit" class="ButtonText" type="image" name="pointsSubmit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif" >
														</div>
													</div>
													</td>
												</tr>
												<tr>
													<td>(*) Required fields.</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br>
					<center>
						<form method="post" action="?subtopic=adminpanel">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center><br>';
				$main_content .= '
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Premium points list sale</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Amount of points</td>
																		<td class="LabelV">Price</td>
																		<td class="LabelV">Description</td>
																		<td class="LabelV">*</td>
																	</tr>';
															$get_Points = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_date` DESC")->fetchAll();
															$points_number = 0;
															foreach($get_Points as $g_point) {
																$bgcolor = (($points_number++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr style="background-color:'.$bgcolor.';" >
																		<td>'.$g_point['count'].' points</td>
																		<td>R$ '.number_format($g_point['price'],2,',','.').'</td>
																		<td>'.((!empty($g_point['offer_description'])) ? $g_point['offer_description'] : 'No description').'</td>																	
																		<td width="135px">
																			<form id="delPoint" method="post" style="padding:0px;margin:0px;" >
																				<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																					<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																						<input type="hidden" class="delPointId" name="delPointId" value="'.$g_point['id'].'">
																						<input class="ButtonText delPoint" type="image" name="Delete" alt="Delete" src="'.$layout_name.'/images/global/buttons/_sbutton_delete.gif" >
																					</div>
																				</div>
																			</form>

																		</td>
																	</tr>';
															}
															$main_content .= '
																</table>
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
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
			}
			if($serviceId == 11) {
				$main_content .= '
					<center>
						<table>
							<tbody>
								<tr>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-left.gif"></td>
									<td style="text-align:center;vertical-align:middle;horizontal-align:center;font-size:17px;font-weight:bold;">Manage your Items Sales</td>
									<td><img src="'.$layout_name.'/images/global/content/headline-bracer-right.gif"></td>
								</tr>
							</tbody>
						</table>
					</center>
					<br>';
					
					if(isset($_REQUEST['itemID'])) {
						
						$add = $SQL->query("INSERT INTO `z_shop_offer`(`category`, `points`, `offer_description`, `offer_name`, `type`, `exclusive`, `count`, `param1`, `param2`, `offer_date`) VALUES (11,'".$_REQUEST['itemPrice']."','".$_REQUEST['itemDesc']."','".$_REQUEST['itemName']."',1,0,'".$_REQUEST['itemAmount']."','".$_REQUEST['itemID']."','".$_REQUEST['itemLVL']."','".date()."')");
						
						$main_content .= '
					<div class="msgStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;"></div>
					<div class="msgStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;"></div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Item Added</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														Item adicionado ao shop com sucesso.
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br><br>';
					}
					
				$main_content .= '
					<div class="msgStatusSuccess" style="text-align:center;color:green; padding: 5px; background:#c2f4b2; border:1px solid #165303;margin-bottom:15px;display:none;"></div>
					<div class="msgStatusError" style="text-align:center;color:red; padding: 5px; background:#e59d9d; border:1px solid red;margin-bottom:15px;display:none;"></div>
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Adding New Item</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<form method="post" action="?subtopic=adminpanel&action=shopmanage&serviceId=11">
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">Item ID *</td>
																		<td class="LabelV">Item Name *</td>
																		<td class="LabelV">Item Description</td>
																		<td class="LabelV">Amount *</td>
																		<td class="LabelV">Points *</td>
																		<td class="LabelV">Level *</td>
																	</tr>
																	<tr bgcolor="'.$config['site']['lightborder'].'">
																		<td><input type="number" name="itemID" placeholder="Item Id" maxlenght="6"></td>
																		<td><input type="text" name="itemName" placeholder="Item Name" maxlenght="25"></td>
																		<td><input type="text" name="itemDesc" placeholder="Item Name" maxlenght="255"></td>
																		<td><input type="number" name="itemAmount" placeholder="Amount"></td>
																		<td><input type="number" name="itemPrice" placeholder="Item Price"></td>
																		<td><input type="number" name="itemLVL" placeholder="Item Level"></td>
																	</tr>
																</table>
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
												<tr>
													<td>
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green.gif)" >
														<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_green_over.gif);" ></div>
															<input id="itemSubmit" class="ButtonText" type="image" name="itemSubmit" alt="Submit" src="'.$layout_name.'/images/global/buttons/_sbutton_submit.gif" >
														</div>
													</div>
													</td>
													</form>
												</tr>
												<tr>
													<td>(*) Required fields</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><br>
					<center>
						<form method="post" action="?subtopic=adminpanel">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton.gif)" >
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_over.gif);" ></div>
									<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/global/buttons/_sbutton_back.gif" >
								</div>
							</div>
						</form>
					</center><br>';
					
				$main_content .= '
					<div class="TableContainer">
						<div class="CaptionContainer">
							<div class="CaptionInnerContainer"> 
								<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span>
								<div class="Text">Items list sale</div>
								<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/global/content/box-frame-vertical.gif);"></span> 
								<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/global/content/table-headline-border.gif);"></span> 
								<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
								<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/global/content/box-frame-edge.gif);"></span> 
							</div>
						</div>
						<table class="Table3" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td>
										<div class="InnerTableContainer" >
											<table style="width:100%;" >
												<tr>
													<td>
														<div class="TableShadowContainerRightTop" >
															<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rt.gif);" ></div>
														</div>
														<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/global/content/table-shadow-rm.gif);" >
															<div class="TableContentContainer" >
																<table class="TableContent" width="100%">
																	<tr style="background-color:#D4C0A1;" >
																		<td class="LabelV">*</td>
																		<td class="LabelV">Item ID</td>
																		<td class="LabelV">Item Name</td>
																		<td class="LabelV">Item Description</td>
																		<td class="LabelV">Price</td>
																		<td class="LabelV">Level</td>
																		<td class="LabelV">*</td>
																	</tr>';
															$get_Items = $SQL->query("SELECT * FROM `z_shop_offer` WHERE `category` = '$serviceId' ORDER BY `offer_date` DESC")->fetchAll();
															$item_number = 0;
															foreach($get_Items as $g_item) {
																$bgcolor = (($item_number++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
																$main_content .= '
																	<tr style="background-color:'.$bgcolor.';" >
																		<td width="32px"><img src="'.$layout_name.'/images/shop/items/'.strtolower($g_item['param1']).'.gif"</td>
																		<td>'.$g_item['param1'].'</td>
																		<td>'.$g_item['offer_name'].'</td>
																		<td>'.((!empty($g_item['offer_description'])) ? $g_item['offer_description'] : 'No description').'</td>
																		<td>'.$g_item['points'].' Points</td>																		
																		<td>Level '.$g_item['param2'].'</td>																		
																		<td width="135px">
																			<form id="delItem" method="post" style="padding:0px;margin:0px;" >
																				<div class="BigButton" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red.gif)" >
																					<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/global/buttons/sbutton_red_over.gif);" ></div>
																						<input type="hidden" class="delItemId" name="delItemId" value="'.$g_item['id'].'">
																						<input class="ButtonText delItem" type="image" name="Delete" alt="Delete" src="'.$layout_name.'/images/global/buttons/_sbutton_delete.gif" >
																					</div>
																				</div>
																			</form>

																		</td>
																	</tr>';
															}
															$main_content .= '
																</table>
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
											</table>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
			}
		}
	}
	else
	{
		header("location: /");
	}
}
else
{
	header("location: /");
}