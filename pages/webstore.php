<?php
if(!defined('INITIALIZED'))
	exit;

$main_content .= "<script type=\"text/javascript\">

  // define data structures
  var g_Services = [8,150,151,152,1518,1519,1520,153,154,155,1500,1501,1502,1506,1507,1508,162,163,164,1503,1504,1505,1512,1513,1514,165,166,167,1515,1516,1517,159,160,161,1509,1510,1511];
  var g_PaymentMethodCategories = {\"1\":11,\"2\":21,\"3\":22,\"5\":31,\"6\":32,\"7\":33,\"8\":40};
  var g_QF_Mounts_ServiceCategoryID = 40;
  var g_QF_Outfits_ServiceCategoryID = 50;

  // change the selected service
  function ChangeService(a_ServiceID, a_ServiceCategoryID)
  {
    // set the ServiceID for the change country form
    $('#CC_ServiceID').val(a_ServiceID);
    $('#CC_ServiceID').attr('name', 'InitialServiceID');
    // activate the radio button itself and set the price
    $('#ServiceID_' + a_ServiceID).attr('checked', 'checked');
    $('.ServiceID_Icon_Container').css('background-color', '');
    // handle mounts
    if (a_ServiceCategoryID == g_QF_Mounts_ServiceCategoryID || a_ServiceCategoryID == g_QF_Outfits_ServiceCategoryID) {
      $('.ServiceID_Icon_Animation_1').hide();
      $('.ServiceID_Icon_New_Animation_1').hide();
      $('.ServiceID_Icon_New').show();
      $('#ServiceID_Icon_Animation_1_' + a_ServiceID).show();
      $('#ServiceID_Icon_New_' + a_ServiceID).hide();
    }
    // handle payment methods
    for (var i = 0; i < g_PaymentMethodCategories.length; i++) {
      if (typeof g_Prices[a_ServiceID] !== 'undefined') {
        if (typeof g_Prices[a_ServiceID][g_PaymentMethodCategories[i]] === 'undefined') {
          // deactivate the payment method
          // note: the radio button can not be disabled or we will receive the wrong error message
          $('#PMCID_NotAllowed_' + g_PaymentMethodCategories[i]).show();
        } else {
          // activate the payment method
          $('#PMCID_NotAllowed_' + g_PaymentMethodCategories[i]).hide();
        }
      }
    }
    // activate and mark the selected icon
    $('.ServiceID_Icon_Selected').css('background-image', '');
    $('#ServiceID_Icon_Selected_' + a_ServiceID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/serviceid_icon_selected.png)');
    return;
  }

  // change the selected payment method category
  function ChangePMC(a_PaymentMethodID)
  {
    // set the PMCID for the change country form
    $('#CC_PMCID').val(a_PaymentMethodID);
    $('#CC_PMCID').attr('name', 'InitialPMCID');
    // activate the radio button
    $('#PMCID_' + a_PaymentMethodID).attr('checked', 'checked');
    $('.PMCID_Icon_Container').css('background-color', '');
    // handle services
    for (var i = 0; i < g_Services.length; i++) {
      if (typeof g_Prices[g_Services[i]] !== 'undefined') {
        if (typeof g_Prices[g_Services[i]][a_PaymentMethodID] === 'undefined') {
          // deactivate the service
          // note: the radio button can not be disabled or we will receive the wrong error message
          $('#ServiceID_NotAllowed_' + g_Services[i]).show();
          // set the price
          $('#PD_' + g_Services[i]).html('---');
        } else {
          // activate the service
          // set the price
          $('#PD_' + g_Services[i]).html(g_Prices[g_Services[i]][a_PaymentMethodID]);
          $('#ServiceID_NotAllowed_' + g_Services[i]).hide();
        }
      }
    }
    // activate and mark the selected icon
    $('.PMCID_Icon_Selected').css('background-image', '');
    $('#PMCID_Icon_Selected_' + a_PaymentMethodID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/pmcid_icon_selected.png)');
    return;
  }

  // mouse over effect for payment methods
  function MouseOverPMCID(a_PMCID)
  {
    $('#PMCID_Icon_Over_' + a_PMCID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/pmcid_icon_over.png)');
  }

  // mouse out effect for payment methods
  function MouseOutPMCID(a_PMCID)
  {
    $('#PMCID_Icon_Over_' + a_PMCID).css('background-image', '');
  }

  // mouse over effect for products
  function MouseOverServiceID(a_ServiceID, a_ServiceCategoryID)
  {
    $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', 'url(' + JS_DIR_IMAGES + 'payment/serviceid_icon_over.png)');
    if (a_ServiceCategoryID == g_QF_Mounts_ServiceCategoryID || a_ServiceCategoryID == g_QF_Outfits_ServiceCategoryID) {
      $('#ServiceID_Icon_Animation_1_' + a_ServiceID).show();
      $('#ServiceID_Icon_New_' + a_ServiceID).hide();
    }
  }

  // mouse out effect for products
  function MouseOutServiceID(a_ServiceID, a_ServiceCategoryID)
  {
    $('#ServiceID_Icon_Over_' + a_ServiceID).css('background-image', '');
    // mounts have an animation
    if ((a_ServiceCategoryID == g_QF_Mounts_ServiceCategoryID || a_ServiceCategoryID == g_QF_Outfits_ServiceCategoryID) && ($('#ServiceID_' + a_ServiceID).attr('checked') != 'checked')) {
      $('#ServiceID_Icon_Animation_1_' + a_ServiceID).hide();
      $('#ServiceID_Icon_New_' + a_ServiceID).show();
    }
  }

</script>";

if($config['site']['shop_system'])
{

if($logged)
	{
		$user_premium_points =  $account_logged->getCustomField('premium_points');
	}
	else
	{
		$user_premium_points = '<font color="red">Login To See Your Tibia Coins!</font>';
	}
if($logged)
	{
		$showuser_premium_points =  'You Have '.$account_logged->getCustomField('premium_points').' Tibia Coins';
	}
	else
	{
		$showuser_premium_points = '<font color="red">Login To Your Tibia Coins!</font>';
	}
	function getItemByID($id)
	{
		$id = (int) $id;
		$SQL = $GLOBALS['SQL'];
		$data = $SQL->query('SELECT * FROM '.$SQL->tableName('z_shop_offer').' WHERE '.$SQL->fieldName('id').' = '.$SQL->quote($id).';')->fetch();
		if($data['offer_type'] == 'item')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'extraservice')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'premiumscroll')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['container_id'] = $data['itemid2'];
			$offer['container_count'] = $data['count2'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'itemvip')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'mount')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'addon')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
		}
		elseif($data['offer_type'] == 'container')
		{
			$offer['id'] = $data['id'];
			$offer['type'] = $data['offer_type'];
			$offer['item_id'] = $data['itemid1'];
			$offer['item_count'] = $data['count1'];
			$offer['container_id'] = $data['itemid2'];
			$offer['container_count'] = $data['count2'];
			$offer['points'] = $data['points'];
			$offer['description'] = $data['offer_description'];
			$offer['name'] = $data['offer_name'];
			$offer['date'] = $data['date'];
			$offer['hot'] = $data['hot'];
			$offer_array['container'][$i_container]['container_id'] = $data['itemid1'];
		}
		return $offer;
	}

	function getOfferArray()
	{
		$offer_list = $GLOBALS['SQL']->query('SELECT * FROM '.$GLOBALS['SQL']->tableName('z_shop_offer').';');
		$i_item = 0;
		$i_extraservice = 0;
		$i_premiumscroll = 0;
		$i_itemvip = 0;
		$i_mount = 0;
		$i_addon = 0;
		$i_container = 0;
		while($data = $offer_list->fetch())
		{
			if($data['offer_type'] == 'item')
			{
				$offer_array['item'][$i_item]['id'] = $data['id'];
				$offer_array['item'][$i_item]['item_id'] = $data['itemid1'];
				$offer_array['item'][$i_item]['item_count'] = $data['count1'];
				$offer_array['item'][$i_item]['points'] = $data['points'];
				$offer_array['item'][$i_item]['description'] = $data['offer_description'];
				$offer_array['item'][$i_item]['name'] = $data['offer_name'];
				$offer_array['item'][$i_item]['date'] = $data['date'];
				$offer_array['item'][$i_item]['hot'] = $data['hot'];
				$i_item++;
			}
			elseif($data['offer_type'] == 'extraservice')
			{
				$offer_array['extraservice'][$i_extraservice]['id'] = $data['id'];
				$offer_array['extraservice'][$i_extraservice]['item_id'] = $data['itemid1'];
				$offer_array['extraservice'][$i_extraservice]['item_count'] = $data['count1'];
				$offer_array['extraservice'][$i_extraservice]['points'] = $data['points'];
				$offer_array['extraservice'][$i_extraservice]['description'] = $data['offer_description'];
				$offer_array['extraservice'][$i_extraservice]['name'] = $data['offer_name'];
				$offer_array['extraservice'][$i_extraservice]['date'] = $data['date'];
				$offer_array['extraservice'][$i_extraservice]['hot'] = $data['hot'];
				$i_extraservice++;
			}
			elseif($data['offer_type'] == 'premiumscroll')
			{
				$offer_array['premiumscroll'][$i_premiumscroll]['id'] = $data['id'];
				$offer_array['premiumscroll'][$i_premiumscroll]['item_id'] = $data['itemid1'];
				$offer_array['premiumscroll'][$i_premiumscroll]['item_count'] = $data['count1'];
				$offer_array['premiumscroll'][$i_premiumscroll]['points'] = $data['points'];
				$offer_array['premiumscroll'][$i_premiumscroll]['description'] = $data['offer_description'];
				$offer_array['premiumscroll'][$i_premiumscroll]['name'] = $data['offer_name'];
				$offer_array['premiumscroll'][$i_premiumscroll]['date'] = $data['date'];
				$offer_array['premiumscroll'][$i_premiumscroll]['hot'] = $data['hot'];
				$i_premiumscroll++;
			}
			elseif($data['offer_type'] == 'itemvip')
			{
				$offer_array['itemvip'][$i_itemvip]['id'] = $data['id'];
				$offer_array['itemvip'][$i_itemvip]['item_id'] = $data['itemid1'];
				$offer_array['itemvip'][$i_itemvip]['item_count'] = $data['count1'];
				$offer_array['itemvip'][$i_itemvip]['points'] = $data['points'];
				$offer_array['itemvip'][$i_itemvip]['description'] = $data['offer_description'];
				$offer_array['itemvip'][$i_itemvip]['name'] = $data['offer_name'];
				$offer_array['itemvip'][$i_itemvip]['date'] = $data['date'];
				$offer_array['itemvip'][$i_itemvip]['hot'] = $data['hot'];
				$i_itemvip++;
			}
			elseif($data['offer_type'] == 'mount')
			{
				$offer_array['mount'][$i_mount]['id'] = $data['id'];
				$offer_array['mount'][$i_mount]['container_id'] = $data['itemid1'];
				$offer_array['mount'][$i_mount]['container_count'] = $data['count1'];
				$offer_array['mount'][$i_mount]['item_id'] = $data['itemid1'];
				$offer_array['mount'][$i_mount]['item_count'] = $data['count2'];
				$offer_array['mount'][$i_mount]['points'] = $data['points'];
				$offer_array['mount'][$i_mount]['description'] = $data['offer_description'];
				$offer_array['mount'][$i_mount]['name'] = $data['offer_name'];
				$offer_array['mount'][$i_mount]['date'] = $data['date'];
				$offer_array['mount'][$i_mount]['hot'] = $data['hot'];
				$i_mount++;
			}
			elseif($data['offer_type'] == 'addon')
			{
				$offer_array['addon'][$i_addon]['id'] = $data['id'];
				$offer_array['addon'][$i_addon]['container_id'] = $data['itemid1'];
				$offer_array['addon'][$i_addon]['container_count'] = $data['count1'];
				$offer_array['addon'][$i_addon]['item_id'] = $data['itemid1'];
				$offer_array['addon'][$i_addon]['item_count'] = $data['count2'];
				$offer_array['addon'][$i_addon]['points'] = $data['points'];
				$offer_array['addon'][$i_addon]['description'] = $data['offer_description'];
				$offer_array['addon'][$i_addon]['name'] = $data['offer_name'];
				$offer_array['addon'][$i_addon]['date'] = $data['date'];
				$offer_array['addon'][$i_addon]['hot'] = $data['hot'];
				$i_addon++;
			}
			elseif($data['offer_type'] == 'container')
			{
				$offer_array['container'][$i_container]['id'] = $data['id'];
				$offer_array['container'][$i_container]['container_id'] = $data['itemid1'];
				$offer_array['container'][$i_container]['container_count'] = $data['count1'];
				$offer_array['container'][$i_container]['item_id'] = $data['itemid2'];
				$offer_array['container'][$i_container]['item_count'] = $data['count2'];
				$offer_array['container'][$i_container]['points'] = $data['points'];
				$offer_array['container'][$i_container]['description'] = $data['offer_description'];
				$offer_array['container'][$i_container]['name'] = $data['offer_name'];
				$offer_array['container'][$i_container]['date'] = $data['date'];
				$offer_array['container'][$i_container]['hot'] = $data['hot'];
				$i_container++;
			}
		}
		return $offer_array;
	}
	if(($action == '') or ($action == 'item') or ($action == 'extraservice') or ($action == 'premiumscroll') or ($action == 'itemvip') or ($action == 'mount') or ($action == 'addon') or ($action == 'container'))
	{
		unset($_SESSION['viewed_confirmation_page']);
		$offer_list = getOfferArray();

		if(empty($action))
		{
			if(count($offer_list['premiumscroll']) > 0)
				$action = 'premiumscroll';
			elseif($config['site']['shop_extraservice'])
				$action = 'extraservice';	
			elseif(count($offer_list['item']) > 0)
				$action = 'item';
			elseif(count($offer_list['itemvip']) > 0)
				$action = 'itemvip';
			elseif(count($offer_list['mount']) > 0)
				$action = 'mount';
			elseif(count($offer_list['addon']) > 0)
				$action = 'addon';
			elseif(count($offer_list['container']) > 0)
				$action = 'container';
		}

		function selectcolor($value)
		{
			if($GLOBALS['action'] == $value)
				return 'ActiveInnerTableTab';
			else
				return '';
		}
		
		function selectcolorbg($value)
		{
			if($GLOBALS['action'] == $value)
				return 'active';
			else
				return 'nonactive';
		}
		
		function selectribbon($value)
		{
			if($GLOBALS['action'] == $value)
				return '_active';
			else
				return '';
		}
		
		$countpriumscroll = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "premiumscroll";')->fetch();
		if($countpriumscroll[0] > 0)
		$premiumscrollribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('premiumscroll').'.png);"></div>';
		
		$countextraservice = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "extraservice";')->fetch();
		if($countextraservice[0] > 0)
		$extraserviceribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('extraservice').'.png);"></div>';
		
		$countitemvip = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "itemvip";')->fetch();
		if($countitemvip[0] > 0)
		$itemvipribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('itemvip').'.png);"></div>';
		
		$countmount = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "mount";')->fetch();
		if($countmount[0] > 0)
		$mountribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('mount').'.png);"></div>';
		
		$countaddon = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "addon";')->fetch();
		if($countaddon[0] > 0)
		$addonribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('addon').'.png);"></div>';
		
		$countitem = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "item";')->fetch();
		if($countitem[0] > 0)
		$itemribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('item').'.png);"></div>';
		
		$countcontainer = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE hot >= 1 AND offer_type = "container";')->fetch();
		if($countcontainer[0] > 0)
		$containerribbonh .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-last-chance'.selectribbon('container').'.png);"></div>';
		
		$time1m = strtotime("-1 month", getdate()[0]);
		
		$countpriumscrolln = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "premiumscroll";')->fetch();
		if($countpriumscrolln[0] > 0)
		$premiumscrollribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('premiumscroll').'.png);"></div>';
		
		$countextraservicen = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "extraservice";')->fetch();
		if($countextraservicen[0] > 0)
		$extraserviceribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('extraservice').'.png);"></div>';
		
		$countitemvipn = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "itemvip";')->fetch();
		if($countitemvipn[0] > 0)
		$itemvipribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('itemvip').'.png);"></div>';
		
		$countmountn = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "mount";')->fetch();
		if($countmountn[0] > 0)
		$mountribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('mount').'.png);"></div>';
		
		$countaddonn = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "addon";')->fetch();
		if($countaddonn[0] > 0)
		$addonribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('addon').'.png);"></div>';
		
		$countitemn = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "item";')->fetch();
		if($countitemn[0] > 0)
		$itemribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('item').'.png);"></div>';
		
		$countcontainern = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('z_shop_offer').' WHERE date > '.$time1m.' AND offer_type = "container";')->fetch();
		if($countcontainern[0] > 0)
		$containerribbonn .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-tab-new-product'.selectribbon('container').'.png);"></div>';

		if((count($offer_list['item']) > 0) or (count($offer_list['mount']) > 0) or (count($offer_list['addon']) > 0) or (count($offer_list['container']) > 0))
		{
			$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:bold;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-blue.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
			if($logged)
				$main_content .= '<form action="?subtopic=webstore" method="POST">';
			else
				$main_content .= '<form action="?subtopic=accountmanagement" method="POST">';
			$main_content .= '<input type="hidden" name="action" value="select_acc">
			<div class="TableContainer" style="position:relative;">
		<div class="ribbonShop-double"></div>
			<div class="CaptionContainer">
				<div class="CaptionInnerContainer"> 
					<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span> 
					<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span> 
					<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
					<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
					<div class="Text">Select Service</div>
					<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span> 
					<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
					<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span> 
					<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span> 
				</div>
			</div>
			<table class="Table5" cellpadding="0" cellspacing="0">
			
			<tbody><tr>
				<td>
					<div class="InnerTableContainer">
						<table style="width:100%;">
							<tbody><tr>
								<td>';
			if(count($offer_list['premiumscroll']) > 0) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Premium Scrolls\', \'Buy Premium Scrolls to transfer Premium Time to the game or to use it for your own account.\', \'ProductCategoryHelperDiv_7\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('premiumscroll').'">
											<div id="ProductCategoryHelperDiv_7" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=premiumscroll">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('premiumscroll').'.png">
												<div class="InnerTableTabLabel">Premium Scrolls</div>
												'.$premiumscrollribbonh.'
												'.$premiumscrollribbonn.'
											</a>
										</div>
									</span>';
			if($config['site']['shop_extraservice']) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Extra Services\', \'Buy an extra service to transfer a character to another game world, to change your character name or sex, to change your account name, or to get a new recovery key.\', \'ProductCategoryHelperDiv_1\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('extraservice').'">
											<div id="ProductCategoryHelperDiv_1" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=extraservice">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('extraservice').'.png">
												<div class="InnerTableTabLabel">Extra Services</div>
												'.$extraserviceribbonh.'
												'.$extraserviceribbonn.'
											</a>
										</div>
									</span>';
			if(count($offer_list['itemvip']) > 0) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'VIP Items\', \'Buy VIP items for your character be more stronger in the game.\', \'ProductCategoryHelperDiv_2\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('itemvip').'">
											<div id="ProductCategoryHelperDiv_2" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=itemvip">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('itemvip').'.png">
												<div class="InnerTableTabLabel">VIP Items</div>
												'.$itemvipribbonh.'
												'.$itemvipribbonn.'
											</a>
										</div>
									</span>';
			if(count($offer_list['mount']) > 0) $main_content .= '
						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Mounts\', \'Buy your characters one or more of the fabulous mounts offered here.\', \'ProductCategoryHelperDiv_3\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('mount').'">
											<div id="ProductCategoryHelperDiv_3" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=mount">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('mount').'.png">
												<div class="InnerTableTabLabel">Mounts</div>
												'.$mountribbonh.'
												'.$mountribbonn.'
											</a>
										</div>
									</span>';
			if(count($offer_list['addon']) > 0) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Addons\', \'Buy your characters one or more of the fancy addons offered here.\', \'ProductCategoryHelperDiv_4\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('addon').'">
											<div id="ProductCategoryHelperDiv_4" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=addon">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('addon').'.png">
												<div class="InnerTableTabLabel">Addons</div>
												'.$addonribbonh.'
												'.$addonribbonn.'
											</a>
										</div>
									</span>';
			if(count($offer_list['item']) > 0) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Items\', \'Buy items for your character be more stronger in the game.\', \'ProductCategoryHelperDiv_5\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('item').'">
											<div id="ProductCategoryHelperDiv_5" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=item">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('item').'.png">
												<div class="InnerTableTabLabel">Items</div>
												'.$itemribbonh.'
												'.$itemribbonn.'
											</a>
										</div>
									</span>';
			if(count($offer_list['container']) > 0) $main_content .= '
			<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Container\', \'Container.\', \'ProductCategoryHelperDiv_6\');" onmouseout="$(\'#HelperDivContainer\').hide();">
										<div class="InnerTableTab '.selectcolor('container').'">
											<div id="ProductCategoryHelperDiv_6" class="ProductCategoryHelperDiv"></div>
											<a href="?subtopic=webstore&action=container">
												<img src="'.$layout_name.'/images/payment/products_tab_'.selectcolorbg('container').'.png">
												<div class="InnerTableTabLabel">Container</div>
												'.$containerribbonh.'
												'.$containerribbonn.'
											</a>
										</div>
									</span>';
			$main_content .= '</td>
							</tr>';
			///$main_content .= '</TD></TR></TD></TR></table><table BORDER=0 CELLPaDDING="4" CELLSPaCING="1" style="width:100%;font-weight:bold;text-align:center;"><tr style="background:#505050;"><td colspan="3" style="height:px;"></td></tr></table>';
		}

		//show list of EXTRA SERVICES
		if(($config['site']['shop_system']) and ($action == 'extraservice'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Extra Services">
			<input type="hidden" name="action_back" value="extraservice">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
			if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
			if($config['site']['shop_changeaccname'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_1">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changeaccname.png); background-position: center;" onclick="ChangeService(1, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_1" onclick="ChangeService(1, 2);" onmouseover="MouseOverServiceID(1, 2);" onmouseout="MouseOutServiceID(1, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Account Name Change\', \'Buy an account name change to select a different name for your account.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_1"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_1"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_1"></div>
																					<label for="ServiceID_1">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_1" class="ServiceID" name="action" value="changeaccname">
																								<b>Account Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_1">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['shop_changeaccNameCost'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
				
			}
			if($config['site']['shop_newrk'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_2">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/newrk.png); background-position: center;" onclick="ChangeService(2, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_2" onclick="ChangeService(2, 2);" onmouseover="MouseOverServiceID(2, 2);" onmouseout="MouseOutServiceID(2, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'New Recovery Key\', \'If you need a new recovery key, you can order it here. Note that the letter for the new recovery key can only be sent to the address in the account registration.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_2"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_2"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_2"></div>
																					<label for="ServiceID_2">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_2" class="ServiceID" name="action" value="newrk">
																								<b>New Recovery Key</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_2">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['generate_new_reckey_price'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
			}
			if($config['site']['shop_changecharname'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_3">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changecharname.png); background-position: center;" onclick="ChangeService(3, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_3" onclick="ChangeService(3, 2);" onmouseover="MouseOverServiceID(3, 2);" onmouseout="MouseOutServiceID(3, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Character Name Change\', \'Buy a character name change to rename one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_3"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_3"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_3"></div>
																					<label for="ServiceID_3">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_3" class="ServiceID" name="action" value="changecharname">
																								<b>Character Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_3">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['shop_changecharNameCost'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
				
			}
			if($config['site']['shop_changegender'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_4">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/sex.png); background-position: center;" onclick="ChangeService(4, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_4" onclick="ChangeService(4, 2);" onmouseover="MouseOverServiceID(4, 2);" onmouseout="MouseOutServiceID(4, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Change Character Gender\', \'Buy a Change Character Gender to change the gender of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_4"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_4"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_4"></div>
																					<label for="ServiceID_4">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_4" class="ServiceID" name="action" value="changesex">
																								<b>Change Character Gender</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_4">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['shop_changeGenderCost'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
				
			}
			if($config['site']['shop_removeskull'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_5">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/removeskull.png); background-position: center;" onclick="ChangeService(5, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_5" onclick="ChangeService(5, 2);" onmouseover="MouseOverServiceID(5, 2);" onmouseout="MouseOutServiceID(5, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Remove Character Skull\', \'Buy a Remove Character Skull to remove the skull of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_5"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_5"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_5"></div>
																					<label for="ServiceID_5">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_5" class="ServiceID" name="action" value="removeskull">
																								<b>Remove Character Skull</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_5">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['shop_removeSkullCost'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
				
			}
			if($config['site']['shop_refillstamina'])
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_6">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/refillstamina.png); background-position: center;" onclick="ChangeService(6, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_6" onclick="ChangeService(6, 2);" onmouseover="MouseOverServiceID(6, 2);" onmouseout="MouseOutServiceID(6, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Refill Character Stamina\', \'Buy a Refill Character Stamina to refill the stamina of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_6"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_6"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_6"></div>
																					<label for="ServiceID_6">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_6" class="ServiceID" name="action" value="refillstamina">
																								<b>Refill Character Stamina</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_6">';
																						if($logged)
																							$main_content .= '<b>'.$config['site']['shop_refillStaminaCost'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '
																						</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
				
			}
			foreach($offer_list['extraservice'] as $extraservice)
			{
				if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
				
																			$main_content .= '
																			<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$extraservice['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$extraservice['id'].'" onclick="ChangeService('.$extraservice['id'].', 2);" onmouseover="MouseOverServiceID('.$extraservice['id'].', 2);" onmouseout="MouseOutServiceID('.$extraservice['id'].', 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$extraservice['name'].'\', \''.$extraservice['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$extraservice['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$extraservice['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $extraservice['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($extraservice['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$extraservice['id'].'" style="background-image:url(/images/items/'.$extraservice['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$extraservice['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$extraservice['id'].'"></div>
																					<label for="ServiceID_'.$extraservice['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$extraservice['id'].'" class="ServiceID" name="ServiceID" value="'.$extraservice['id'].'">
																								<b>'.$extraservice['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$extraservice['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$extraservice['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
																			';
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>It is strongly recommend that you set up an extra service before you purchase it. This way you can ensure that your desired name is available and reserved for you or want to change your character gender and refil your stamina.
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>									
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		
		//show list of Premium Scroll offers
		if((count($offer_list['premiumscroll']) > 0) and ($action == 'premiumscroll'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Premium Scrolls">
			<input type="hidden" name="action_back" value="premiumscroll">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			foreach($offer_list['premiumscroll'] as $premiumscroll)
			{
				if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$premiumscroll['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $premiumscroll['id'] . '.png); background-position: center;" onclick="ChangeService('.$premiumscroll['id'].', 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$premiumscroll['id'].'" onclick="ChangeService('.$premiumscroll['id'].', 1);" onmouseover="MouseOverServiceID('.$premiumscroll['id'].', 1);" onmouseout="MouseOutServiceID('.$premiumscroll['id'].', 1);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$premiumscroll['name'].'\', \''.$premiumscroll['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$premiumscroll['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$premiumscroll['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $premiumscroll['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($premiumscroll['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$premiumscroll['id'].'"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$premiumscroll['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$premiumscroll['id'].'"></div>
																					<label for="ServiceID_'.$premiumscroll['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$premiumscroll['id'].'" class="ServiceID" name="ServiceID" value="'.$premiumscroll['id'].'">
																								<b>'.$premiumscroll['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$premiumscroll['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$premiumscroll['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
				';
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>You can use this Premium Scrolls to extend the Premium Time of your account. You can transfer Premium Scrolls to one of your characters into the game. Premium Scrolls can be traded freely with other characters through the market or the safe trade option.
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>									
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		
		//show list of VIP items offers
		if((count($offer_list['itemvip']) > 0) and ($action == 'itemvip'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="VIP Items">
			<input type="hidden" name="action_back" value="itemvip">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			foreach($offer_list['itemvip'] as $itemvip)
			{
				if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$itemvip['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$itemvip['id'].'" onclick="ChangeService('.$itemvip['id'].', 3);" onmouseover="MouseOverServiceID('.$itemvip['id'].', 3);" onmouseout="MouseOutServiceID('.$itemvip['id'].', 3);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$itemvip['name'].'\', \''.$itemvip['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$itemvip['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$itemvip['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $itemvip['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($itemvip['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$itemvip['id'].'" style="background-image:url(/images/items/'.$itemvip['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$itemvip['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$itemvip['id'].'"></div>
																					<label for="ServiceID_'.$itemvip['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$itemvip['id'].'" class="ServiceID" name="ServiceID" value="'.$itemvip['id'].'">
																								<b>'.$itemvip['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$itemvip['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$itemvip['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
';
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>These items provide varying levels of protection from enemy attacks, and sometimes lessen certain types of attacks. You are allowed to wear one of each type of armor at one time. A complete set of armor will include a Helmet, a Shield, an Armor, Boots and Legs.
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>									
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		//show list of mount offers
		if((count($offer_list['mount']) > 0) and ($action == 'mount'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Mounts">
			<input type="hidden" name="action_back" value="mount">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			foreach($offer_list['mount'] as $mount)
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$mount['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$mount['id'].'" onclick="ChangeService('.$mount['id'].', 4);" onmouseover="MouseOverServiceID('.$mount['id'].', 4);" onmouseout="MouseOutServiceID('.$mount['id'].', 4);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$mount['name'].'\', \''.$mount['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$mount['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$mount['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $mount['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($mount['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$mount['id'].'" style="background-image:url(images/mount/' . $mount['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$mount['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$mount['id'].'"></div>
																					<label for="ServiceID_'.$mount['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$mount['id'].'" class="ServiceID" name="ServiceID" value="'.$mount['id'].'">
																								<b>'.$mount['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$mount['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$mount['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
';
				
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>In Tibia you can tame a creature to become your mount. Usually you do this by using a specific item on a creature. When you have tamed a mount you can press Ctrl+R to mount, but only if you are outside of a Protection Zone. If you enter a protection zone while mounted, you will automatically dismount.
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>								
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		//show list of addon offers
		if((count($offer_list['addon']) > 0) and ($action == 'addon'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Addons">
			<input type="hidden" name="action_back" value="addon">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			foreach($offer_list['addon'] as $addon)
			{
				if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$addon['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$addon['id'].'" onclick="ChangeService('.$addon['id'].', 5);" onmouseover="MouseOverServiceID('.$addon['id'].', 5);" onmouseout="MouseOutServiceID('.$addon['id'].', 5);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$addon['name'].'\', \''.$addon['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$addon['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$addon['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $addon['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($addon['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$addon['id'].'" style="background-image:url(images/addons/' . $addon['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$addon['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$addon['id'].'"></div>
																					<label for="ServiceID_'.$addon['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$addon['id'].'" class="ServiceID" name="ServiceID" value="'.$addon['id'].'">
																								<b>'.$addon['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$addon['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$addon['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>
';
				
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>Your outfit is the part of your character that is displayed to all other players while you are in-game. There is a specific number of outfits that each player can choose from (more for Premium than Free Account players). Each outfit can be personalized by selecting the colors for the different parts of the outfit (hair, legs, torso, feet). 
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>							
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		
		//show list of free items
		if((count($offer_list['item']) > 0) and ($action == 'item'))
		{
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Items">
			<input type="hidden" name="action_back" value="item">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">
														';
			foreach($offer_list['item'] as $item)
			{
				if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$item['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$item['id'].'" onclick="ChangeService('.$item['id'].', 6);" onmouseover="MouseOverServiceID('.$item['id'].', 6);" onmouseout="MouseOutServiceID('.$item['id'].', 6);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$item['name'].'\', \''.$item['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$item['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$item['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $item['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($item['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$item['id'].'" style="background-image:url(/images/items/'.$item['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$item['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$item['id'].'"></div>
																					<label for="ServiceID_'.$item['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">';
																							if($logged)
																								$main_content .= '<input type="radio" id="ServiceID_'.$item['id'].'" class="ServiceID" name="ServiceID" value="'.$item['id'].'">';
																								$main_content .= '<b>'.$item['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$item['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$item['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>';
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
														<tbody><tr>
															<td style="text-align: center;" align="center">
																<div style="max-height: 240px; overflow-y: auto;">
																	<div class="PMCID_Icon_Container" id="PMCID_Icon_Container_1">
																		<div class="PMCID_Icon" id="PMCID_Icon_1" style="background-image:url(.'.$layout_name.'/images/payment/pmcid_icon_normal.png);" onclick="ChangePMC(1);" onmouseover="MouseOverPMCID(1);" onmouseout="MouseOutPMCID(1);">';
																			if($logged)
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="display: none;">';
																			else
																			$main_content .= '<div class="PermanentDeactivated PMCID_Deactivated_ByChoice" id="PMCID_NotAllowed_1" style="/* display: none; */">';
																		
																				$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Payment Method Info:\', \'<p>You need to login to select Tibia Coins as payment method!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																					<div class="PMCID_Deactivated" style="background-image: url(.'.$layout_name.'/images/payment/pmcid_deactivated.png);"></div>
																				</span>
																			</div>';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Selected" id="PMCID_Icon_Selected_1" style="background-image: url('.$layout_name.'/images/payment/pmcid_icon_selected.png);"></div>';
																			else
																			$main_content .= '';
																			if($logged)
																			$main_content .= '<div class="PMCID_Icon_Over" id="PMCID_Icon_Over_1"></div>
																			<span style="position: absolute; left: 125px; top: 53px; z-index: 99;">
																				<span style="margin-left: 5px; position: absolute; margin-top: 2px;">																					
																					<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Information:\', \'Tibia Coins can be used to purchase addons, mounts, items and extra services.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																						<img style="border:0px;" src="'.$layout_name.'/images/content/info.gif">
																					</span>
																				</span>
																			</span>';
																			if($logged)
																			{
																			if($account_logged->getCustomField('premium_points') < 750)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins1.png">';
																			if($account_logged->getCustomField('premium_points') >= 750 && $account_logged->getCustomField('premium_points') < 1500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins2.png">';
																			if($account_logged->getCustomField('premium_points') >= 1500 && $account_logged->getCustomField('premium_points') < 3000)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins3.png">';
																			if($account_logged->getCustomField('premium_points') >= 3000 && $account_logged->getCustomField('premium_points') < 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins4.png">';
																			if($account_logged->getCustomField('premium_points') >= 4500)
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			}
																			else
																			$main_content .= '<img class="PMCID_CP_Icon" src=".'.$layout_name.'/images/payment/coins5.png">';
																			$main_content .= '<div class="PMCID_CP_Label">
																				<input type="radio" id="PMCID_1" name="PMCID" value="1" checked="checked">
																				<label for="PMCID_1">Tibia Coins</label>
																			</div>
																		</div>
																	</div>
																		<p>These items provide varying levels of protection from enemy attacks, and sometimes lessen certain types of attacks. You are allowed to wear one of each type of armor at one time. A complete set of armor will include a Helmet, a Shield, an Armor, Boots and Legs.
																		</br></br><b>'.$showuser_premium_points.'</b></p>
																</div>
															</td>
														</tr>
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
									</tr>									
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		//show list of containers offers
		if((count($offer_list['container']) > 0) and ($action == 'container'))
		{
			if(!is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
			$main_content .= '
			<input type="hidden" name="offer_tcatg" value="Containers">
			<input type="hidden" name="action_back" value="container">
			<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 100px; overflow-y: auto;">';
			foreach($offer_list['container'] as $container)
			{
				$main_content .= '
				<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$container['id'].'">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_'.$container['id'].'" onclick="ChangeService('.$container['id'].', 7);" onmouseover="MouseOverServiceID('.$container['id'].', 7);" onmouseout="MouseOutServiceID('.$container['id'].', 7);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$container['name'].'\', \''.$container['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$container['id'].'" style="display: none;">';
																					else
																						$main_content .= '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$container['id'].'" style="/* display: none; */">';

																						$main_content .= '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $container['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($container['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					$main_content .= '
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$container['id'].'" style="background-image:url(/images/items/'.$container['container_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$container['id'].'" style="background-image:url(/images/items/'.$container['item_id'].'.gif); background-repeat:no-repeat; background-position: center right;"></div>';
																					if($logged)
																					$main_content .= '<div class="ServiceID_Icon_Selected" id="ServiceID_Icon_Selected_'.$container['id'].'"></div>';
																					$main_content .= '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$container['id'].'"></div>
																					<label for="ServiceID_'.$container['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$container['id'].'" class="ServiceID" name="ServiceID" value="'.$container['id'].'">
																								<b>'.$container['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$container['id'].'">';
																						if($logged)
																							$main_content .= '<b>'.$container['points'].' Tibia Coins</b>';
																						else
																							$main_content .= '<font color="red"><b>Login To Buy</b></font>';
																						$main_content .= '</span></div>
																					</label>
																				</div>
																			</div>
																		</div>';
			}
			$main_content .= '</div>
													</td>
												</tr>
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
							</tr>
							<tr>
								<td>
									<div class="TableShadowContainerRightTop">
										<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
									</div>
									<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
										<div class="TableContentContainer">
											<table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
												<tbody><tr>
													<td style="text-align: center;" align="center">
														<div style="max-height: 500px; min-height: 30px; overflow-y: auto;">
															<p>Mounts in this list can be obtained in-game, taming them and then making their quests.</p>
														</div>
													</td>
												</tr>
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
							</tr>									
						</tbody></table>
					</div>
				</td>
			</tr>
		</tbody></table>';
		}
		//Finish container

		$main_content .= '</div>';
		$main_content .= '
		<div class="SubmitButtonRow">';
				if($logged)
							$main_content .= '<div class="LeftButton">';
						else
							$main_content .= '<div class="CenterButton">';
					$main_content .= '
					<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)">
						<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="visibility: hidden; background-image: url(&quot;'.$layout_name.'/images/buttons/sbutton_green_over.gif&quot;);"></div>';
						if($logged)
							$main_content .= '<input id="sendService" class="ButtonText" type="image" name="s&quot;Next&quot;" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif">';
						else
							$main_content .= '<input id="sendService" class="ButtonText" type="image" name="s&quot;Login&quot;" alt="Login" src="'.$layout_name.'/images/buttons/_sbutton_login.gif">';
						$main_content .= '</div>
					</div>
				</div>
				</form>';
				
				if($logged)
				$main_content .= '
				<div class="RightButton">
					<form action="?subtopic=accountmanagement&amp;action=manage" method="post" style="padding:0px;margin:0px;">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)">
							<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);"></div>
								<input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif">
							</div>
						</div>
					</form>
				</div>';
				
				$main_content .= '
			</div>
		';
	}
	if($action == 'select_acc')
	{
		unset($_SESSION['viewed_confirmation_page']);
		if(!$logged) {
			$errormessage .= 'Please login first.';
		}
		else
		{
			$buy_id = (int) $_REQUEST['ServiceID'];
			if(empty($buy_id))
			{
				$errormessage .= 'Please <a href="?subtopic=webstore">select item</a> first.';
			}
			else
			{
				$buy_offer = getItemByID($buy_id);
				if(isset($buy_offer['id'])) //item exist in database
				{
					if($user_premium_points >= $buy_offer['points'])
					{
						$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
						$main_content .= '<div class="TableContainer" >  <table class="Table4" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>        <div class="InnerTableContainer" >
						<tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						</br>
						<form action="?subtopic=webstore" METHOD=post>
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$buy_offer['item_id'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($buy_offer['name']).'">
						<input type="hidden" name="offer_tprice" value="'.htmlspecialchars($buy_offer['points']).'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($buy_offer['description']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
						<input type="hidden" name="action" value="select_player">
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.$_REQUEST['offer_tcatg'].'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.htmlspecialchars($buy_offer['description']).'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Send to:</b></td>
															<td><select name="buyer_c">
															<option value="1"'; 
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= ' selected';
															$main_content .= '>Player of Your Account</option>
															<option value="2"';
															if($_REQUEST['buyer_c'] == "2")
															$main_content .= ' selected';
															$main_content .= '>Other Players</option>
															</select></td>
															</tr>
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
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						</div>  </table></div><br><br/>
						<input type="hidden" name="id" value="'.$_REQUEST['id'].'" >
				<div class="SubmitButtonRow">
					<div class="LeftButton">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)">
							<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);"></div>
								<input class="ButtonText" type="image"  name="submit" value="Submit" class="input2" src="'.$layout_name.'/images/buttons/_sbutton_next.gif">
							</div>
						</div>
					</div>
					</form>
					
					<div class="RightButton">
						<form method="post" action="?subtopic=webstore">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)">
								<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);"></div>
									<input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif">
								</div>
							</div>
						</form>
					</div>
				</div>';

					}
					else
					{
						$errormessage .= 'For this item you need <b>'.$buy_offer['points'].'</b> points. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.';
					}
				}
				else
				{
					$errormessage .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="?subtopic=webstore">select item</a> again.';
				}
			}
		}
		if(!empty($errormessage))
		{
			$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
				<TR><TD ALIGN=left>'.$errormessage.'</TD></TR>
				</table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
	}
	if($action == 'select_player')
	{
		unset($_SESSION['viewed_confirmation_page']);
		if(!$logged) {
			$errormessage .= 'Please login first.';
		}
		else
		{
			$buy_id = (int) $_REQUEST['ServiceID'];
			if(empty($buy_id))
			{
				$errormessage .= 'Please <a href="?subtopic=webstore">select item</a> first.';
			}
			else
			{
				$buy_offer = getItemByID($buy_id);
				if(isset($buy_offer['id'])) //item exist in database
				{
					if($user_premium_points >= $buy_offer['points'])
					{
						$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
						$main_content .= '<div class="TableContainer" >  <table class="Table4" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>        <div class="InnerTableContainer" >
						<tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						</br>
						<form method="post" action="?subtopic=webstore">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($_REQUEST['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
						<input type="hidden" name="action" value="confirm_transaction">
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.htmlspecialchars($buy_offer['description']).'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Send to:</b></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Player Name:</b></td>
															<td>';
						if($_REQUEST['buyer_c'] == "1")
						{
															$main_content .= '<select name="buy_name">';
						$players_from_logged_acc = $account_logged->getPlayersList();
						if(count($players_from_logged_acc) > 0)
						{
							foreach($players_from_logged_acc as $player)
							{
								$main_content .= '<option value="'.htmlspecialchars($player->getName()).'">'.htmlspecialchars($player->getName()).'</option>';
							}
						}
						else
						{
							$main_content .= 'You don\'t have any character on your account.';
						}
						$main_content .= '</select>';
						}
						else
						$main_content .= '<input type="text" name="buy_name">';
										$main_content .= '</td>
															</tr>';
										if($_REQUEST['buyer_c'] == "2")
										{
										$main_content .= '<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Sent by:</b></td>
															<td>';
															$main_content .= '<select name="buy_from"><option value="Anonymous">Anonymous</option>';
						$players_from_logged_acc = $account_logged->getPlayersList();
						if(count($players_from_logged_acc) > 0)
						{
							foreach($players_from_logged_acc as $player)
							{
								$main_content .= '<option value="'.htmlspecialchars($player->getName()).'">'.htmlspecialchars($player->getName()).'</option>';
							}
						}
						else
						{
							$main_content .= '<option value="Anonymous">Anonymous</option>';
						}
						$main_content .= '</select>';
															$main_content .= '</td>
															</tr>';
										}
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
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						</div>  </table></div><br>';
						
						$main_content .= '<br/>
						
						<input type="hidden" name="id" value="'.$_REQUEST['id'].'" >
				<div class="SubmitButtonRow">
					<div class="LeftButton">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)">
							<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);"></div>
								<input class="ButtonText" type="image"  name="submit" value="Submit" class="input2" src="'.$layout_name.'/images/buttons/_sbutton_next.gif">
							</div>
						</div>
					</div>
					</form>
					
					<div class="RightButton">
						<form method="post" action="?subtopic=webstore">
						<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
						<input type="hidden" name="action" value="select_acc">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
								<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
									<input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif">
								</div>
							</div>
						</form>
					</div>
				</div>';

					}
					else
					{
						$errormessage .= 'For this item you need <b>'.$buy_offer['points'].'</b> points. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.';
					}
				}
				else
				{
					$errormessage .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="?subtopic=webstore">select item</a> again.';
				}
			}
		}
		if(!empty($errormessage))
		{
			$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
				<TR><TD ALIGN=left>'.$errormessage.'</TD></TR>
				</table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
	}
	elseif($action == 'confirm_transaction')
	{
		if(!$logged)
		{
			$errormessage .= 'Please login first.';
		}
		else
		{
			$buy_id = (int) $_POST['ServiceID'];
			$buy_name = trim($_POST['buy_name']);
			$buy_from = trim($_REQUEST['buy_from']);
			if(empty($buy_from))
			{
				$buy_from = 'You';
			}
			if(empty($buy_id))
			{
				$errormessage .= 'Please <a href="?subtopic=webstore">select item</a> first.';
			}
			else
			{
				if(!check_name($buy_from))
				{
					$errormessage .= 'Invalid nick ("from player") format. Please <a href="?subtopic=webstore&action=select_player&ServiceID='.$buy_id.'">select other name</a> or contact with administrator.';
				}
				else
				{
					$buy_offer = getItemByID($buy_id);
					if(isset($buy_offer['id'])) //item exist in database
					{
						if($user_premium_points >= $buy_offer['points'])
						{
							if(check_name($buy_name))
							{
								$buy_player = new Player();
								$buy_player->find($buy_name);
								if($buy_player->isLoaded())
								{
									$buy_player_account = $buy_player->getAccount();
									if($_SESSION['viewed_confirmation_page'] == 'yes' && $_POST['buy_confirmed'] == 'yes')
									{
										if($buy_offer['type'] == 'extraservice')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
											$sql = 'INSERT INTO '.$SQL->tableName('z_ots_comunication').' ('.$SQL->fieldName('id').','.$SQL->fieldName('name').','.$SQL->fieldName('type').','.$SQL->fieldName('action').','.$SQL->fieldName('param1').','.$SQL->fieldName('param2').','.$SQL->fieldName('param3').','.$SQL->fieldName('param4').','.$SQL->fieldName('param5').','.$SQL->fieldName('param6').','.$SQL->fieldName('param7').','.$SQL->fieldName('delete_it').') VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote('login').', '.$SQL->quote('give_item').', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote('').', '.$SQL->quote('').', '.$SQL->quote('item').', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote($buy_offer['id']).', '.$SQL->quote(1).');';
											$SQL->query($sql);
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										elseif($buy_offer['type'] == 'premiumscroll')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
											$sql = 'INSERT INTO '.$SQL->tableName('z_ots_comunication').' ('.$SQL->fieldName('id').','.$SQL->fieldName('name').','.$SQL->fieldName('type').','.$SQL->fieldName('action').','.$SQL->fieldName('param1').','.$SQL->fieldName('param2').','.$SQL->fieldName('param3').','.$SQL->fieldName('param4').','.$SQL->fieldName('param5').','.$SQL->fieldName('param6').','.$SQL->fieldName('param7').','.$SQL->fieldName('delete_it').') VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote('login').', '.$SQL->quote('give_item').', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote($buy_offer['container_id']).', '.$SQL->quote($buy_offer['container_count']).', '.$SQL->quote('container').', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote($buy_offer['id']).', '.$SQL->quote(1).');';
											$SQL->query($sql);
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										elseif($buy_offer['type'] == 'itemvip')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
											$sql = 'INSERT INTO '.$SQL->tableName('z_ots_comunication').' ('.$SQL->fieldName('id').','.$SQL->fieldName('name').','.$SQL->fieldName('type').','.$SQL->fieldName('action').','.$SQL->fieldName('param1').','.$SQL->fieldName('param2').','.$SQL->fieldName('param3').','.$SQL->fieldName('param4').','.$SQL->fieldName('param5').','.$SQL->fieldName('param6').','.$SQL->fieldName('param7').','.$SQL->fieldName('delete_it').') VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote('login').', '.$SQL->quote('give_item').', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote('').', '.$SQL->quote('').', '.$SQL->quote('item').', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote($buy_offer['id']).', '.$SQL->quote(1).');';
											$SQL->query($sql);
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										elseif($buy_offer['type'] == 'item')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
											$sql = 'INSERT INTO '.$SQL->tableName('z_ots_comunication').' ('.$SQL->fieldName('id').','.$SQL->fieldName('name').','.$SQL->fieldName('type').','.$SQL->fieldName('action').','.$SQL->fieldName('param1').','.$SQL->fieldName('param2').','.$SQL->fieldName('param3').','.$SQL->fieldName('param4').','.$SQL->fieldName('param5').','.$SQL->fieldName('param6').','.$SQL->fieldName('param7').','.$SQL->fieldName('delete_it').') VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote('login').', '.$SQL->quote('give_item').', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote('').', '.$SQL->quote('').', '.$SQL->quote('item').', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote($buy_offer['id']).', '.$SQL->quote(1).');';
											$SQL->query($sql);
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										elseif($buy_offer['type'] == 'mount')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
										$account_id = $buy_player->getCustomField('id');
										$on = $SQL->query('SELECT * FROM '.$SQL->tableName('players_online').' WHERE '.$SQL->fieldName('player_id').' = '.$account_id.';')->fetch();
										if ($on == false)
										{
											$SQL->query('INSERT INTO `player_storage` (`player_id`, `key`, `value`) VALUES ('.$account_id.', '.$SQL->quote($buy_offer['item_id']).', 1);');
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										else
										$errormessage .= '<b>'.htmlspecialchars($buy_player->getName()).' has to be offline!</b>';
										}
										elseif($buy_offer['type'] == 'addon')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
										$account_id = $buy_player->getCustomField('id');
										$on = $SQL->query('SELECT * FROM '.$SQL->tableName('players_online').' WHERE '.$SQL->fieldName('player_id').' = '.$account_id.';')->fetch();
										if ($on == false)
										{
											$SQL->query('INSERT INTO `player_storage` (`player_id`, `key`, `value`) VALUES ('.$account_id.', '.$SQL->quote($buy_offer['item_id']).', 1);');
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
										else
										$errormessage .= '<b>'.htmlspecialchars($buy_player->getName()).' has to be offline!</b>';
										}
										elseif($buy_offer['type'] == 'container')
										{
											$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
											$sql = 'INSERT INTO '.$SQL->tableName('z_ots_comunication').' ('.$SQL->fieldName('id').','.$SQL->fieldName('name').','.$SQL->fieldName('type').','.$SQL->fieldName('action').','.$SQL->fieldName('param1').','.$SQL->fieldName('param2').','.$SQL->fieldName('param3').','.$SQL->fieldName('param4').','.$SQL->fieldName('param5').','.$SQL->fieldName('param6').','.$SQL->fieldName('param7').','.$SQL->fieldName('delete_it').') VALUES (NULL, '.$SQL->quote($buy_player->getName()).', '.$SQL->quote('login').', '.$SQL->quote('give_item').', '.$SQL->quote($buy_offer['item_id']).', '.$SQL->quote($buy_offer['item_count']).', '.$SQL->quote($buy_offer['container_id']).', '.$SQL->quote($buy_offer['container_count']).', '.$SQL->quote('container').', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote($buy_offer['id']).', '.$SQL->quote(1).');';
											$SQL->query($sql);
											$save_transaction = 'INSERT INTO '.$SQL->tableName('z_shop_history_item').' ('.$SQL->fieldName('id').','.$SQL->fieldName('to_name').','.$SQL->fieldName('to_account').','.$SQL->fieldName('from_nick').','.$SQL->fieldName('from_account').','.$SQL->fieldName('price').','.$SQL->fieldName('offer_id').','.$SQL->fieldName('trans_state').','.$SQL->fieldName('trans_start').','.$SQL->fieldName('trans_real').') VALUES ('.$SQL->lastInsertId().', '.$SQL->quote($buy_player->getName()).', '.$SQL->quote($buy_player_account->getId()).', '.$SQL->quote($buy_from).',  '.$SQL->quote($account_logged->getId()).', '.$SQL->quote($buy_offer['points']).', '.$SQL->quote($buy_offer['name']).', '.$SQL->quote('wait').', '.$SQL->quote(time()).', '.$SQL->quote(0).');';
											$SQL->query($save_transaction);
											$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
											$user_premium_points = $user_premium_points - $buy_offer['points'];
											$main_content .= '
											<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Order Summary</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>      </div>    </div><table class="Table4" cellpadding="0" cellspacing="0">        <tbody><tr>      <td>        <div class="InnerTableContainer">
										</div></td></tr><tr>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>												
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Offer Name:</b></nobr></td>
															<td><b>'.htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>'.$buy_offer['description'].'</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Sent to:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['buyer_c'] == "1")
															$main_content .= '<option>Player of Your Account</option>';
															else
															$main_content .= '<option>Other Players</option>';
															$main_content .= '</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Player Name:</b></nobr></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><nobr><b>Sent by:</b></nobr></td>
															<td>'.$_REQUEST['buy_from'].'</td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Offer Price:</b></nobr></td>
															<td>'.$buy_offer['points'].' Tibia Coins</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Your Balance:</b></nobr></td>
															<td>'.$user_premium_points.' Tibia Coins</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									<td>
									<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#D4C0A1">
															<td>
															<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
															</td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										   </tbody></table></div><br>
												<br/><center><form action="?subtopic=webstore" METHOD=post>
												<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="action" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
										}
									}
									else
									{
										$set_session = TRUE;
										$_SESSION['viewed_confirmation_page'] = 'yes';
										$main_content .= '
			<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select account</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Select player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			';
										$main_content .= '<div class="TableContainer" >  <table class="Table4" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Confirm Transaction</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
										<tr>
										<td>
										<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_'.$buy_offer['id'].'">';
																			
																			if($_REQUEST['action_back'] == "premiumscroll")
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . $buy_offer['id'] . '.png); background-position: center;" onclick="ChangeService('.$buy_offer['id'].', 0);">';
																			else
																			$main_content .= '<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url('.$layout_name.'/images/payment/serviceid_icon_normal.png);">';
																				$main_content .= '<div class="ServiceID_Icon" id="ServiceID_Icon_'.$buy_offer['id'].'" onclick="ChangeService('.$buy_offer['id'].', 0);" onmouseover="MouseOverServiceID('.$buy_offer['id'].', 0);" onmouseout="MouseOutServiceID('.$buy_offer['id'].', 0);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \''.$buy_offer['name'].'\', \''.$buy_offer['description'].'\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>
																					<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_'.$buy_offer['id'].'" style="display: none;">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>';
																					
																					if(strtotime("+1 month", $buy_offer['date']) > getdate()[0])
																					$main_content .= '<div class="RibbonNewProduct" style="background-image: url('.$layout_name.'/images/payment/ribbon-new-product.png);"></div>';
																					
																					if($buy_offer['hot'] > 0)
																					$main_content .= '<div class="RibbonLastChance" style="background-image: url('.$layout_name.'/images/payment/ribbon-last-chance.png);"></div>';
																					
																					if($_REQUEST['action_back'] <> "premiumscroll")
																					{
																					if($_REQUEST['action_back'] == "mount")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/mount/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					if($_REQUEST['action_back'] == "addon")
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(images/addons/' . $buy_offer['id'] . $config['site']['item_images_extension'] . '); background-repeat:no-repeat; background-position: center;"></div>';
																					else
																					$main_content .= '<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_'.$buy_offer['id'].'" style="background-image:url(/images/items/'.$buy_offer['item_id'].'.gif); background-repeat:no-repeat; background-position: center;"></div>';
																					}
																					$main_content .= '
																					<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_'.$buy_offer['id'].'"></div>
																					<label for="ServiceID_'.$buy_offer['id'].'">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_'.$buy_offer['id'].'" class="ServiceID" name="ServiceID" value="'.$buy_offer['id'].'">
																								<b>'.$buy_offer['name'].'</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_'.$buy_offer['id'].'"><b>'.$buy_offer['points'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
										</td>
										<td align="center">
										<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="'.$config['site']['lightborder'].'">
															<td><b>Category:</b></td>
															<td>'.htmlspecialchars($_REQUEST['offer_tcatg']).'</td>
															</tr>
															<tr bgcolor="'.$config['site']['darkborder'].'">
															<td width="20%"><b>Offer Name:</b></td>
															<td><b>'. htmlspecialchars($buy_offer['name']).'</b></td>
															</tr>
															<tr bgcolor="'.$config['site']['lightborder'].'">
															<td><b>Description:</b></td>
															<td><i>'. htmlspecialchars($buy_offer['description']).'</i></td>
															</tr>
															<tr bgcolor="'.$config['site']['darkborder'].'">
															<td><b>Price:</b></td>
															<td>'. htmlspecialchars($buy_offer['points']).' Tibia Coins</td>
															</tr>
															<tr bgcolor="'.$config['site']['lightborder'].'">
															<td><b>Player Name:</b></td>
															<td>'.htmlspecialchars($buy_player->getName()).'</td>
															</tr>';
															if(!empty($buy_from))
															$main_content .= '<tr bgcolor="'.$config['site']['darkborder'].'">
															<td width="20%"><b>Sent by:</b></td>
															<td>'.htmlspecialchars($buy_from).'</td>
															</tr>';
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
										</tr>
									</tbody></table>
									<table>
										<tbody><tr align="center">
											<td align="center">
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="'.$config['site']['darkborder'].'">
															<form action="?subtopic=webstore&action=confirm_transaction" method="POST">
															<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
															<td><nobr><input type="checkbox" name="agreement" value="true" required /> I have read and I agree to the <a href="/?subtopic=tibiarules&action=shop" target="_blank">Tibia Service Agreement</a>.</nobr></td>
															</tr>
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
										</tr>
									</tbody></table>
									</td>
									</tr>
										 </div>  </table></div></td></tr><br>
										<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<input type="hidden" name="buy_confirmed" value="yes"><input type="hidden" name="ServiceID" value="'.$buy_id.'"><input type="hidden" name="buy_from" value="'.htmlspecialchars($buy_from).'"><input type="hidden" name="buy_name" value="'.htmlspecialchars($buy_name).'"><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left">
										<form action="?subtopic=webstore" method="POST">
										<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
						<input type="hidden" name="action" value="select_player">
						<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>
										';
									}
								}
								else
								{
									$errormessage .= 'Player with name <b>'.htmlspecialchars($buy_name).'</b> doesn\'t exist. Please <a href="?subtopic=webstore&action=select_player&ServiceID='.$buy_id.'">select other name</a>.';
								}
							}
							else
							{
								$errormessage .= 'Invalid name format. Please <a href="?subtopic=webstore&action=select_player&ServiceID='.$buy_id.'">select other name</a> or contact with administrator.';
							}
						}
						else
						{
							$errormessage .= 'For this item you need <b>'.$buy_offer['points'].'</b> points. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please <a href="?subtopic=webstore">select other item</a> or buy Tibia Coins.';
						}
					}
					else
					{
						$errormessage .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="?subtopic=webstore">select item</a> again.';
					}
				}
			}
		}
		if(!empty($errormessage))
		{
			$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
				<TR><TD BGCOLOR="'.$config['site']['darkborder'].'" ALIGN=left><b>'.$errormessage.'</b></TD></TR>
				</table></div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post>
				<input type="hidden" name="buy_from" value="'.$_REQUEST['buy_from'].'">
				<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="ServiceID" value="'.$_REQUEST['ServiceID'].'">
						<input type="hidden" name="buyer_c" value="'.$_REQUEST['buyer_c'].'">
						<input type="hidden" name="buy_tid" value="'.$_REQUEST['buy_tid'].'">
						<input type="hidden" name="action_back" value="'.$_REQUEST['action_back'].'">
						<input type="hidden" name="offer_tname" value="'.htmlspecialchars($_REQUEST['offer_tname']).'">
						<input type="hidden" name="offer_tprice" value="'.$_REQUEST['offer_tprice'].'">
						<input type="hidden" name="offer_tdesc" value="'.htmlspecialchars($item['offer_tdesc']).'">
						<input type="hidden" name="offer_tcatg" value="'.htmlspecialchars($_REQUEST['offer_tcatg']).'">
						<input type="hidden" name="action" value="select_player">
				<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
		if(!$set_session)
		{
			unset($_SESSION['viewed_confirmation_page']);
		}
	}
	}
	else
	$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Shop Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
	<TR><TD BGCOLOR="'.$config['site']['darkborder'].'"><center>Shop is currently closed. [to admin: edit it in \'config/config.php\']</TD></TR>
	</table></div>  </table></div></td></tr><br>
	';
	
	
	////////////////////////
	/// CHANGE CHAR NAME ///
	////////////////////////
	
	if($config['site']['shop_changecharname'])
{	
	$changeNameCost = $config['site']['shop_changecharNameCost'];

if($logged)
{
    if($account_logged->getCustomField('premium_points') >= $changeNameCost)
    {
        if($action == "changecharname")
        {
		if($_REQUEST['step'] == '')
		{
            echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_3">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changecharname.png); background-position: center;" onclick="ChangeService(3, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_3" onclick="ChangeService(3, 2);" onmouseover="MouseOverServiceID(3, 2);" onmouseout="MouseOutServiceID(3, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Character Name Change\', \'Buy a character name change to rename one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_3"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_3"></div>
																					<label for="ServiceID_3">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_3" class="ServiceID" name="action" value="changecharname">
																								<b>Character Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_3"><b>'.$config['site']['shop_changecharNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changecharname" />
						<input type="hidden" name="step" value="2" />
						<input type="hidden" name="action_back" value="extraservice" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select name="player_id">
															';
            $account_players = $account_logged->getPlayersList();
            foreach($account_players as $player)
            {
                echo '<option value="' . $player->getID() . '">' . htmlspecialchars($player->getName()) . '</option>';
            }
            echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" ></div></div></form></td></tr></table>';
        }
		if($_REQUEST['step'] == '2')
		{
		$charToEdit = new Player($_REQUEST['player_id']);
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_3">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changecharname.png); background-position: center;" onclick="ChangeService(3, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_3" onclick="ChangeService(3, 2);" onmouseover="MouseOverServiceID(3, 2);" onmouseout="MouseOutServiceID(3, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Character Name Change\', \'Buy a character name change to rename one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_3"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_3"></div>
																					<label for="ServiceID_3">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_3" class="ServiceID" name="action" value="changecharname">
																								<b>Character Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_3"><b>'.$config['site']['shop_changecharNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changecharname" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select name="player_id" disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Name:</b></td>
															<td><input type="text" name="new_name" autocomplete="off" required=""/></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '
		<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="changecharname" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		
		}
		if($_REQUEST['step'] == '3')
		{
		$newchar_errors = array();
            $newchar_name = ucwords(strtolower(trim($_REQUEST['new_name'])));
            if(empty($newchar_name))
                $newchar_errors[] = 'Please enter a new name for your character!';
            if(!check_name_new_char($newchar_name))
                $newchar_errors[] = 'This name contains invalid letters, words or format. Please use only a-Z, - , \' and space.';
            $check_name_in_database = new Player();
            $check_name_in_database->find($newchar_name);
            if($check_name_in_database->isLoaded())
                $newchar_errors[] = 'This name is already used. Please choose another name!';

            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_3">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changecharname.png); background-position: center;" onclick="ChangeService(3, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_3" onclick="ChangeService(3, 2);" onmouseover="MouseOverServiceID(3, 2);" onmouseout="MouseOutServiceID(3, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Character Name Change\', \'Buy a character name change to rename one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_3" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_3"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_3"></div>
																					<label for="ServiceID_3">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_3" class="ServiceID" name="action" value="changecharname">
																								<b>Character Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_3"><b>'.$config['site']['shop_changecharNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changechar" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<input type="hidden" name="new_name" value="'.$_REQUEST['new_name'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Name:</b></td>
															<td><input type="text" value="'.ucwords(strtolower(trim($_REQUEST['new_name']))).'" disabled/></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changecharname" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changecharname" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changecharname" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		}
        elseif($action == "changechar")
        {
            $newchar_errors = array();
            $newchar_name = ucwords(strtolower(trim($_REQUEST['new_name'])));
            if(empty($newchar_name))
                $newchar_errors[] = 'Please enter a new name for your character!';
            if(!check_name_new_char($newchar_name))
                $newchar_errors[] = 'This name contains invalid letters, words or format. Please use only a-Z, - , \' and space.';
            $check_name_in_database = new Player();
            $check_name_in_database->find($newchar_name);
            if($check_name_in_database->isLoaded())
                $newchar_errors[] = 'This name is already used. Please choose another name!';

            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';

            if(empty($newchar_errors))
            {
			echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:bold;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
                echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Name Changed</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
				<table><tr><td>Name of character <b>' . htmlspecialchars($charToEdit->getName()) . '</b> changed to <b>' . htmlspecialchars($newchar_name) . '</b></td></tr></table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
                $charToEdit->setName($newchar_name);
                $charToEdit->save();
                $account_logged->setCustomField('premium_points', $account_logged->getCustomField('premium_points') - $changeNameCost);
            }
            else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changecharname" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
        }
    }
    elseif(($action == "changecharname") or ($action == "changechar"))
        echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
		<table><tr><td>You need <b>' . $changeNameCost . '</b> to Change the Name of your Character. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.</td></tr></table>
		</div>  </table></div></td></tr><br>
		<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
elseif(($action == "changecharname") or ($action == "changechar"))
    echo 'You must login first.';
}

	////////////////////////
	///. CHANGE ACC NAME ///
	////////////////////////
	
	if($config['site']['shop_changeaccname'])
{	
	$changeNameCost = $config['site']['shop_changeaccNameCost'];

if($logged)
{
    if($account_logged->getCustomField('premium_points') >= $changeNameCost)
    {
        if($action == "changeaccname")
        {
		if($_REQUEST['step'] == '')
		{
            echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Account Data</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_1">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changeaccname.png); background-position: center;" onclick="ChangeService(1, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_1" onclick="ChangeService(1, 2);" onmouseover="MouseOverServiceID(1, 2);" onmouseout="MouseOutServiceID(1, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Account Name Change\', \'Buy an account name change to select a different name for your account.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_1"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_1"></div>
																					<label for="ServiceID_1">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_1" class="ServiceID" name="action" value="changeaccname">
																								<b>Account Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_1"><b>'.$config['site']['shop_changeaccNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changeaccname" />
						<input type="hidden" name="step" value="2" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Account Name:</b></nobr></td>
															<td><select name="acc_id" disabled>
															<option value="' . $account_logged->getId() . '">' . strtoupper($account_logged->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Recovery Key:</b></nobr></td>
															<td><input type="text" name="rec_key1" size="4" maxlength="4" autocomplete="off" required=""/> - <input type="text" name="rec_key2" size="4" maxlength="4" autocomplete="off" required=""/> - <input type="text" name="rec_key3" size="4" maxlength="4" autocomplete="off" required=""/> - <input type="text" name="rec_key4" size="4" maxlength="4" autocomplete="off" required=""/></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Email:</b></td>
															<td><input type="text" name="acc_mail" autocomplete="off" required=""/></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" ></div></div></form></td></tr></table>';
        }
		if($_REQUEST['step'] == '2')
		{
		
		$charToEdit = new Player($_REQUEST['player_id']);
		$reckey = $account_logged->getCustomField("key");
		$reckeysent = $_REQUEST['rec_key1'].'-'.$_REQUEST['rec_key2'].'-'.$_REQUEST['rec_key3'].'-'.$_REQUEST['rec_key4'];
		
		$newchar_errors = array();
            $newchar_name = strtoupper(trim($_REQUEST['new_name']));
            if(empty($reckey))
                $newchar_errors[] = 'This account is not registred. Doesnt\'t have recovery key!';
			if($reckeysent <> $reckey)
				$newchar_errors[] = 'Fill the account recovery key correctly';
            if($_REQUEST['acc_mail'] <> $account_logged->getEMail())
                $newchar_errors[] = 'Fill the account email correctly.';
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Account Data</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_1">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changeaccname.png); background-position: center;" onclick="ChangeService(1, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_1" onclick="ChangeService(1, 2);" onmouseover="MouseOverServiceID(1, 2);" onmouseout="MouseOutServiceID(1, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Account Name Change\', \'Buy an account name change to select a different name for your account.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_1"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_1"></div>
																					<label for="ServiceID_1">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_1" class="ServiceID" name="action" value="changeaccname">
																								<b>Account Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_1"><b>'.$config['site']['shop_changeaccNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changeaccname" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" />
						<input type="hidden" name="acc_mail" value="'.$_REQUEST['acc_mail'].'" />
						<input type="hidden" name="rec_key1" value="'.$_REQUEST['rec_key1'].'" />
						<input type="hidden" name="rec_key2" value="'.$_REQUEST['rec_key2'].'" />
						<input type="hidden" name="rec_key3" value="'.$_REQUEST['rec_key3'].'" />
						<input type="hidden" name="rec_key4" value="'.$_REQUEST['rec_key4'].'" />
						<input type="hidden" name="acc_reckey" value="'.$_REQUEST['rec_key1'].'-'.$_REQUEST['rec_key2'].'-'.$_REQUEST['rec_key3'].'-'.$_REQUEST['rec_key4'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Account Name:</b></nobr></td>
															<td><select name="acc_id" disabled>
															<option value="' . $account_logged->getId() . '">' . strtoupper($account_logged->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Recovery Key:</b></nobr></td>
															<td><input type="text" name="rec_key1" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key1']).'" disabled/> - <input type="text" name="rec_key2" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key2']).'" disabled/> - <input type="text" name="rec_key3" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key3']).'" disabled/> - <input type="text" name="rec_key4" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key4']).'" disabled/></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Email:</b></nobr></td>
															<td><input type="text" name="acc_mail" value="'.strtoupper($_REQUEST['acc_mail']).'" disabled/></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Name:</b></td>
															<td><input type="text" name="new_name" autocomplete="off" required=""/></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '
		<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="changeaccname" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changeaccname" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changeaccname" /><input type="hidden" name="step" value="" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" /><input type="hidden" name="acc_mail" value="'.$_REQUEST['acc_mail'].'" /><input type="hidden" name="acc_reckey" value="'.$_REQUEST['acc_reckey'].'" /><input type="hidden" name="new_name" value="'.$_REQUEST['new_name'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		if($_REQUEST['step'] == '3')
		{
		$newchar_errors = array();
		
		$reckey = $account_logged->getCustomField("key");
		$reckeysent = $_REQUEST['acc_reckey'];
		
		$newchar_errors = array();
            $newchar_name = strtoupper(trim($_REQUEST['new_name']));
            if(empty($reckey))
                $newchar_errors[] = 'This account is not registred. Doesnt\'t have recovery key!';
			if($reckeysent <> $reckey)
				$newchar_errors[] = 'Fill the account recovery key correctly';
            if($_REQUEST['acc_mail'] <> $account_logged->getEMail())
                $newchar_errors[] = 'Fill the account email correctly.';
				
            $newacc_name = strtoupper(trim($_REQUEST['new_name']));
			if(empty($newacc_name))
			$newchar_errors[] = "Please enter account name.";
			$newnamecount = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('accounts').' WHERE name="'.$newacc_name.'";')->fetch();
			if($newnamecount[0] > 0)
			$newchar_errors[] = "This account name is already used.";
			if(!ctype_alnum($newacc_name))
			$newchar_errors[] = "Invalid account name format. Use only A-Z and numbers 0-9.";
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Account Data</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_1">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/changeaccname.png); background-position: center;" onclick="ChangeService(1, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_1" onclick="ChangeService(1, 2);" onmouseover="MouseOverServiceID(1, 2);" onmouseout="MouseOutServiceID(1, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Account Name Change\', \'Buy an account name change to select a different name for your account.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_1" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_1"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_1"></div>
																					<label for="ServiceID_1">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_1" class="ServiceID" name="action" value="changeaccname">
																								<b>Account Name Change</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_1"><b>'.$config['site']['shop_changeaccNameCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changeacc" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" />
						<input type="hidden" name="acc_mail" value="'.$_REQUEST['acc_mail'].'" />
						<input type="hidden" name="rec_key1" value="'.$_REQUEST['rec_key1'].'" />
						<input type="hidden" name="rec_key2" value="'.$_REQUEST['rec_key2'].'" />
						<input type="hidden" name="rec_key3" value="'.$_REQUEST['rec_key3'].'" />
						<input type="hidden" name="rec_key4" value="'.$_REQUEST['rec_key4'].'" />
						<input type="hidden" name="acc_reckey" value="'.$_REQUEST['acc_reckey'].'" />
						<input type="hidden" name="new_name" value="'.$_REQUEST['new_name'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Character Name Change</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a character name change to rename one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Account Name:</b></nobr></td>
															<td><select name="acc_id" disabled>
															<option value="' . $account_logged->getId() . '">' . strtoupper($account_logged->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Recovery Key:</b></nobr></td>
															<td><input type="text" name="rec_key1" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key1']).'" disabled/> - <input type="text" name="rec_key2" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key2']).'" disabled/> - <input type="text" name="rec_key3" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key3']).'" disabled/> - <input type="text" name="rec_key4" size="4" maxlength="4" value="'.strtoupper($_REQUEST['rec_key4']).'" disabled/></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><nobr><b>Email:</b></nobr></td>
															<td><input type="text" name="acc_mail" value="'.strtoupper($_REQUEST['acc_mail']).'" disabled/></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Name:</b></td>
															<td><input type="text" value="'.strtoupper(trim($_REQUEST['new_name'])).'" disabled/></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changeaccname" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" /><input type="hidden" name="acc_mail" value="'.$_REQUEST['acc_mail'].'" /><input type="hidden" name="rec_key1" value="'.$_REQUEST['rec_key1'].'" /><input type="hidden" name="rec_key2" value="'.$_REQUEST['rec_key2'].'" /><input type="hidden" name="rec_key3" value="'.$_REQUEST['rec_key3'].'" /><input type="hidden" name="rec_key4" value="'.$_REQUEST['rec_key4'].'" /><input type="hidden" name="acc_reckey" value="'.$_REQUEST['acc_reckey'].'" /><input type="hidden" name="new_name" value="'.$_REQUEST['new_name'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changeaccname" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changeaccname" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="acc_id" value="' . $account_logged->getId() . '" /><input type="hidden" name="acc_mail" value="'.$_REQUEST['acc_mail'].'" /><input type="hidden" name="rec_key1" value="'.$_REQUEST['rec_key1'].'" /><input type="hidden" name="rec_key2" value="'.$_REQUEST['rec_key2'].'" /><input type="hidden" name="rec_key3" value="'.$_REQUEST['rec_key3'].'" /><input type="hidden" name="rec_key4" value="'.$_REQUEST['rec_key4'].'" /><input type="hidden" name="acc_reckey" value="'.$_REQUEST['acc_reckey'].'" /><input type="hidden" name="new_name" value="'.$_REQUEST['new_name'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		}
        elseif($action == "changeacc")
        {
            $newchar_errors = array();
			
		$newchar_errors = array();
            $newacc_name = strtolower(trim($_REQUEST['new_name']));
			if(empty($newacc_name))
			$newchar_errors[] = "Please enter account name.";
			$newnamecount = $SQL->query('SELECT COUNT(*) FROM '.$SQL->tableName('accounts').' WHERE name="'.$newacc_name.'";')->fetch();
			if($newnamecount[0] > 0)
			$newchar_errors[] = "This account name is already used.";
			if(!ctype_alnum($newacc_name))
			$newchar_errors[] = "Invalid account name format. Use only A-Z and numbers 0-9.";
			
			$reckey = $account_logged->getCustomField("key");
		$reckeysent = $_REQUEST['acc_reckey'];
		
            if(empty($reckey))
                $newchar_errors[] = 'This account is not registred. Doesnt\'t have recovery key!';
			if($reckeysent <> $reckey)
				$newchar_errors[] = 'Fill the account recovery key correctly';
            if($_REQUEST['acc_mail'] <> $account_logged->getEMail())
                $newchar_errors[] = 'Fill the account email correctly.';

            if(empty($newchar_errors))
            {
			echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Account Data</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Name</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:bold;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
                echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Name Changed</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
				<table><tr><td>Account Name changed to <b>' . strtoupper($newacc_name) . '</b></td></tr>';
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
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>New Account Name!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
						<p>You or someone else changed your account name on server <a href="'.$config['server']['url'].'"><b>'.htmlspecialchars($config['server']['serverName']).'</b></a>.</p>
						<p>New Account Name: <b>' . strtoupper($newacc_name) . '</b></p>
<br /><br />
						<u>It\'s automatic e-mail. Do not reply!</u></br>
<br /><br />
Best regards,<br />
Team OT-BR.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><a href="http://'.$config['server']['url'].'/?subtopic=accountmanagement" target="_blank"><table width="108" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#ffffff; font-size:15px"><strong><em>Account Management</em></strong></font></td>
                  </tr>
                  <tr>
                    <td height="10" align="center" valign="middle" bgcolor="#6ebe44"> </td>
                  </tr>
                </table></a></td>
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
				<td width="10%" align="center">&nbsp;</td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td align="right"><a href="https://www.facebook.com/OpenTibiaBR" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td>&nbsp;</td>
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
								$mail->AddAddress($account_logged->getEMail());
								$mail->Subject = $config['server']['serverName']." - Account Name Changed";
								$mail->Body = $mailBody;
								if($mail->Send())
								{
									$account_logged->setName($newacc_name);
									$account_logged->save();
									$account_logged->setCustomField('premium_points', $account_logged->getCustomField('premium_points') - $changeNameCost);
									echo '<tr>We send a mail to <b>'.htmlspecialchars($account_logged->getEMail()).'</b> informating the change.</tr>';
								}
								else
									echo '<tr>An error occorred while sending email ( <b>'.htmlspecialchars($account_logged->getEMail()).'</b> ) with information! Account Name not changed. Try again.</tr>';
				echo '</table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
            else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changeaccname" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
        }
    }
    elseif(($action == "changeaccname") or ($action == "changeacc"))
        echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
		<table><tr><td>You need <b>' . $changeNameCost . '</b> to Change the Name of your Character. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.</td></tr></table>
		</div>  </table></div></td></tr><br>
		<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
elseif(($action == "changeaccname") or ($action == "changeacc"))
    echo 'You must login first.';
}	


	//////////////////////////
	/// CHANGE CHAR GENDER ///
	//////////////////////////	
	
if($config['site']['shop_changegender'])
{	
	$changeNameCost = $config['site']['shop_changeGenderCost'];

if($logged)
{
    if($account_logged->getCustomField('premium_points') >= $changeNameCost)
    {
        if($action == "changesex")
        {
		if($_REQUEST['step'] == '')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Set New Gender</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_4">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/sex.png); background-position: center;" onclick="ChangeService(4, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_4" onclick="ChangeService(4, 2);" onmouseover="MouseOverServiceID(4, 2);" onmouseout="MouseOutServiceID(4, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Change Character Gender\', \'Buy a Change Character Gender to change the gender of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_4"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_4"></div>
																					<label for="ServiceID_4">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_4" class="ServiceID" name="action" value="changesex">
																								<b>Change Character Gender</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_4"><b>'.$config['site']['shop_changeGenderCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changesex" />
						<input type="hidden" name="step" value="2" />
						<input type="hidden" name="action_back" value="extraservice" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Change Character Gender</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Change Character Gender to change the gender of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select name="player_id">
															';
            $account_players = $account_logged->getPlayersList();
            foreach($account_players as $player)
            {
                echo '<option value="' . $player->getID() . '">' . htmlspecialchars($player->getName()) . '</option>';
            }
            echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '2')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Set New Gender</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
$charToEdit = new Player($_REQUEST['player_id']);
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_4">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/sex.png); background-position: center;" onclick="ChangeService(4, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_4" onclick="ChangeService(4, 2);" onmouseover="MouseOverServiceID(4, 2);" onmouseout="MouseOutServiceID(4, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Change Character Gender\', \'Buy a Change Character Gender to change the gender of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_4"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_4"></div>
																					<label for="ServiceID_4">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_4" class="ServiceID" name="action" value="changesex">
																								<b>Change Character Gender</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_4"><b>'.$config['site']['shop_changeGenderCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changesex" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Change Character Gender</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Change Character Gender to change the gender of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Gender:</b></td>
															<td><select name="player_sex">
															<option value="0">Female</option>
															<option value="1">Male</option>
															</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="changesex" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '3')
		{
		
		$newchar_errors = array();
            $newchar_sex = trim($_REQUEST['player_sex']);
            $charToEdit = new Player($_REQUEST['player_id']);
			if($charToEdit->getSex() == $_REQUEST['player_sex'])
				$newchar_errors[] = 'Your Character already is of this gender.';
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Gender</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_4">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/sex.png); background-position: center;" onclick="ChangeService(4, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_4" onclick="ChangeService(4, 2);" onmouseover="MouseOverServiceID(4, 2);" onmouseout="MouseOutServiceID(4, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Change Character Gender\', \'Buy a Change Character Gender to change the gender of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_4" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_4"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_4"></div>
																					<label for="ServiceID_4">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_4" class="ServiceID" name="action" value="changesex">
																								<b>Change Character Gender</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_4"><b>'.$config['site']['shop_changeGenderCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="changegender" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<input type="hidden" name="player_sex" value="'.$_REQUEST['player_sex'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Change Character Gender</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Change Character Gender to change the gender of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>New Gender:</b></td>
															<td><select disabled>';
															if($_REQUEST['player_sex'] == 0)
															echo '<option>Female</option>';
															else
															echo '<option>Male</option>';
															
															echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changesex" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changesex" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="changesex" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		
        }
        elseif($action == "changegender")
        {
            $newchar_errors = array();
            $newchar_sex = trim($_REQUEST['player_sex']);

            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';

            if(empty($newchar_errors))
            {
			echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Set New Gender</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:bold;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
                echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Gender Changed</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
				<table><tr><td>The gender of <b>' . htmlspecialchars($charToEdit->getName()) . '</b> was changed</td></tr></table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';

                $charToEdit->setSex($newchar_sex);
                $charToEdit->save();
                $account_logged->setCustomField('premium_points', $account_logged->getCustomField('premium_points') - $changeNameCost);
            }
            else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=changesex" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
        }
    }
    elseif(($action == "changesex") or ($action == "changegender"))
        echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
		<table><tr><td>You need <b>' . $changeNameCost . '</b> to Change the Name of your Character. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.</td></tr></table>
		</div>  </table></div></td></tr><br>
		<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
elseif(($action == "changesex") or ($action == "changegender"))
    echo 'You must login first.';
}	
	
	////////////////////////
	///  REMOVE P. SKULL ///
	////////////////////////	

if($config['site']['shop_removeskull'])
{	
	$removeSkullCost = $config['site']['shop_removeSkullCost'];

if($logged)
{
    if($account_logged->getCustomField('premium_points') >= $removeSkullCost)
    {
        if($action == "removeskull")
        {
		if($_REQUEST['step'] == '')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Skull to Remove</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_5">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/removeskull.png); background-position: center;" onclick="ChangeService(5, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_5" onclick="ChangeService(5, 2);" onmouseover="MouseOverServiceID(5, 2);" onmouseout="MouseOutServiceID(5, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Remove Character Skull\', \'Buy a Remove Character Skull to remove the skull of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_5"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_5"></div>
																					<label for="ServiceID_5">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_5" class="ServiceID" name="action" value="removeskull">
																								<b>Remove Character Skull</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_5"><b>'.$config['site']['shop_removeSkullCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="removeskull" />
						<input type="hidden" name="step" value="2" />
						<input type="hidden" name="action_back" value="extraservice" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Remove Character Skull</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Remove Character Skull to remove the skull of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select name="player_id">
															';
            $account_players = $account_logged->getPlayersList();
            foreach($account_players as $player)
            {
                echo '<option value="' . $player->getID() . '">' . htmlspecialchars($player->getName()) . '</option>';
            }
            echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '2')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Skull to Remove</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
$charToEdit = new Player($_REQUEST['player_id']);
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_5">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/removeskull.png); background-position: center;" onclick="ChangeService(5, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_5" onclick="ChangeService(5, 2);" onmouseover="MouseOverServiceID(5, 2);" onmouseout="MouseOutServiceID(5, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Remove Character Skull\', \'Buy a Remove Character Skull to remove the skull of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_5"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_5"></div>
																					<label for="ServiceID_5">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_5" class="ServiceID" name="action" value="removeskull">
																								<b>Remove Character Skull</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_5"><b>'.$config['site']['shop_removeSkullCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="removeskull" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Remove Character Skull</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Remove Character Skull to remove the skull of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Skull:</b></td>
															<td><select name="player_skull">
															<option value="4">Red Skull</option>
															<option value="5">Black Skull</option>
															</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="removeskull" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '3')
		{
		
		$newchar_errors = array();
            $char_skull = trim($_REQUEST['player_skull']);
            $charToEdit = new Player($_REQUEST['player_id']);
			if($charToEdit->getSkull() < 4)
				$newchar_errors[] = 'This player doesn\'t have red skull or black skull.';
			if($charToEdit->getSkull() <> $char_skull)
				$newchar_errors[] = 'This player doesn\'t had the skull that you set in field <i>skull</i>.';
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Skull to Remove</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_5">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/removeskull.png); background-position: center;" onclick="ChangeService(5, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_5" onclick="ChangeService(5, 2);" onmouseover="MouseOverServiceID(5, 2);" onmouseout="MouseOutServiceID(5, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Remove Character Skull\', \'Buy a Remove Character Skull to remove the skull of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_5" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_5"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_5"></div>
																					<label for="ServiceID_5">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_5" class="ServiceID" name="action" value="removeskull">
																								<b>Remove Character Skull</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_5"><b>'.$config['site']['shop_removeSkullCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="skulldelete" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<input type="hidden" name="player_skull" value="'.$_REQUEST['player_skull'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Remove Character Skull</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Remove Character Skull to remove the skull of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Skull:</b></td>
															<td><select disabled>';
															if($_REQUEST['player_skull'] == 4)
															echo '<option>Red Skull</option>';
															else
															echo '<option>Black Skull</option>';
															
															echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="removeskull" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=removeskull" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="removeskull" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		
        }
        elseif($action == "skulldelete")
        {
            $newchar_errors = array();
			$char_skull = trim($_REQUEST['player_skull']);
			
            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
			if($charToEdit->getSkull() < 4)
				$newchar_errors[] = 'This player doesn\'t had red skull or black skull.';
			if($charToEdit->getSkull() <> $char_skull)
				$newchar_errors[] = 'This player doesn\'t had the skull that you set in field <i>skull</i>.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';

            if(empty($newchar_errors))
            {
			echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Skull to Remove</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:bold;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
                echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Skull Removed</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
				<table><tr><td>The skull of <b>' . htmlspecialchars($charToEdit->getName()) . '</b> was removed.</td></tr></table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';

                $charToEdit->setSkull(0);
				$charToEdit->setSkullTime(0);
                $charToEdit->save();
                $account_logged->setCustomField('premium_points', $account_logged->getCustomField('premium_points') - $removeSkullCost);
            }
            else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=removeskull" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
        }
    }
    elseif(($action == "removeskull") or ($action == "skulldelete"))
        echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
		<table><tr><td>You need <b>' . $removeSkullCost . '</b> to Change the Name of your Character. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.</td></tr></table>
		</div>  </table></div></td></tr><br>
		<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
elseif(($action == "removeskull") or ($action == "skulldelete"))
    echo 'You must login first.';
}	
	
	
	////////////////////////
	///  STAMINA RENEWER ///
	////////////////////////

if($config['site']['shop_refillstamina'])
{	
	$refillStaminaCost = $config['site']['shop_refillStaminaCost'];

if($logged)
{
    if($account_logged->getCustomField('premium_points') >= $refillStaminaCost)
    {
        if($action == "refillstamina")
        {
		if($_REQUEST['step'] == '')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:bold;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-blue.gif">
						<div class="StepText" style="font-weight:normal;">Stamina Refill</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
			<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_6">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/refillstamina.png); background-position: center;" onclick="ChangeService(6, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_6" onclick="ChangeService(6, 2);" onmouseover="MouseOverServiceID(6, 2);" onmouseout="MouseOutServiceID(6, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Refill Character Stamina\', \'Buy a Refill Character Stamina to refill the stamina of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_6"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_6"></div>
																					<label for="ServiceID_6">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_6" class="ServiceID" name="action" value="refillstamina">
																								<b>Refill Character Stamina</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_6"><b>'.$config['site']['shop_refillStaminaCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="refillstamina" />
						<input type="hidden" name="step" value="2" />
						<input type="hidden" name="action_back" value="extraservice" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Refill Character Stamina</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Refill Character Stamina to refill the stamina of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select name="player_id">
															';
            $account_players = $account_logged->getPlayersList();
            foreach($account_players as $player)
            {
                echo '<option value="' . $player->getID() . '">' . htmlspecialchars($player->getName()) . '</option>';
            }
            echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_red_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '2')
		{
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:bold;">Stamina Refill</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
$charToEdit = new Player($_REQUEST['player_id']);
			echo '
						<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_6">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/refillstamina.png); background-position: center;" onclick="ChangeService(6, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_6" onclick="ChangeService(6, 2);" onmouseover="MouseOverServiceID(6, 2);" onmouseout="MouseOutServiceID(6, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Refill Character Stamina\', \'Buy a Refill Character Stamina to refill the stamina of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_6"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_6"></div>
																					<label for="ServiceID_6">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_6" class="ServiceID" name="action" value="refillstamina">
																								<b>Refill Character Stamina</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_6"><b>'.$config['site']['shop_refillStaminaCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="refillstamina" />
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Refill Character Stamina</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Refill Character Stamina to refill the stamina of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Stamina Color:</b></nobr></td>
															<td><select name="player_stamina">
															<option value="3">Red</option>
															<option value="2">Orange</option>
															<option value="1">Green</option>
															</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
			echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="Next" alt="Next" src="'.$layout_name.'/images/buttons/_sbutton_next.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="action" value="refillstamina" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';

		}
		if($_REQUEST['step'] == '3')
		{
		
			$newchar_errors = array();
            $char_stamina = $_REQUEST['player_stamina'];
            $charToEdit = new Player($_REQUEST['player_id']);
			if($charToEdit->getStamina() >= 2520)
				$newchar_errors[] = 'This player stamina is full.';
			if($_REQUEST['player_stamina'] == 1 && $charToEdit->getStamina() <= 2400)
				$newchar_errors[] = 'This player stamina not is green.';
			if($_REQUEST['player_stamina'] == 2 && $charToEdit->getStamina() > 2400 || $_REQUEST['player_stamina'] == 2 && $charToEdit->getStamina() <= 840)
				$newchar_errors[] = 'This player stamina not is orange.';
			if($_REQUEST['player_stamina'] == 3 && $charToEdit->getStamina() > 840)
				$newchar_errors[] = 'This player stamina not is red.';
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';
		
		if(empty($newchar_errors))
        {
		echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Stamina Refill</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:bold;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
						<div class="StepText" style="font-weight:normal;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
			echo '
						<div class="TableContainer">  <div class="CaptionContainer">      <div class="CaptionInnerContainer">        <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <div class="Text">Selected Offer</div>        <span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>        <span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>        <span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>      </div>    </div><div class="InnerTableContainer">
						</div><table class="Table4" cellpadding="0" cellspacing="0">            <tbody><tr>
						<td>
						<div class="ServiceID_Icon_Container" id="ServiceID_Icon_Container_6">
																			<div class="ServiceID_Icon_Container_Background" id="" style="background-image:url(' . $config['site']['item_images_url'] . '/refillstamina.png); background-position: center;" onclick="ChangeService(6, 2);">
																				<div class="ServiceID_Icon" id="ServiceID_Icon_6" onclick="ChangeService(6, 2);" onmouseover="MouseOverServiceID(6, 2);" onmouseout="MouseOutServiceID(6, 2);">
																					<div class="PermanentDeactivated">
																						<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Refill Character Stamina\', \'Buy a Refill Character Stamina to refill the stamina of one of your characters.\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_HelperDiv"></div>
																						</span>
																					</div>';
																					
																					if($logged)
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="display: none;">';
																					else
																						echo '<div class="PermanentDeactivated ServiceID_Deactivated_ByChoice" id="ServiceID_NotAllowed_6" style="/* display: none; */">';

																						echo '<span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), \'Service Info:\', \'<p>Login to see the complete details of this offer!</p>\', \'\');" onmouseout="$(\'#HelperDivContainer\').hide();">
																							<div class="ServiceID_Deactivated" style="background-image: url('.$layout_name.'/images/payment/serviceid_deactivated.png);"></div>
																						</span>
																					</div>
																					<div class="ServiceID_Icon_New" id="ServiceID_Icon_New_6"></div>';
																					if($logged)
																					echo '<div class="ServiceID_Icon_Over" id="ServiceID_Icon_Over_6"></div>
																					<label for="ServiceID_6">
																						<div class="ServiceIDLabelContainer">
																							<div class="ServiceIDLabel">
																								<input type="radio" id="ServiceID_6" class="ServiceID" name="action" value="refillstamina">
																								<b>Refill Character Stamina</b></div>
																						</div>
																						<div class="ServiceIDPriceContainer"><span class="ServiceIDPrice" id="PD_6"><b>'.$config['site']['shop_refillStaminaCost'].' Tibia Coins</b></span></div>
																					</label>
																				</div>
																			</div>
																		</div>
						</td>
						<td>
						<br>
						<form action="?subtopic=webstore" method="post" class="ng-pristine ng-valid">
						<input type="hidden" name="subtopic" value="webstore" />
						<input type="hidden" name="action" value="staminarefiller" />
						<input type="hidden" name="action_back" value="extraservice" />
						<input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" />
						<input type="hidden" name="player_stamina" value="'.$_REQUEST['player_stamina'].'" />
						<table style="width:100%;">
										<tbody><tr>
											<td>
												<div class="TableShadowContainerRightTop">
													<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
												</div>
												<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
													<div class="TableContentContainer">
														<table border="1" cellpadding="4" cellspacing="1" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
															<tbody>
															<tr bgcolor="#F1E0C6">
															<td><b>Category:</b></td>
															<td>Extra Services</td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td width="20%"><b>Name:</b></td>
															<td><b>Refill Character Stamina</b></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><b>Description:</b></td>
															<td><i>Buy a Refill Character Stamina to refill the stamina of one of your characters.</i></td>
															</tr>
															<tr bgcolor="#D4C0A1">
															<td><b>Apply to:</b></td>
															<td><select disabled>
															<option value="'.$_REQUEST['player_id'].'">' . htmlspecialchars($charToEdit->getName()) . '</option>
															</select></td>
															</tr>
															<tr bgcolor="#F1E0C6">
															<td><nobr><b>Stamina Color:</b></nobr></td>
															<td><select disabled>';
															if($_REQUEST['player_stamina'] == 3)
															echo '<option value="3">Red</option>';
															if($_REQUEST['player_stamina'] == 2)
															echo '<option value="2">Orange</option>';
															if($_REQUEST['player_stamina'] == 1)
															echo '<option value="1">Green</option>';
															
															echo '</select></td>
															</tr>
															</tbody></table>
													</div>
												</div>
												<div class="TableShadowContainer">
													<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
														<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
														<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
													</div>
												</div>
											</td>
										</tr>
									</tbody></table>
									
						</td>
						</tr>
						  </tbody></table></div>
			';
            echo '<br>';
		echo '<table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><td width="1px" align="right">
										<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_green_over.gif);" ></div><input class="ButtonText" type="image" name="I Agree" alt="I Agree" src="'.$layout_name.'/images/buttons/_sbutton_iagree.gif" ></div></div></form></td>
										<td width="20%"></td><td width="1px" align="left"><form action="?subtopic=webstore" method="POST"><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="refillstamina" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Previous" alt="Previous" src="'.$layout_name.'/images/buttons/_sbutton_previous.gif" ></div></div></form></td></tr></table>';
		}
		else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=refillstamina" METHOD=post><input type="hidden" name="subtopic" value="webstore" /><input type="hidden" name="action" value="refillstamina" /><input type="hidden" name="step" value="2" /><input type="hidden" name="action_back" value="extraservice" /><input type="hidden" name="player_id" value="'.$_REQUEST['player_id'].'" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
		}
		
        }
        elseif($action == "staminarefiller")
        {
            $newchar_errors = array();
			$char_stamina = trim($_REQUEST['player_stamina']);
			
            $charToEdit = new Player($_REQUEST['player_id']);
            if(!$charToEdit->isLoaded())
                $newchar_errors[] = 'This player does not exist.';
			if($charToEdit->getStamina() >= 2520)
				$newchar_errors[] = 'This player stamina is full.';
			if($_REQUEST['player_stamina'] == 1 && $charToEdit->getStamina() <= 2400)
				$newchar_errors[] = 'This player stamina not is green.';
			if($_REQUEST['player_stamina'] == 2 && $charToEdit->getStamina() > 2400 || $_REQUEST['player_stamina'] == 2 && $charToEdit->getStamina() <= 840)
				$newchar_errors[] = 'This player stamina not is orange.';
			if($_REQUEST['player_stamina'] == 3 && $charToEdit->getStamina() > 840)
				$newchar_errors[] = 'This player stamina not is red.';
            if($charToEdit->isOnline())
                $newchar_errors[] = 'This player is ONLINE. Logout first.';
            elseif($account_logged->getID() != $charToEdit->getAccountID())
                $newchar_errors[] = 'This player is not on your account.';

            if(empty($newchar_errors))
            {
			echo '<div id="ProgressBar">
	<div id="MainContainer">
		<div id="BackgroundContainer">
			<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
			<div id="BackgroundContainerCenter">
				<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
				</div>
			</div>
			<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif">
		</div>
		<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif">
		<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
		<div id="FirstStep" class="Steps">
			<div class="SingleStepContainer">
				<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-1-green.gif">
				<div class="StepText" style="font-weight:normal;">Select service</div>
			</div>
		</div>
		<div id="StepsContainer1">
			<div id="StepsContainer2">
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
						<div class="StepText" style="font-weight:normal;">Select Player</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-0-green.gif">
						<div class="StepText" style="font-weight:normal;">Stamina Refill</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
						<div class="StepText" style="font-weight:normal;">Confirm your order</div>
					</div>
				</div>
				<div class="Steps" style="width:25%">
					<div class="TubeContainer">
						<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif">
					</div>
					<div class="SingleStepContainer">
						<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
						<div class="StepText" style="font-weight:bold;">Summary</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></br>';
                echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Stamina Refilled</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
				<table><tr><td>The stamina of <b>' . htmlspecialchars($charToEdit->getName()) . '</b> was refilled.</td></tr></table>
				</div>  </table></div></td></tr><br>
				<br/><center><form action="?subtopic=webstore" METHOD=post><input type="hidden" name="action" value="extraservice" /><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';

                $charToEdit->setStamina(2520);
                $charToEdit->save();
                $account_logged->setCustomField('premium_points', $account_logged->getCustomField('premium_points') - $refillStaminaCost);
            }
            else
            {
                echo '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
                foreach($newchar_errors as $e)
                {
                    echo '<li>' . $e . '</li>';
                }
                echo '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/><center><form action="?subtopic=webstore&action=refillstamina" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
            }
        }
    }
    elseif(($action == "refillstamina") or ($action == "staminarefiller"))
        echo '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >
		<table><tr><td>You need <b>' . $refillStaminaCost . '</b> to Change the Name of your Character. You have only <b>'.$user_premium_points.'</b> Tibia Coins. Please select other item or buy Tibia Coins.</td></tr></table>
		</div>  </table></div></td></tr><br>
		<br/><center><form action="?subtopic=webstore" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
elseif(($action == "refillstamina") or ($action == "staminarefiller"))
    echo 'You must login first.';
}	

	
	
	////////////////////
	///    NEW RK    ///
	////////////////////
	
	if($action == "newrk")
	{
	$reg_password = trim($_POST['reg_password']);
		$reckey = $account_logged->getCustomField("key");
		$reg_firstname = trim($_POST['firstname']);
		$reg_lastname = trim($_POST['lastname']);
		$reg_city = trim($_POST['city']);
		$reg_birthday = trim($_POST['dateofbirthday']);
		$reg_birthmonth = trim($_POST['dateofbirthmonth']);
		$reg_birthyear = trim($_POST['dateofbirthyear']);
		$reg_gender = trim($_POST['gender']);

		if((!$config['site']['generate_new_reckey'] || !$config['site']['send_emails']) || empty($reckey))
			$main_content .= 'You cant get new rec key';
		else
		{
		
			if($_REQUEST['step'] == '3')
			$points = $account_logged->getCustomField('premium_points');
			if($_POST['registeraccountsave'] == "1")
			{
					if($points >= $config['site']['generate_new_reckey_price'])
					{
							$dontshowtableagain = 1;
							$acceptedChars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
							$max = strlen($acceptedChars)-1;
							$new_rec_key = NULL;
							// 10 = number of chars in generated key
					for($i=0; $i < 4; $i++) {
						$cnum1[$i] = $acceptedChars{mt_rand(0, $max)};
						$new_rec_key1 .= $cnum1[$i];
					}
					for($i=4; $i < 8; $i++) {
						$cnum2[$i] = $acceptedChars{mt_rand(0, $max)};
						$new_rec_key2 .= $cnum2[$i];
					}
					for($i=8; $i < 12; $i++) {
						$cnum3[$i] = $acceptedChars{mt_rand(0, $max)};
						$new_rec_key3 .= $cnum3[$i];
					}
					for($i=12; $i < 16; $i++) {
						$cnum4[$i] = $acceptedChars{mt_rand(0, $max)};
						$new_rec_key4 .= $cnum4[$i];
					}
					$new_rec_key .= $new_rec_key1.'-'.$new_rec_key2.'-'.$new_rec_key3.'-'.$new_rec_key4;
							$main_content .= '
							<div id="ProgressBar">
					<div id="Headline">New Recovery Key</div>
					<div id="MainContainer">
						<div id="BackgroundContainer"> 
							<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
							<div id="BackgroundContainerCenter">
								<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
							</div>
						</div>
						<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif"> 
					</div>
					<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif"> 
					<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-green.gif">
					<div id="FirstStep" class="Steps">
						<div class="SingleStepContainer"> 
							<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
							<div class="StepText" style="font-weight:normal;&quot;">Registration Data</div>
						</div>
					</div>
					<div id="StepsContainer1">
						<div id="StepsContainer2">
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
									<div class="StepText" style="font-weight:normal;&quot;">Verification</div>
								</div>
							</div>
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-green.gif">
									<div class="StepText" style="font-weight:bold;&quot;">Recovery Key</div>
								</div>
							</div>
						</div>
					</div>
				</div>
						<div class="TableContainer">
							<div class="CaptionContainer">
									<div class="CaptionInnerContainer"> 
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>										
										<div class="Text">Account Registered</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									</div>
								</div><table class="Table1" cellpadding="0" cellspacing="0">
								
								<tbody><tr>
									<td>
										<div class="InnerTableContainer">
											
												Thank you for generate a new recovery key!<br><br><b>Important:</b><ul>
													<li>Write down this recovery key carefully.</li>
													<li>Store it at a safe place! Do not save it on your computer!</li>
													<li>You will not receive an email containing this recovery key.</li>
													<li>If you lose your recovery key, you can request a new one for a small fee at the Lost Account Interface.</li>
												</ul>
												<table>
							';
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
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#010101; font-size:24px"><strong><em>New Recovery Key!</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
						<p>You or someone else generated recovery key to your account on server <a href="'.$config['server']['url'].'"><b>'.htmlspecialchars($config['server']['serverName']).'</b></a>.</p>
						<p>Recovery key: <b>'.htmlspecialchars($new_rec_key).'</b></p>
<br /><br />
						<u>It\'s automatic e-mail. Do not reply!</u></br>
<br /><br />
Best regards,<br />
Team OT-BR.</font></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><a href="http://'.$config['server']['url'].'/?subtopic=accountmanagement" target="_blank"><table width="108" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="http://ot-br.com/images/mail/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, \'Times New Roman\', Times, serif; color:#ffffff; font-size:15px"><strong><em>Account Management</em></strong></font></td>
                  </tr>
                  <tr>
                    <td height="10" align="center" valign="middle" bgcolor="#6ebe44"> </td>
                  </tr>
                </table></a></td>
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
				<td width="10%" align="center">&nbsp;</td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=team" target="_blank" style="color:#010203; text-decoration:none"><strong>About </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules" target="_blank" style="color:#010203; text-decoration:none"><strong>Rules </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=agreement" target="_blank" style="color:#010203; text-decoration:none"><strong>Agreement </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><a href= "http://ot-br.com/index.php?subtopic=tibiarules&action=privacy" target="_blank" style="color:#010203; text-decoration:none"><strong>Privacy </strong></a></font></td>
                <td width="10%" align="center"><font style="font-family:\'Myriad Pro\', Helvetica, Arial, sans-serif; color:#010203; font-size:9px; text-transform:uppercase"><strong>|</strong></font></td>
                <td align="right"><a href="https://www.facebook.com/OpenTibiaBR" target="_blank"><img src="http://ot-br.com/images/mail/PROMO-GREEN2_09_01.jpg" alt="facebook" width="23" height="19" border="0" /></a></td>
                <td>&nbsp;</td>
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
								$mail->AddAddress($account_logged->getEMail());
								$mail->Subject = $config['server']['serverName']." - New Recovery Key";
								$mail->Body = $mailBody;
								if($mail->Send())
								{
									$account_logged->set("key", $new_rec_key);
									$account_logged->set("premium_points", $account_logged->get("premium_points")-$config['site']['generate_new_reckey_price']);
									$account_logged->set("first_name", $reg_firstname);
									$account_logged->set("last_name", $reg_lastname);
									$account_logged->set("gender", $reg_gender);
									$account_logged->set("location", $reg_city);
									$account_logged->set("dateofbirthday", $reg_birthday);
									$account_logged->set("dateofbirthmonth", $reg_birthmonth);
									$account_logged->set("dateofbirthyear", $reg_birthyear);
									$account_logged->save();
									$main_content .= '<br />Your recovery key were send on email address <b>'.htmlspecialchars($account_logged->getEMail()).'</b> for '.$config['site']['generate_new_reckey_price'].' premium points.';
								}
								else
									$main_content .= '<br />An error occorred while sending email ( <b>'.htmlspecialchars($account_logged->getEMail()).'</b> ) with recovery key! Recovery key not changed. Try again.';
							$main_content .= '</table>
					</div>
									</td></tr></tbody></table>
								</div>
							
						
						<br>
						<center>
							<table border="0" cellspacing="0" cellpadding="0">
								<form action="?subtopic=webstore" method="post">
									<tbody><tr>
										<td style="border:0px;"><input type="hidden" name="action" value="extraservice">
											<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
												<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
													<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif">
												</div>
											</div>
										</td>
									</tr>
								
							</tbody>
							</form>
							</table>
						</center>        									</div>';
					}
					else
						$reg_errors[] = 'You need '.$config['site']['generate_new_reckey_price'].' premium points to generate new recovery key. You have <b>'.$points.'<b> premium points.';
			}
			if($dontshowtableagain != 1)
			{
				//show errors if not empty
				if(!empty($reg_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($reg_errors as $reg_error)
						$main_content .= '<li>'.$reg_error.'</li>';
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
				}
				//show form
			if($_REQUEST['step'] == '')
			{
			//show form
			$main_content .= '
			<div id="ProgressBar">
					<div id="Headline">New Recovery Key</br><small>(Price: <b>'.$config['site']['generate_new_reckey_price'].' Tibia Coins</b>)</small></div>
					<div id="MainContainer">
						<div id="BackgroundContainer"> 
							<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
							<div id="BackgroundContainerCenter">
								<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
							</div>
						</div>
						<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif"> 
					</div>
					<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif"> 
					<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
					<div id="FirstStep" class="Steps">
						<div class="SingleStepContainer"> 
							<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
							<div class="StepText" style="font-weight:bold;&quot;">Registration Data</div>
						</div>
					</div>
					<div id="StepsContainer1">
						<div id="StepsContainer2">
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-blue.gif">
									<div class="StepText" style="font-weight:normal;&quot;">Verification</div>
								</div>
							</div>
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-blue.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
									<div class="StepText" style="font-weight:normal;&quot;">Recovery Key</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				Account registration offers many important advantages:
				<ul>
					<li>Registered users get a recovery key, which can be used to recover their accounts if they have lost access to the assigned email address.</li>
					<li>Registered users can request a new recovery key for a small fee.</li>
					<li>Extra Services can only be bought for registered accounts.</li>
					<li>Finally, only registered users can become tutor.</li>
				</ul>
				<b>NOTE:</b> The data given in the registration will be used exclusively for compiling internal statistical surveys. It will be treated in a strictly confidential manner.<br>
				<br>
				Please enter correct and complete data to make sure we can provide you with the best possible support. Above all, give your full address to make sure that our postal recovery letters will reach you. Note that all data entered in the registration can be re-edited later on.<br>
				<br>
				<form action="?subtopic=webstore&amp;action=newrk" method="post">
					<div class="TableContainer">
						<div class="CaptionContainer">
								<div class="CaptionInnerContainer"> 
									<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
									<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>									
									<div class="Text">Enter Registration Data</div>
									<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
									<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
									<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
								</div>
							</div><table class="Table1" cellpadding="0" cellspacing="0">
							
							<tbody><tr>
								<td><div class="InnerTableContainer">
										<table style="width:100%;">
											<tbody><tr>
												<td class="LabelV" width="120px"><span>First Name:</span></td>
												<td><input name="firstname" size="30" maxlength="30" required="" autocomplete="off"></td>
											</tr>
											<tr>
												<td class="LabelV"><span>Last Name:</span></td>
												<td><input name="lastname" size="30" maxlength="30" required="" autocomplete="off"></td>
											</tr>
											<tr>
												<td class="LabelV"><span>City:</span></td>
												<td><input name="city" size="40" maxlength="50" required="" autocomplete="off"></td>
											</tr>
												<tr><td class="LabelV"><span>Date of Birth:</span></td>
												<td>
													<select size="1" name="dateofbirthday" required="" autocomplete="off">
														<option value="0">---</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
													</select>
													<select size="1" name="dateofbirthmonth" required="" autocomplete="off">
														<option value="0">---</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>
													</select>
													<select size="1" name="dateofbirthyear" required="" autocomplete="off">
														<option value="0">---</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option>	
													</select>
												</td>
											</tr>
											<tr>
												<td class="LabelV"><span>Gender:</span></td>
												<td>
													<select size="1" name="gender" required="" autocomplete="off">
														<option value="">---</option>
														<option value="female">female</option>
														<option value="male">male</option>
													</select>
												</td>
											</tr>
										</tbody></table>
									</div>
								</td></tr></tbody></table>
							</div>
						
					
					<br>
					<table style="width:100%;">
					<tbody><tr align="center">
						<td><table border="0" cellspacing="0" cellpadding="0">
							<tbody><tr>
								<td style="border:0px;">
									<input type="hidden" name="function" value="confirmdata">
									<input type="hidden" name="step" value="2">
									<input type="hidden" name="source" value="start">
									<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
										<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
											<input class="ButtonText" type="image" name="Continue" alt="Continue" src="'.$layout_name.'/images/buttons/_sbutton_continue.gif">
										</div>
									</div>
								</td>							
							</tr><tr>
						
					</tr></tbody></table></form>
				</td>
				<td><table border="0" cellspacing="0" cellpadding="0">
						<form action="?subtopic=webstore&amp;action=extraservice" method="post">
							<tbody><tr>
								<td style="border:0px;">
									<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
										<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
											<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif">
										</div>
									</div>
								</td>
							</tr>
						
					</tbody>
					</form>
					</table>
				</td>
			</tr>
		</tbody></table>        									</div>
			';
			
			}
			if($_REQUEST['step'] == '2')
			{
			$main_content .= '
			<div id="ProgressBar">
					<div id="Headline">New Recovery Key</div>
					<div id="MainContainer">
						<div id="BackgroundContainer"> 
							<img id="BackgroundContainerLeftEnd" src="'.$layout_name.'/images/content/stonebar-left-end.gif">
							<div id="BackgroundContainerCenter">
								<div id="BackgroundContainerCenterImage" style="background-image:url('.$layout_name.'/images/content/stonebar-center.gif);">
							</div>
						</div>
						<img id="BackgroundContainerRightEnd" src="'.$layout_name.'/images/content/stonebar-right-end.gif"> 
					</div>
					<img id="TubeLeftEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-left-green.gif"> 
					<img id="TubeRightEnd" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-right-blue.gif">
					<div id="FirstStep" class="Steps">
						<div class="SingleStepContainer"> 
							<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-2-green.gif">
							<div class="StepText" style="font-weight:normal;&quot;">Registration Data</div>
						</div>
					</div>
					<div id="StepsContainer1">
						<div id="StepsContainer2">
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-3-green.gif">
									<div class="StepText" style="font-weight:bold;&quot;">Verification</div>
								</div>
							</div>
							<div class="Steps" style="width:50%">
								<div class="TubeContainer"> 
									<img class="Tube" src="'.$layout_name.'/images/content/progressbar/progress-bar-tube-green-blue.gif"> 
								</div>
								<div class="SingleStepContainer"> 
									<img class="StepIcon" src="'.$layout_name.'/images/content/progressbar/progress-bar-icon-4-blue.gif">
									<div class="StepText" style="font-weight:normal;&quot;">Recovery Key</div>
								</div>
							</div>
						</div>
					</div>
				</div>
						Please review the data you have entered. If you would like to correct data, click on "Back".<br>
						<br>
						<div class="TableContainer">
							<div class="CaptionContainer">
									<div class="CaptionInnerContainer"> 
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>										
										<div class="Text">Verify Registration Data</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span> 
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>

										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"></span>
									</div>
								</div><table class="Table1" cellpadding="0" cellspacing="0">
								
								<tbody><tr>
									<td><div class="InnerTableContainer">
											<table style="width:100%;">
												<tbody><tr>
													<td class="LabelV">First Name:</td>
													<td style="width:90%;">'.$_REQUEST['firstname'].'</td>
												</tr>
												<tr>
													<td class="LabelV">Last Name:</td>
													<td>'.$_REQUEST['lastname'].'</td>
												</tr>
												<tr>
													<td class="LabelV">City:</td>
													<td>'.$_REQUEST['city'].'</td>
												</tr>
												<tr>
													<td class="LabelV">Date of Birth:</td>
													<td>'.$_REQUEST['dateofbirthday'].'/'.$_REQUEST['dateofbirthmonth'].'/'.$_REQUEST['dateofbirthyear'].'</td>
												</tr>
												<tr>
													<td class="LabelV">Gender:</td>
													<td>'.$_REQUEST['gender'].'</td>
												</tr>												
											</tbody></table>
										</div>
									</td></tr></tbody></table>
								</div>
							
						
						<br>
						<table style="width:100%;">
							<tbody><tr align="center">
								<td>
								<form action="?subtopic=webstore&amp;action=newrk" method="post">
								<table border="0" cellspacing="0" cellpadding="0">
										<tbody><tr>
											<td style="border:0px;">
											<input type="hidden" name="registeraccountsave" value="1">
												<input type="hidden" name="function" value="getrecoverykey">
												<input type="hidden" name="firstname" value="'.$_REQUEST['firstname'].'">
												<input type="hidden" name="lastname" value="'.$_REQUEST['lastname'].'">
												<input type="hidden" name="city" value="'.$_REQUEST['city'].'">
												<input type="hidden" name="step" value="3">
												<input type="hidden" name="dateofbirthday" value="'.$_REQUEST['dateofbirthday'].'">
												<input type="hidden" name="dateofbirthmonth" value="'.$_REQUEST['dateofbirthmonth'].'">
												<input type="hidden" name="dateofbirthyear" value="'.$_REQUEST['dateofbirthyear'].'">
												<input type="hidden" name="gender" value="'.$_REQUEST['gender'].'">
												<input type="hidden" name="source" value="main">
												<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
													<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="visibility: hidden; background-image: url(&quot;'.$layout_name.'/images/buttons/sbutton_over.gif&quot;);"></div>
														<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif">
													</div>
												</div></td>
										</tr><tr>
									</tr></tbody></table>
									</form>
									</td>
								<td>
									<table border="0" cellspacing="0" cellpadding="0">
										<form action="?subtopic=webstore&amp;action=newrk" method="post">
											<tbody><tr>
												<td style="border:0px;">
													<input type="hidden" name="step" value="">
													<input type="hidden" name="firstname" value="'.$_REQUEST['firstname'].'">
													<input type="hidden" name="lastname" value="'.$_REQUEST['lastname'].'">
													<input type="hidden" name="city" value="'.$_REQUEST['city'].'">
													<input type="hidden" name="dateofbirthday" value="'.$_REQUEST['dateofbirthday'].'">
													<input type="hidden" name="dateofbirthmonth" value="'.$_REQUEST['dateofbirthmonth'].'">
													<input type="hidden" name="dateofbirthyear" value="'.$_REQUEST['dateofbirthyear'].'">
													<input type="hidden" name="gender" value="'.$_REQUEST['gender'].'">
													<input type="hidden" name="source" value="main">
													<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
														<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);"></div>
															<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif">
														</div>
													</div>
												</td>
											</tr>
										
									</tbody>
									</form>
									</table>
								</td>
							</tr>
						</tbody></table>        									</div>
						
			';
			}
			}
		}
	}