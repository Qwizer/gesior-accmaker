<?php
if(!defined('INITIALIZED'))
    exit;

if($logged)
{
    require_once('./custom_scripts/paypal/config.php');


    echo '<style>
    table
    {
    border-collapse:collapse;
    }
    table, td, th
    {
    border:1px solid black;
    }
    </style>';

    echo '<table class="tabelapaypal" text-align="center" cellpadding="5" >

<tr><td colspan="2"><h2>Relembra-Global - PayPal Donation</h2><br><b>Here are the steps you need to make:</b><br>
You will receive points (read: gift) as a thank you, u can spend these points in our online shop system:<ul><li>R$10,00 for 10 points</li><li> R$20,00 for 20 points</li><li> R$40,00 for 40 points</li><li> R$80,00 for 100 points</li><li>R$160,00 for 250 points</li><br>
 
<b>Here are the steps you need to make:</b> <br>
1. A PayPal account with a required balance [10, 20, 40, 80 or 160 Reais] or a creditcard. <br>
2. Fill in your account number. <br>
3. Click on the Buy Now button or your creditcard brand. <br>
4. Make a transaction. <br>
5. After the transaction 10, 20, 40, 100 or 250 points will be automatically added to your account. <br>
6. Go to Item shop and use your points <br> <br> <br> </b>
 
<span style="color:red">Incase u entered a wrong account name, or u didnt receive the donation points, contact us on the Tickets. Include ur Paypal Email in descrition of report.</span>
<center>
<p style="text-align: center;"><img src="http://impactwar.com/images/line.png" alt="" /></p>
<p style="text-align: center;"><img src="http://i.imgur.com/Dv4YRbY.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/a4ushPY.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/cpli9Dm.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/cz1rxut.png" alt="" width="130" height="130" />&nbsp;<img src="http://i.imgur.com/8xbkM8F.png" alt="" width="130" height="130" /></p>
<p style="text-align: center;"><img src="http://impactwar.com/images/line.png" alt="" /></p></b><br /><br /><br /><br /></td></tr></center>
	
    <tr><td style="width:50%; table-layout: fixed; height: 20px;" colspan="2" ><b>Select how much you need donation:</b></td></tr>
	    ';
    foreach($paypals as $paypal)
    {
        echo '<tr "><td><img src="http://i.imgur.com/jEolBSA.png" alt="" width="30" height="30" /> Win ' . $paypal['coins'] . ' Tibia coins if you donate ' . $paypal['money_amount'] . ' ' . $paypal['money_currency'] . '</td><td style="text-align:center"><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="' . $paypal_payment_type . '">
        <input type="hidden" name="business" value="' . $paypal['mail'] . '">
        <input type="hidden" name="item_name" value="' . htmlspecialchars($paypal['name']) . '">
        <input type="hidden" name="custom" value="' . $account_logged->getID() . '">
        <input type="hidden" name="amount" value="' . htmlspecialchars($paypal['money_amount']) . '">
        <input type="hidden" name="currency_code" value="' . htmlspecialchars($paypal['money_currency']) . '">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="notify_url" value="' . $paypal_report_url . '">
        <input type="hidden" name="return" value="' . $paypal_return_url . '">
        <input type="hidden" name="rm" value="0">
        <input type="image" src="' . $paypal_image . '" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
        </form></td></tr> ';


    }
    echo '</table> <br><br><br><br>';
}
else
    echo 'You are not logged in. Login first to Donation.';