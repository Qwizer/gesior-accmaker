<div id="DeactivationContainer" onclick="ActivateWebsiteFrame();$('.LightBoxContentToHide').css('display', 'none');"></div>
<?php
if(!defined('INITIALIZED'))
    exit;

$orderby = 'name';
if(isset($_REQUEST['order']))
{
    if($_REQUEST['order']== 'level')
        $orderby = 'level';
    elseif($_REQUEST['order'] == 'vocation')
        $orderby = 'vocation';
}
$players_online_data = $SQL->query('SELECT ' . $SQL->tableName('accounts') . '.' . $SQL->fieldName('flag') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('name') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('vocation') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('level') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('skull') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('looktype') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookaddons') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookhead') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookbody') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('looklegs') . ', ' . $SQL->tableName('players') . '.' . $SQL->fieldName('lookfeet') . ' FROM ' . $SQL->tableName('accounts') . ', ' . $SQL->tableName('players') . ', ' . $SQL->tableName('players_online') . ' WHERE ' . $SQL->tableName('players') . '.' . $SQL->fieldName('id') . ' = ' . $SQL->tableName('players_online') . '.' . $SQL->fieldName('player_id') . ' AND ' . $SQL->tableName('accounts') . '.' . $SQL->fieldName('id') . ' = ' . $SQL->tableName('players') . '.' . $SQL->fieldName('account_id') . ' ORDER BY ' . $SQL->fieldName($orderby))->fetchAll();
$number_of_players_online = 0;
$vocations_online_count = array(0,0,0,0,0); // change it if you got more then 5 vocations
$players_rows = '';
foreach($players_online_data as $player)
{
    $bgcolor = (($number_of_players_online++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
}
if($number_of_players_online == 0)
{
    //server status - server empty
    $main_content .= '';
}
else
{

}
?>
<?php
if(!defined('INITIALIZED'))
	exit;
?>

<?php date_default_timezone_set('America/Sao_Paulo'); ?>

<head>
<!-- Hotjar Tracking Code for relembra-global.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:552497,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<!-- Start of relembra Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(e){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var e=this.createElement("script");n&&(this.domain=n),e.id="js-iframe-async",e.src="https://assets.zendesk.com/embeddable_framework/main.js",this.t=+new Date,this.zendeskHost="relembra.zendesk.com",this.zEQueue=a,this.body.appendChild(e)},o.write('<body onload="document._l();">'),o.close()}();
/*]]>*/</script>
<!-- End of relembra Zendesk Widget script -->
  <title>Relembra-Global - Free Multiplayer Online Role Playing Game</title>
  <meta name="description" content="<?PHP echo $title ?> Alternative Tibia Server, Otserv(Tibia) é um jogo multiplayer online (MMORPG). Participe deste jogo fascinante que tem milhares de fãs de todo o mundo! -- http://www.farmera-global.com" />
  <meta name="author" content="Gesior" />
  <meta http-equiv="content-language" content="en" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="keywords" content="Global, Servidor de otserv, Servidor de tibia, jogo gratis, jogo legal, free online game, free multiplayer game, free online rpg, free mmorpg, mmorpg, mmog, online role playing game, online multiplayer game, internet game, online rpg, rpg,tibia, br, tibiabr, downloads, magias, magic, brasil, tibiabrasil, macetes, dicas, tibiagg, mapas, rpg, graphical mud, rpg, game, fantasy, medieval, roleplaying game, mmorpg, massively multiplayer, online game, persistent online game, online world, persistent online world, massively multi-user, massively multi user, multi-user-dungeon, multiuser dungeon, internet game, online spiel, internet spiel, rollenspiel, multiplayer spiel, multiplayer game, free game, kostenloses spiel, free internet game, free online game, Página Inicial" />
  <link rel="shortcut icon" href="<?PHP echo $layout_name; ?>/images/server.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <?PHP echo $layout_header; ?>
  <link href="<?PHP echo $layout_name; ?>/basic.css" rel="stylesheet" type="text/css">
  <script type='text/javascript'> var IMAGES=0; IMAGES='<?PHP echo $layout_name; ?>/images'; var g_FormField='';  var LINK_ACCOUNT=0; LINK_ACCOUNT='';</script>
  <script type="text/javascript" src="<?PHP echo $layout_name; ?>/initialize.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
 <style type="text/css">
body,input
    {
    font-family:"Trebuchet ms",arial;font-size:0.9em;
    color:#333;
    }
.spoiler
    {
    border:0px solid #ddd;
    padding:0px;
    }
.spoiler .inner
    {
    border:0px solid #eee;
    padding:3px;margin:3px;
    }
    </style>
    <script type="text/javascript">
function showSpoiler(obj)
    {
    var inner = obj.parentNode.getElementsByTagName("div")[0];
    if (inner.style.display == "none")
        inner.style.display = "";
    else
        inner.style.display = "none";
    }
    </script>
</head>
<body onBeforeUnLoad="SaveMenu();" onUnload="SaveMenu();">

	<div id="ArtworkHelper1">
        		<div id="ArtworkHelper2">
          			<div id="HeaderArtworkDiv" style="background-attachment: fixed; background-repeat: no-repeat; background-image:url(<?php echo $layout_name; ?>/images/header/background-artwork.jpg);"></div>
        		</div>
      		</div>
	
 <div id="fb-root" ></div><script type="text/javascript" >
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 497232093667125, // App ID
      status     : true,              // check login status
      cookie     : true,              // enable cookies to allow the server to access the session
      xfbml      : true               // parse XFBML
    });
    FB.Event.subscribe('auth.login', function() {
      var URLHelper = "?";
      if (window.location.search.replace("?", "").length > 0) {
        URLHelper = "&";
      }
      if (FB_TryLogin == 1) {
        window.location = window.location + URLHelper + "step=facebooktrylogin&wasreloaded=1";
      } else if (FB_TryLogin == 2) {
        window.location = window.location + URLHelper + "page=facebooktrylogin&wasreloaded=1";
      } else {
        window.location = window.location + URLHelper + "wasreloaded=1";
      }
    });
    FB.Event.subscribe('auth.logout', function(a_Response) {
      if (a_Response.status !== 'connected') {
        window.location.href=window.location.href;
      } else {
        /* nothing to do here*/
      }
    });
    FB.Event.subscribe('auth.statusChange', function(response) {
      if (FB_ForceReload == 1 && response.status == "connected") {
        var URLHelper = "?";
        if (window.location.search.replace("?", "").length > 0) {
          URLHelper = "&";
        }
        window.location = window.location + URLHelper + "step=facebooktrylogin&wasreloaded=1";
      }
    });
  };
  (function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
  }(document));
</script>
<script id="_waut80">var _wau = _wau || [];
_wau.push(["tab", "71je8r5pc0j0", "t80", "left-lower"]);
(function() {var s=document.createElement("script"); s.async=true;
s.src="//widgets.amung.us/tab.js";
document.getElementsByTagName("head")[0].appendChild(s);
})();</script>

<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?PHP echo $layout_name; ?>/shop.js"></script>
<a name="top"></a>
<div id="Bodycontainer">
<div id="ContentRow">
<div id="MenuColumn">
<div id="LeftArtwork">
<img src="<?PHP echo $layout_name; ?>/images/header/tibia-logo-artwork-top.png" alt="logoartwork" name="TibiaLogoArtworkTop" id="TibiaLogoArtworkTop" onClick="window.location = '?subtopic=latestnews';" />
</div>
<div id="Loginbox" >
<div id="LoginTop" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-top.gif)" ></div>
<div id="BorderLeft" class="LoginBorder" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif)" ></div>
<div id="LoginButtonContainer" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/loginbox/loginbox-textfield-background.gif)" >
<div id="PlayNowContainer" ><form class="MediumButtonForm" action="?subtopic=accountmanagement" method="post" ><input type="hidden" name="page" value="overview" ><div class="MediumButtonBackground" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/buttons/mediumbutton.gif)" onMouseOver="MouseOverMediumButton(this);" onMouseOut="MouseOutMediumButton(this);" ><div class="MediumButtonOver" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/buttons/mediumbutton-over.gif)" onMouseOver="MouseOverMediumButton(this);" onMouseOut="MouseOutMediumButton(this);" ></div><input class="MediumButtonText" type="image" name="Play Now" alt="Play Now" src="<?PHP echo "$layout_name"; ?>/images/buttons/mediumbutton_playnow.png" /></div></form></div>
</div>
<div class="Loginstatus" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/loginbox/loginbox-textfield-background.gif)" >
<div id="LoginstatusText_1" onClick="LoginstatusTextAction(this);" onMouseOver="MouseOverLoginBoxText(this);" onMouseOut="MouseOutLoginBoxText(this);" ><div id="LoginstatusText_1_1" name="LoginstatusText_1" class="LoginstatusText" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/loginbox/loginbox-font-create-account.gif)" ></div><div id="LoginstatusText_2" class="LoginstatusText" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/loginbox/loginbox-font-create-account-over.gif)" ></div></div>        <div id="ButtonText" ></div>
</div>
<div id="BorderRight" class="LoginBorder" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif)" ></div>
<div id="LoginBottom" class="Loginstatus" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-bottom.gif)" ></div>
</div>
<?PHP
if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
	echo "<div id='SocialLinkup' class='Submenu'>
  <a href='?subtopic=helpdesk'>
    <div id='submenu_ticketspanel' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
      <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
      <div id='ActiveSubmenuItemIcon_ticketspanel' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
      <img class='SocialLinkupLogo' src='https://cdn3.iconfinder.com/data/icons/luchesa-vol-9/128/Report-16.png'>
	  <div class='SubmenuitemLabel'>Tickets Panel</div>
      <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    </div>
  </a>";
  echo "<a href='?subtopic=adminreportsecretpageadm'>
    <div id='submenu_administracao' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
      <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
      <div id='ActiveSubmenuItemIcon_administracao' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
      <img class='SocialLinkupLogo' src='https://cdn0.iconfinder.com/data/icons/bremen/16/administrative-docs.png'>
	  <div class='SubmenuitemLabel'>Reports Painel</div>
      <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    </div>
  </a></div>";
} else {
  echo '<br>';
}
?>
<div id='Menu'>
<div id='MenuTop' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-top.gif);'></div>
<div id='news' class='menuitem'>
<span onClick="MenuItemAction('news')">
  <div class='MenuButton' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/button-background-over.gif);'></div>
      <span id='news_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='news_Icon' class='Icon' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/icon-news.gif);'></div>
      <div id='news_Label' class='Label' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/label-news.gif);'></div>
      <div id='news_Extend' class='Extend' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
<div id='news_Submenu' class='Submenu'>
<a href='?subtopic=latestnews'>
  <div id='submenu_latestnews' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_latestnews' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Latest News</div>
    <div class='RightChain' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=archive'>
  <div id='submenu_archive' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_archive' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>News Archive</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=castsystem'>
  <div id='submenu_castsystem' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_castsystem' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Cast System <img src="./layouts/tibiacom/images/cast.png"></div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=downloads'>
  <div id='submenu_downloads' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_downloads' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'<span style="color: #ffff00;">Baixe Agora! <img src="./layouts/tibiacom/images/download.png"></div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=changelog'>
  <div id='submenu_changelog' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_downloads' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Change Log <img src="./layouts/tibiacom/images/hot2-fix.gif"></div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>

<div id='about' class='menuitem'>
<span onClick="MenuItemAction('about')">
  <div class='MenuButton' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background-over.gif);'></div>
      <span id='about_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='about_Icon' class='Icon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-abouttibia.gif);'></div>
      <div id='about_Label' class='Label' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/label-abouttibia.gif);'></div>
      <div id='about_Extend' class='Extend' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
<div id='about_Submenu' class='Submenu'>
<a href='?subtopic=whatistibia'>
  <div id='submenu_whatistibia' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_whatistibia' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>What Is Tibia?</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=gamefeatures'>
  <div id='submenu_gamefeatures' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_gamefeatures' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Game Features</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>

<div id='community' class='menuitem'>
<span onClick="MenuItemAction('community')">
  <div class='MenuButton' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background-over.gif);'></div>
      <span id='community_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='community_Icon' class='Icon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-community.gif);'></div>
      <div id='community_Label' class='Label' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/label-community.gif);'></div>
      <div id='community_Extend' class='Extend' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/plus.gif);'></div>

    </div>
  </div>
</span>
<div id='community_Submenu' class='Submenu'>
<a href='?subtopic=characters'>
  <div id='submenu_characters' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_characters' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Characters</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>

  </div>
</a>
<a href='?subtopic=whoisonline'>
  <div id='submenu_whoisonline' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_whoisonline' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Who Is Online?</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=rookhighscores'>
  <div id='submenu_rookhighscores' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_rookhighscores' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Rook Highscores</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>

<a href='?subtopic=highscores'>
  <div id='submenu_highscores' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_highscores' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Highscores</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=houses'>
  <div id='submenu_houses' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_houses' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Houses</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=guilds'>
  <div id='submenu_guilds' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>

    <div id='ActiveSubmenuItemIcon_guilds' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Guilds</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=fraggers'>
  <div id='submenu_fraggers' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_fraggers' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Top Fraggers</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=killstatistics'>
  <div id='submenu_killstatistics' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_killstatistics' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Last Kills</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='index.php?subtopic=warantientrosa'>
  <div id='submenu_warantientrosa' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>

    <div id='ActiveSubmenuItemIcon_warantientrosa' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>War Anti-Entrosa <img src="/images/others/red.gif"></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='index.php?subtopic=wars'>
  <div id='submenu_wars' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif);'></div>

    <div id='ActiveSubmenuItemIcon_wars' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Guild Wars</div>
    <div class='RightChain' style='background-image:url(<?PHP echo "$layout_name"; ?>/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>

<?PHP
echo "<div id='forum' class='menuitem'>
         <span onClick=\"MenuItemAction('forum')\">
	 <div class='MenuButton' style='background-image:url(".$layout_name."/images/menu/button-background.gif);'>
	     <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(".$layout_name."/images/menu/button-background-over.gif);'></div>
               <span id='forum_Lights' class='Lights'>
                <div class='light_lu' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
                <div class='light_ld' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
                <div class='light_ru' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
               </span>
               <div id='forum_Icon' class='Icon' style='background-image:url(".$layout_name."/images/menu/icon-forum.gif);'></div>
               <div id='forum_Label' class='Label' style='background-image:url(".$layout_name."/images/menu/label-forum.gif);'></div>
               <div id='forum_Extend' class='Extend' style='background-image:url(".$layout_name."/images/general/plus.gif);'></div>
             </div>
           </div>
          </span>
       <div id='forum_Submenu' class='Submenu'>
          <a href='?subtopic=forum'>
           <div id='submenu_forum' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
             <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
             <div id='ActiveSubmenuItemIcon_forum' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
             <div class='SubmenuitemLabel'>Relembra Forum</div>
             <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
           </div>
          </a>
        </div>
       </div>";
?>

<div id='account' class='menuitem'>
<span onClick="MenuItemAction('account')">
  <div class='MenuButton' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background-over.gif);'></div>
      <span id='account_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='account_Icon' class='Icon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-account.gif);'></div>
      <div id='account_Label' class='Label' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/label-account.gif);'></div>
      <div id='account_Extend' class='Extend' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
<div id='account_Submenu' class='Submenu'>
<a href='?subtopic=accountmanagement'>
  <div id='submenu_accountmanagement' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_accountmanagement' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Account Management</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=createaccount'>
  <div id='submenu_createaccount' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_createaccount' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Create Account</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=downloads'>
  <div id='submenu_downloads' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_downloads' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'<span style="color: red;">Downloads <img src="./layouts/tibiacom/images/download.png"></div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=lostaccount'>
  <div id='submenu_lostaccount' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_lostaccount' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Lost Account?</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
<?PHP
if($config['site']['download_page'])
echo "<a href='?subtopic=download'>
  <div id='submenu_download' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_download' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Downloads</div>
    <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
  </div>
</a>";
?>
</div>
</div>
<div id='support' class='menuitem'>
<span onClick="MenuItemAction('support')">
  <div class='MenuButton' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background-over.gif);'></div>
      <span id='support_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='support_Icon' class='Icon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-support.gif);'></div>
      <div id='support_Label' class='Label' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/label-support.gif);'></div>
      <div id='support_Extend' class='Extend' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
<div id='support_Submenu' class='Submenu'>
  <a href='?subtopic=tibiarules'>
  <div id='submenu_tibiarules' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_tibiarules' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Relembra Rules</div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=donaterules'>
  <div id='submenu_donaterules' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_donaterules' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Donate Rules</div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=team'>
  <div id='submenu_team' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_donaterules' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Support Staff <img src="./layouts/tibiacom/images/group.png"></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>

<div id='library' class='menuitem'>
<span onClick="MenuItemAction('library')">
  <div class='MenuButton' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/button-background-over.gif);'></div>
      <span id='library_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/green-light.gif);'></div>
      </span>
      <div id='library_Icon' class='Icon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-library.gif);'></div>
      <div id='library_Label' class='Label' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/label-library.gif);'></div>
      <div id='library_Extend' class='Extend' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
<div id='library_Submenu' class='Submenu'>
<?PHP
if($config['site']['serverinfo_page'])
echo "<a href='?subtopic=serverinfo'>
  <div id='submenu_serverinfo' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_serverinfo' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Server Info</div>
    <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
  </div>
</a>";
?>
<a href='?subtopic=raids'>
  <div id='submenu_raids' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_raids' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Raids</div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=reward'>
  <div id='submenu_reward' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_reward' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Reward System <font color="yellow"> [new] </font></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=preysystem'>
  <div id='submenu_preysystem' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_preysystem' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Prey System <font color="yellow"> [new] </font></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=imbui'>
  <div id='submenu_imbui' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_imbui' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Imbuiment <font color="yellow"> [new] </font></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=experiencetable'>
  <div id='submenu_experiencetable' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_experiencetable' class='ActiveSubmenuItemIcon' style='background-image:url(<?PHP echo $layout_name; ?>/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Experience Table</div>
    <div class='RightChain' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>
<div id='events' class='menuitem'>
<span onClick="MenuItemAction('events')">
  <div class='MenuButton' style='background-image:url(./layouts/tibiacom/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(./layouts/tibiacom/images/menu/button-background-over.gif);'></div>
      <span id='events_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(./layouts/tibiacom/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(./layouts/tibiacom/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(./layouts/tibiacom/images/menu/green-light.gif);'></div>
      </span>
      <div id='events_Icon' class='Icon' style='background-image:url(./layouts/tibiacom/images/menu/icon-events.gif);'></div>
      <div id='events_Label' class='Label' style='background-image:url(./layouts/tibiacom/images/menu/label-events.gif);'></div>
      <div id='events_Extend' class='Extend' style='background-image:url(./layouts/tibiacom/images/general/plus.gif);'></div>
    
	</div>
  </div>
</span>
<div id='events_Submenu' class='Submenu'>
<a href='?subtopic=battlefield'>
  <div id='submenu_battlefield' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_battlefield' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Battlefield  <img src="./layouts/tibiacom/images/hot2-fix.gif"></div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=zombie'>
  <div id='submenu_zombie' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_zombie' class='ActiveSubmenuItemIcon' style='background-image:url(./layouts/tibiacom/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Zombie</div>
    <div class='RightChain' style='background-image:url(./layouts/tibiacom/images/general/chain.gif);'></div>
  </div>
</a>
</div>
</div>

<?PHP
if($config['site']['shop_system'])
{
echo "<div id='shops' class='menuitem'>
<span onClick=\"MenuItemAction('shops')\">
  <div class='MenuButton' style='background-image:url(".$layout_name."/images/menu/button-background.gif);'>
    <div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button' style='background-image:url(".$layout_name."/images/menu/button-background-over.gif);'></div>
      <span id='shops_Lights' class='Lights'>
        <div class='light_lu' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
        <div class='light_ld' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
        <div class='light_ru' style='background-image:url(".$layout_name."/images/menu/green-light.gif);'></div>
      </span>
      <div id='shops_Icon' class='Icon' style='background-image:url(".$layout_name."/images/menu/icon-shops.gif);'></div>
      <div id='shops_Label' class='Label' style='background-image:url(".$layout_name."/images/menu/label-shops.gif);'></div>
      <div id='shops_Extend' class='Extend' style='background-image:url(".$layout_name."/images/general/plus.gif);'></div>
    </div>
  </div>
</span>
</div>
<div id='shops_Submenu' class='Submenu'>
<a href='?subtopic=donate'>
  <div id='submenu_donate' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_buypoints' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Donate Now</div>
    <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
  </div>
</a>
<a href='?subtopic=manual'>
  <div id='submenu_manual' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_manual' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'>Manual Store</div>
    <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
  </div>
</a>
";
if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
echo "<a href='?subtopic=shopadmin'>
  <div id='submenu_shopadmin' class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)' onMouseOut='MouseOutSubmenuItem(this)'>
    <div class='LeftChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
    <div id='ActiveSubmenuItemIcon_shopadmin' class='ActiveSubmenuItemIcon' style='background-image:url(".$layout_name."/images/menu/icon-activesubmenu.gif);'></div>
    <div class='SubmenuitemLabel'><font color=red>! Edit/Remove/Add !</font></div>
    <div class='RightChain' style='background-image:url(".$layout_name."/images/general/chain.gif);'></div>
  </div>
</a>";
echo "</div>";
}
?>
<div id='MenuBottom' style='background-image:url(<?PHP echo $layout_name; ?>/images/general/box-bottom.gif);'></div>
</div>
  <script type='text/javascript'>InitializePage();</script></div>
        <div id="ContentColumn">
          <div class="Content">
            <div id="ContentHelper">
			<script type="text/javascript" src="<?PHP echo "$layout_name"; ?>/newsticker.js"></script>
			<?PHP echo "$news_content"; ?>
    <div id="<?PHP echo $subtopic; ?>" class="Box">
    <div class="Corner-tl" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/corner-tl.gif);"></div>
    <div class="Corner-tr" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/corner-tr.gif);"></div>
    <div class="Border_1" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/border-1.gif);"></div>
   <div class="BorderTitleText" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/title-background-green.gif);"></div>
    <div class="Border_2">
      <div class="Border_3">
        <div class="BoxContent" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/scroll.gif);">
	<?PHP echo $main_content; ?>
      </div>
      </div>
    </div>
    <div class="Border_1" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/border-1.gif);"></div>

    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/corner-bl.gif);"></div></div>
    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url(<?PHP echo $layout_name; ?>/images/content/corner-br.gif);"></div></div>
  </div>
           </div>
          </div>
<div id="Footer">
Layout edited by <a href="http://www.tibiaking.com/forum/profile/15111-erimyth/" target="_new"><b>Erimyth</b></a><br />
All rights reserveds Relembra-Global 2017 / 10.00 - 11.00
</div>
</div>
<div id="ThemeboxesColumn">
<div id="RightArtwork">
<img id="Monster" src="layouts/tibiacom/images/gaz.gif"  ';" />
<img id="PedestalAndOnline" src="<?PHP echo "$layout_name"; ?>/images/header/pedestal-and-online.gif" alt="Monster Pedestal and Players Online Box"/>
<?PHP
if(count($config['site']['worlds']) > 1)
$whoisonlineworld = '?subtopic=whoisonline';
else
$whoisonlineworld = '?subtopic=whoisonline&world=0';
?>
<div id="PlayersOnline" onClick="window.location='<?PHP echo "$whoisonlineworld"; ?>'">
          <?PHP
            if($config['status']['serverStatus_online'] == 0)
                echo ''.$number_of_players_online.'<br />Players Online';
            else
                echo '<font color="red"><b>Server<br />OFFLINE</b></font>';
          ?></div>
        </div>
<div id="Themeboxes">
<style type="text/css" media="all">
  .Toplevelbox {
    top: -4px;
    position: relative;
    margin-bottom: 10px;
    width: 180px;
    height: 200px;
  }
  .top_level {
    position: absolute;
    top: 29px;
    left: 6px;
    height: 160px;
    width: 168px;
    z-index: 20;
    text-align: center;
    padding-top: 6px;
    font-family: Tahoma, Geneva, sans-serif;
    font-size: 9.2pt;
    color: #FFF;
    font-weight: bold;
    text-align: right;
    text-decoration: inherit;
    text-shadow: 0.1em 0.1em #333
  }
  #Topbar a {
  text-decoration: none;
  cursor: auto;
  }
  a.topfont {
    font-family: Verdana, Arial, Helvetica;
    font-size: 11px;
        color: #00FF00;
    text-decoration: none
  }
  a:hover.topfont {
    font-family: Verdana, Arial, Helvetica;
    font-size: 11px;
    color: #CCC;
    text-decoration:none
  }
</style>

<script>
$(document).ready(function() {
   // initialize anniversary count down
  var g_Now = Math.floor(new Date().getTime() / 1000);
  {
    // do not display after 10:00:00 07.01.2017 (CET) (1483779600)
    // do not display before 10:00:00 19.12.2016 (CET) (1482138000)
    var g_AnniversaryDate = new Date(2017, 06, 26, 19, 00, 00); // careful! January hat the number "0"
    InitializeFancyAnniversaryCountDown(g_AnniversaryDate);
  }
});
/* ---------------------- */
/* anniversary count down */
/* ---------------------- */
 
//preload images
var g_ImageObject = new Object();
g_ImageObject[0] = new Image();
g_ImageObject[1] = new Image();
g_ImageObject[2] = new Image();
g_ImageObject[3] = new Image();
g_ImageObject[4] = new Image();
g_ImageObject[5] = new Image();
g_ImageObject[6] = new Image();
g_ImageObject[7] = new Image();
g_ImageObject[8] = new Image();
g_ImageObject[9] = new Image();
g_ImageObject[0].src = 'https://s29.postimg.org/9lwla0khz/number_0.png';
g_ImageObject[1].src = 'https://s29.postimg.org/4oj0owiiv/number_1.png';
g_ImageObject[2].src = 'https://s29.postimg.org/ijhb7dcxz/number_2.png';
g_ImageObject[3].src = 'https://s29.postimg.org/gsya5vvev/number_3.png';
g_ImageObject[4].src = 'https://s29.postimg.org/r4amyjn47/number_4.png';
g_ImageObject[5].src = 'https://s29.postimg.org/443zm7paf/number_5.png';
g_ImageObject[6].src = 'https://s29.postimg.org/es7ql1z9j/number_6.png';
g_ImageObject[7].src = 'https://s29.postimg.org/z0v46rykn/number_7.png';
g_ImageObject[8].src = 'https://s29.postimg.org/ayeabwhxj/number_8.png';
g_ImageObject[9].src = 'https://s29.postimg.org/6qo3gw5vr/number_9.png';
 
// calculate remaining time for the anniversary countdown
function getTimeRemaining(a_EndTime) {
  var l_TimeStamp = Date.parse(a_EndTime) - Date.parse(new Date());
  var l_Days = Math.floor(l_TimeStamp / (1000 * 60 * 60 * 24));
  var l_Hours = Math.floor((l_TimeStamp / (1000 * 60 * 60)) % 24);
  var l_Minutes = Math.floor((l_TimeStamp / 1000 / 60) % 60);
  var l_Seconds = Math.floor((l_TimeStamp / 1000) % 60);
  return {
    'total': l_TimeStamp,
    'days': l_Days,
    'hours': l_Hours,
    'minutes': l_Minutes,
    'seconds': l_Seconds
  };
}
 
//initialize the clock for the anniversary countdown
function InitializeFancyAnniversaryCountDown(a_EndTime)
{
  var l_DaysFirst = $('.FancyAnniversaryCountDown .DaysFirst');
  var l_DaysLast = $('.FancyAnniversaryCountDown .DaysLast');
  var l_HoursFirst = $('.FancyAnniversaryCountDown .HoursFirst');
  var l_HoursLast = $('.FancyAnniversaryCountDown .HoursLast');
  var l_MinutesFirst = $('.FancyAnniversaryCountDown .MinutesFirst');
  var l_MinutesLast = $('.FancyAnniversaryCountDown .MinutesLast');
  var l_SecondsFirst = $('.FancyAnniversaryCountDown .SecondsFirst');
  var l_SecondsLast = $('.FancyAnniversaryCountDown .SecondsLast');
 
  function UpdateFancyClock() {
    var l_TimeRemaining = getTimeRemaining(a_EndTime);
    l_DaysFirst.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.days).slice(-2, -1)].src + ')');
    l_DaysLast.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.days).slice(-1)].src + ')');
    l_HoursFirst.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.hours).slice(-2, -1)].src + ')');
    l_HoursLast.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.hours).slice(-1)].src + ')');
    l_MinutesFirst.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.minutes).slice(-2, -1)].src + ')');
    l_MinutesLast.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.minutes).slice(-1)].src + ')');
    l_SecondsFirst.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.seconds).slice(-2, -1)].src + ')');
    l_SecondsLast.css('background-image', 'url(' + g_ImageObject[('0' + l_TimeRemaining.seconds).slice(-1)].src + ')');
    if (l_TimeRemaining.total <= 0) {
    clearInterval(l_IntervalTime);
   }
 }
 
 UpdateFancyClock();
 var l_IntervalTime = setInterval(UpdateFancyClock, 1000);
}
</script>
<style>
#Themeboxes #AnniversaryCountDownBox {
    height: 120px;
}
.Themebox {
    position: relative;
    margin-bottom: 10px;
    width: 180px;
    height: 154px;
}
#Themeboxes div {
    font-size: 10pt;
    background-repeat: no-repeat;
}
#ThemeboxesColumn {
    position: absolute;
    width: 180px;
    filter: alpha(opacity=100);
}
/* ---------------------- */
/* anniversary count down */
/* ---------------------- */
 
.FancyAnniversaryCountDown {
  position: absolute;
  margin-left: 26px;
  margin-top: 50px;
  font-family: courier new;
  color: #5A2800;
  text-align: center;
}
.FancyAnniversaryCountDown .CountDownLabel {
  width: 28px;
  text-align: center;
  font-family: Verdana, Arial, Times New Roman, sans-serif;
  font-size: 8pt !important;
  margin-top: 2px;
}
.FancyAnniversaryCountDown .Number {
  float: left;
  width: 12px;
  text-align: right;
}
.FancyAnniversaryCountDown .NumberSecond {
  margin-left: 1px;
}
.FancyAnniversaryCountDown .Number > span {
  background-repeat: no-repeat;
  display: block;
  height: 21px;
  width: 14px;
}
.FancyAnniversaryCountDown .Separator {
  float: left;
  position: relative;
  display: inline-block;
  top: 2px;
  width: 3px;
  height: 21px;
  margin-left: 3px;
  margin-right: 2px;
}
</style>
<div id="Themeboxes">
<div id="AnniversaryCountDownBox" class="Themebox" style="background-image:url(<?PHP echo $layout_name; ?>/images/themeboxes/tibia-anniversary-countdown.gif);">
        <div class="FancyAnniversaryCountDown">
          <div class="Number NumberFirst"><span class="DaysFirst"></span><div class="CountDownLabel">days</div></div>
          <div class="Number NumberSecond"><span class="DaysLast"></span></div>
          <div class="Separator"></div>
          <div class="Number NumberFirst"><span class="HoursFirst" ></span><div class="CountDownLabel">hrs</div></div>
          <div class="Number NumberSecond"><span class="HoursLast" ></span></div>
          <div class="Separator"></div>
          <div class="Number NumberFirst"><span class="MinutesFirst"></span><div class="CountDownLabel">mins</div></div>
          <div class="Number NumberSecond"><span class="MinutesLast"></span></div>
          <div class="Separator"></div>
          <div class="Number NumberFirst"><span class="SecondsFirst"></span><div class="CountDownLabel">secs</div></div>
          <div class="Number NumberSecond"><span class="SecondsLast"></span></div>
  </div>
  <div class="Bottom" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-bottom.gif);"></div>
</div>		  
<div id="PremiumBox" class="Themebox" style="background-image:url(<?PHP echo $layout_name; ?>/images/themeboxes/premium/premiumbox.gif)">
<div class="ThemeboxButton">
<form action="?subtopic=donate" method="post" style="padding:0px;margin:0px">
<div class="BigButton" style="background-image:url(<?PHP echo $layout_name; ?>/images/buttons/sbutton_green.gif)">
<div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url(<?PHP echo $layout_name; ?>/images/buttons/sbutton_green_over.gif)"></div>
<input class="ButtonText" type="image" name="Get Premium" alt="Get Premium" src="<?PHP echo $layout_name; ?>/images/buttons/_sbutton_getpremium.gif">
</div>
</div>
</form>
</div>
<div class="Bottom" style="background-image:url(<?PHP echo $layout_name; ?>/images/general/box-bottom.gif)"></div>
</div>

<!-- trailer theme box -->
<div id="VideoBox" class="Themebox" style="background-image:url(./layouts/tibiacom/images/header/trailerbox-header.gif); onMouseOver="$('#TrailerOverFrame').css('visibility', 'visible');" onMouseOut="$('#TrailerOverFrame').css('visibility', 'hidden');" onClick="$('#LightBox').toggle();"">
											<div id="VideoBlock" >
												<iframe style="border: 2px solid grey;" width="165" height="82" src="https://www.youtube.com/embed/NZxevDdPBeo"" frameborder="0" allowfullscreen></iframe>
											</div>
											<div class="Bottom" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-bottom.gif);"></div>
										</div>
										<!-- serverinfo box -->
										<div id="ScreenshotBox" class="Themebox" style="background-image:url(<?PHP echo $layout_name; ?>/images/header/serverinfobox.gif);">
											<a href="?subtopic=serverinfo">
												<img id="ScreenshotContent" class="ThemeboxContent" style="padding:0px;margin:0px;" src="<?PHP echo $layout_name; ?>/images/header/serverinfo.gif" alt="Server Info">
											</a>
											<div class="Bottom" style="background-image:url(http://static.tibia.com/images/global/general/box-bottom.gif);"></div>
										</div>
	
<!-- networks theme box -->
<div id="NetworksBox" class="Themebox"  style="background-image:url(<?PHP echo "$layout_name"; ?>/images/themeboxes/networksbox.png);" >
  <div id="FacebookBlock" >
    <div id="FacebookLikeBox" >
      <div class="fb-like-box" data-href="https://www.facebook.com/Relembra-Global-1266956380025404/?ref=br_rs/" data-width="175" data-height="200" data-show-faces="true" data-stream="false" data-border-color="none" data-header="false"></div>
    </div>
    <div id="FacebookSendBox" >
      <div class="fb-send" data-href="https://www.facebook.com/Relembra-Global-1266956380025404/?ref=br_rs/" data-width="50" data-height="20" ></div>
    </div>
    <div id="FacebookLikes" >
      <div class="fb-like" data-href="https://www.facebook.com/Relembra-Global-1266956380025404/?ref=br_rs/" data-width="50" data-layout="standard" data-show-faces="false" ></div>
    </div>
  </div>
  <div id="TwitterBlock" >
    <a href="https://twitter.com" class="twitter-follow-button" data-show-count="false">Follow @doleraglobal</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  </div>
  <div class="Bottom" style="background-image:url(<?PHP echo "$layout_name"; ?>/images/general/box-bottom.gif);"></div>
</div>

<!--<div id="ts3" style="height:190px; width:180px; background-image:url(./layouts/tibiacom/images/themeboxes/teamspeak_themebox.png);">
    <iframe src="/pages/ts3.php" style="background-color: transparent" name="tv" width="190" height="180" scrolling="no" frameborder="0" style="border:0px"></iframe>
</div>
<div class="Bottom" style="background-image:url(./layouts/tibiacom/images/general/box-bottom.gif);"></div>
-->

        </div>
      </div>
     </div>
    </div>
  </div>
</body>
</html>
</html>