<?php
$paypal_report_url = 'http://relembra-global.com/ipn/ipn.php'; // <-- url to ipn
$paypal_return_url = 'http://relembra-global.com/index.php?subtopic=donate&action=pag_form'; // shop
$paypal_image = 'http://i.imgur.com/5rvyyFP.png';
$paypal_payment_type = '_xclick'; // '_xclick' (Buy Now) or '_donations'

$paypals[0]['mail'] = 'contato.relembraglobal@gmail.com'; // your paypal MAIL
$paypals[0]['name'] = 'Receba 10 Tibia Coins ao Doar R$10,00';
$paypals[0]['money_amount'] = '0.3';
$paypals[0]['money_currency'] = 'BRL'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
$paypals[0]['coins'] = 10;

$paypals[1]['mail'] = 'contato.relembraglobal@gmail.com'; // your paypal MAIL
$paypals[1]['name'] = 'Receba 20 Tibia Coins ao Doar R$20,00';
$paypals[1]['money_amount'] = '20';
$paypals[1]['money_currency'] = 'BRL'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&c1ntent_ID=developer/e_howto_api_nvp_currency_codes
$paypals[1]['coins'] = 20;

$paypals[2]['mail'] = 'contato.relembraglobal@gmail.com'; // your paypal MAIL
$paypals[2]['name'] = 'Receba 40 Tibia Coins ao Doar R$40,00';
$paypals[2]['money_amount'] = '40';
$paypals[2]['money_currency'] = 'BRL'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
$paypals[2]['coins'] = 40;

$paypals[3]['mail'] = 'contato.relembraglobal@gmail.com'; // your paypal login
$paypals[3]['name'] = 'Receba 100 Tibia Coins ao Doar R$80,00';
$paypals[3]['money_amount'] = '80';
$paypals[3]['money_currency'] = 'BRL'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
$paypals[3]['coins'] = 100;

$paypals[4]['mail'] = 'contato.relembraglobal@gmail.com'; // your paypal MAIL
$paypals[4]['name'] = 'Receba 250 Tibia Coins ao Doar R$160,00';
$paypals[4]['money_amount'] = '160';
$paypals[4]['money_currency'] = 'BRL'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
$paypals[4]['coins'] = 250;