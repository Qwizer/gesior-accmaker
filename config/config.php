<?PHP
# Account Maker Config
$config['site']['serverPath'] = "C:\Users\user\Desktop\Relembra/fortera/";
$config['site']['useServerConfigCache'] = false;
$towns_list = array(1 => 'Venore', 2 => 'Thais', 3 => 'Kazordoon', 4 => 'Carlin', 5 => 'Ab Dendriel', 6 => 'Rookgaard', 7 => 'Liberty Bay', 8 => 'Port Hope', 9 => 'Ankrahmun', 10 => 'Darashia', 11 => 'Edron', 12 => 'Svargrond', 13 => 'Yalahar', 14 => 'Farmine', 15 => 'Gray Beach', 16 => 'Roshamuul', 30 => 'Rathleton');

$config['site']['outfit_images_url'] = 'http://outfit-images.ots.me/outfit.php';
$config['site']['addons_images_url'] = 'images/addons/';
$config['site']['addons_images_extension'] = '.gif';
$config['site']['mounts_images_url'] = 'images/mounts/';
$config['site']['mounts_images_extension'] = '.gif';
$config['site']['item_images_url'] = '/images/items/';
$config['site']['item_images_extension'] = '.gif';
$config['site']['flag_images_url'] = 'http://flag-images.ots.me/';
$config['site']['flag_images_extension'] = '.png';
$config['site']['serverName'] = 'seu-Global';

$config['lateral']['top_level'] = false;
$config['lateral']['premium_box'] = true;
$config['lateral']['server_info'] = true;
$config['lateral']['videos'] = true;
$config['lateral']['screenshot'] = false;
$config['lateral']['facebook'] = true;
$config['lateral']['facebook_link'] = 'sei-Global';

# Create Account Options
$config['site']['one_email'] = true;
$config['site']['create_account_verify_mail'] = false;
$config['site']['verify_code'] = true;
$config['site']['email_days_to_change'] = 7;
$config['site']['newaccount_premdays'] = 0;
$config['site']['send_register_email'] = true;

# Create Character Options
$config['site']['newchar_vocations'] = array(0 => 'Axzinjbnsa');
$config['site']['newchar_towns'] = array(6);
$config['site']['max_players_per_account'] = 5;


# Emails Config
$config['site']['lost_acc'] = true; # LOST ACC? SIM (TRUE) OU NÃO (FALSE)
$config['site']['send_emails'] = true; # ENVIAR EMAILS? SIM (TRUE) OU NÃO (FALSE)
$config['site']['mail_address'] = "qwizer8@gmail.com"; # SEU EMAIL (TEM QUE SER GMAIL)
$config['site']['smtp_enabled'] = true; # NÃO MUDAR
$config['site']['smtp_host'] = "smtp.gmail.com"; # COLOCAR 'smtp.gmail.com'
$config['site']['smtp_port'] = 587; # tenta a 25 mesmo, se não der tenta 465
$config['site']['smtp_auth'] = true; # não mudar
$config['site']['smtp_user'] = "qwizer8@gmail.com";  # SEU EMAIL (TEM QUE SER GMAIL)
$config['site']['smtp_pass'] = "jfc@0905";  # sua senha


# PAGE: whoisonline.php
$config['site']['private-servlist.com_server_id'] = 1;
/*
Server id on 'private-servlist.com' to show Players Online Chart (whoisonline.php page), set 0 to disable Chart feature.
To use this feature you must register on 'private-servlist.com' and add your server.
Format: number, 0 [disable] or higher
*/

# PAGE: characters.php
$config['site']['quests'] = array();
$config['site']['show_stats_info'] = true;
$config['site']['show_skills_info'] = true;
$config['site']['show_vip_storage'] = 0;

# PAGE: accountmanagement.php
$config['site']['send_mail_when_change_password'] = true;
$config['site']['send_mail_when_generate_reckey'] = true;
$config['site']['generate_new_reckey'] = true;
$config['site']['generate_new_reckey_price'] = 10;

# PAGE: guilds.php
$config['site']['guild_need_level'] = 1;
$config['site']['guild_need_pacc'] = false;
$config['site']['guild_image_size_kb'] = 50;
$config['site']['guild_description_chars_limit'] = 2000;
$config['site']['guild_description_lines_limit'] = 6;
$config['site']['guild_motd_chars_limit'] = 250;

# PAGE: adminpanel.php
$config['site']['access_admin_panel'] = 9999;

$config['lateral']['facebook'] = true;
$config['lateral']['facebook_link'] = 'Relembra';

# PAGE: latestnews.php
$config['site']['news_limit'] = 6;

# PAGE: killstatistics.php
$config['site']['last_deaths_limit'] = 40;

# PAGE: team.php
$config['site']['groups_support'] = array(2, 3, 4, 5, 6);
$config['site']['players_group_id_block'] = 2;

# PAGE: highscores.php
$config['site']['groups_hidden'] = array(4, 5, 6);
$config['site']['accounts_hidden'] = array(1, 9);

# PAGE: shopsystem.php
$config['site']['shop_system'] = true;

#MultiWorld
$config['site']['worlds'] = array(1 => 'Global');
$config['site']['worldsinfo'] = array(1 => array('Global', 'Canada', 'PVP', date("2017")), 2 => array('Owen', 'Canada', 'PVP', date("22/07/2017")));

# PAGE: lostaccount.php
$config['site']['email_lai_sec_interval'] = 180;

# Layout Config
$config['site']['layout'] = 'tibiacom';
$config['site']['vdarkborder'] = '#505050';
$config['site']['darkborder'] = '#D4C0A1';
$config['site']['lightborder'] = '#F1E0C6';
$config['site']['download_page'] = false;
$config['site']['serverinfo_page'] = true;

#SHOP GUILD
$config['site']['shopguild_system'] = 0;
$config['site']['access_adminguild_panel'] = 8347;

############################
##       Paypal Email     ##
############################
$config['paypal']['email'] = 'contato.otserv@gmail.com'; ## EMAIL PAYPAL ##

##Recuperar Donates
$config['pagseguro']['recuperar'] = 0;

# PAGE: donate.php
$config['site']['usePagseguro'] = true; //true show / false hide
$config['site']['usePaypal'] = true;	//true show / false hide
$config['site']['useDeposit'] = false;	//true show / false hide
$config['site']['useZaypay'] = false;	//true show / false hide
$config['site']['useContenidopago'] = false;	//true show / false hide
$config['site']['useOnebip'] = false;	//true show / false hide

# Pagseguro
$config['pagSeguro']['email'] = "contato.otserv@gmail.com"; //Email Pagseguro
$config['pagSeguro']['token'] = "8C745E4138F24081BFE0025263229163"; // TOKEN
$config['pagSeguro']['urlRedirect'] = 'http://seu-global.com/?subtopic=donate&action=final'; //turn off redirect and notifications in pagseguro.com.br
$config['pagSeguro']['urlNotification'] = 'http://seu-global.com/retpagseguro.php'; //your return location

$config['pagSeguro']['productName'] = 'Premium Points';
$config['pagSeguro']['productValue'] = 1.00; 	// 1.50 = R$ 1,50 etc...
$config['pagSeguro']['doublePoints'] = false; 	## Double points - true is on / false is off

$config['pagSeguro']['host'] = 'localhost';		## YOUR HOST
$config['pagSeguro']['database'] = 'SeuOT';	## DATABASE
$config['pagSeguro']['databaseUser'] = 'root';	## USER
$config['pagSeguro']['databasePass'] = 'xxxxx';		## PASSWORD


#############################
######### C A I X A ########
#############################
#! Informações do pagamento com caixa economica federal !#
$config['site']['CaixaCont'] = "
<div class='TableContentAndRightShadow' style='background-image:url(./layouts/tibiacom/images/content/table-shadow-rm.gif);'>
			<div class='TableContentContainer'>
			<table class='TableContent' width='100%' style='border:1px solid #faf0d7;'>
			<tbody><tr bgcolor='#D4C0A1'>
																	
			<td align='center' width='20%'>
						<img src='http://cdn1.mundodastribos.com/49477-Cadastrar-PIS-Via-Internet-Cadastro-PIS-PASEP-da-Caixa-2-600x600.png' width='90px'>															
					</td>
					<td>												
							<b>Caixa</b><br>																
								<strong>Favorecido</strong>: Nome nome.<br>
							<strong>Agencia:</strong> 0000<br>
							<strong>Operacao:</strong> 013<br>
								<strong>Conta:</strong> 0000000-0<br>
							<strong>(<em>Conta Poupança</em>)</strong><br>
					</td>									
				</tr>																													
		</tbody></table>		
	</div>		
</div>
<center><b>Obs:</b> Apos efetuar o pagamento, envie um email para <b><span style='color:red'>always-soft@hotmail.com</span></b><br> contendo os dados do pagamento, account name e nome do character. Seus pontos serao creditados dentro de 24 horas.</center>
"; 

# Seções Shop Gesior Premium
$config['site']['shop_categories'] = array(
	#ITEMS VIPS
	"Items Vips" => array("id" => 1, "description" => "Items donates que so podem ser adquiridos por shop coins.", "new" => 0, "enabled" => true),
	#ITEMS NORMAIS
	"Itens" => array("id" => 2, "description" => "Items para te ajudar na sua jogarda..","new" => 0, "enabled" => true),
    #UTILITARIOS
    "Mounts" => array("id" => 3, "description" => "Torne-se diferenciado.","new" => 0, "enabled" => true),
	#Montarias
    "Outfits" => array("id" => 4, "description" => "Torne-se diferenciado.","new" => 0, "enabled" => true),
);