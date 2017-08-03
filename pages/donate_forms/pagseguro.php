<?php

$main_content .= '
<table width="100%" border="0" cellpadding="4" cellspacing="1">
	<tbody>
		<tr>
<p style="text-align: center;"><img src="http://impactwar.com/images/line.png" alt=""/></p>
<p style="text-align: center;"><img src="http://i.imgur.com/Dv4YRbY.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/a4ushPY.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/cpli9Dm.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/cz1rxut.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/8xbkM8F.png" alt="" width="130" height="130" /></p>
<p style="text-align: center;"><img src="http://impactwar.com/images/line.png" alt=""/></p>
		<form target="pagseguro" method="post" action="dntpagseguro.php">
			<input type="hidden" name="reference" value="'.$account_logged->getCustomField("name").'">
			<table border="0" cellpadding="4" cellspacing="1" width="100%" id="#estilo">
				<tbody>
					<tr bgcolor="#505050" class="white">
						<th colspan="2"><strong>Escolha a quantidade de pontos que deseja DONATAR.</strong></th>
		</tr>
		<tr bgcolor="#d4c0a1">
						<td width="20%">Account name to Receive Coins:</td>
						<td><strong>'.$account_logged->getCustomField("name").'</strong></td>
					</tr>
					<tr bgcolor="#d4c0a1">
						<td width="60%">How much coins you need? Say me! :</td>
<td><select id="item_valor_1" tabindex="2" name="itemCount">
<option selected="selected">Selecione</option>
<option value="10">R$10,00 - 10 Tibia Coins (No bonus available)</option>
<option value="20">R$20,00 - 20 Tibia Coins (No bonus available)</option>
<option value="40">R$40,00 - 40 Tibia Coins (No bonus available)</option>
<option value="80">R$80,00 - 100 Tibia Coins (Bonus + 20 Tibia Coins)</option>
<option value="160">R$160,00 - 250 Tibia Coins (Bonus + 90 Tibia Coins)</option>
</select></td>
</tr>
			</table>
				<br/>
					<tr bgcolor="#d4c0a1">
						<td colspan="2">
							<input type="image" src="http://i.imgur.com/cCsIn0O.png" name="submit"/>
						</td>
					</tr>
				</tbody>
		</form>
<b><p><span style="color:#ff0000;">OBS:</span></b> Points are delivered <b>automatically</b> after the <u>approved</ u> of your payment by PagSeguro.</u></p><p><b>Attention:</b> To receiver ur Bonus Coins please enter contact to Admin! Using Ticket System</p>
<?php } ?>';
