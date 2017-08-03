<?PHP
 
 
$main_content .= '
<b>SMS DONATION</b></CENTER><br /><br />
 
<ol>
       <li>Enter your account name.</li>
       <li>Choose your payment price.</li>
       <li>Click on the red Pay by mobile button.</li>
       <li>Follow the instructions.</li>
       <li>Your points will be added automatically.</li>
        <li>DONT FORGET TO PUT IN YOUR ACCOUNT NAME! IF YOU DONT DO IT YOU WONT GET ANY POINTS!</li>
        <li>IF YOU FORGET TO PUT IN YOUR ACCOUNT NAME ANY STAFF WONT GIVE YOU POINTS!</li>
 
</ol>
</br>
<center><b>
<li>10 Tibia Coins for 5 EUR</li>
<li>20 Tibia Coins for 8 EUR</li>
<li>30 Tibia Coins for 12 EUR</li>
</center></b>
 
</br>
';
 
$main_content .= '<center>
<!-- PayGol JavaScript -->
<script src="http://www.paygol.com/micropayment/js/paygol.js" type="text/javascript"></script>
 
<!-- PayGol Form -->
<form name="pg_frm">
<h1>Enter account name:</h1><p>
<input type="text" name="pg_custom" value=""><p>
<input type="hidden" name="pg_serviceid" value="49001">
<input type="hidden" name="pg_currency" value="EUR">
<input type="hidden" name="pg_name" value="Premium Points">
 
<!-- With Option buttons -->
<input type="radio" name="pg_price" value="1"checked>10 Tibia Coins For 5 Euro<p>
<input type="radio" name="pg_price" value="2">20 Tibia Coins For 8 Euro<p>
<input type="radio" name="pg_price" value="3">30 Tibia Coins For 12 Euro<p>
<input type="hidden" name="pg_return_url" value="http://relembra-global.com/index.php?subtopic=shopsystem">
<input type="hidden" name="pg_cancel_url" value="">
<input type="image" name="pg_button" class="paygol" src="http://www.paygol.com/micropayment/img/buttons/125/red_en_pbm.png" border="0" alt="Make payments with PayGol: the easiest way!" title="Make payments with PayGol: the easiest way!" onClick="pg_reDirect(this.form)">
</form>  </center>';
 
?>