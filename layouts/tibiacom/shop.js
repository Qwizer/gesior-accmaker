$(document).ready(function(){
  $("tr[id^='applicationtext-']").hide();
});
// 
// 
// // Hides and unhides the HTML elements with the specified names
//
// @param a_ElementsToHide HTML ID of the element to hide as string
//                         or an array of IDs as strings
// @param a_ElementsToShow HTML ID of the element to make visible
//                         as string or an array of IDs as strings
function ToggleVisibility(a_ElementsToHide, a_ElementsToShow)
{
  if (typeof (a_ElementsToHide) == 'object') { // array
    for (var i = 0; i < a_ElementsToHide.length(); ++i) {
      document.getElementById(a_ElementsToHide[i]).style.display = 'none';
    }
  } else if (typeof (a_ElementsToHide) == 'string') {
    document.getElementById(a_ElementsToHide).style.display = 'none';
  }

  if (typeof (a_ElementsToShow) == 'object') { // array
    for (var i = 0; i < a_ElementsToShow.length(); ++i) {
      document.getElementById(a_ElementsToShow[i]).style.display = 'block';
    }
  } else if (typeof (a_ElementsToShow) == 'string') {
    document.getElementById(a_ElementsToShow).style.display = 'block';
  }
}

function ToggleTrigger($a_This, a_TriggerName) {
  if($a_This.checked) {
    document.getElementById(a_TriggerName).style.display = 'block';
  } else {
    document.getElementById(a_TriggerName).style.display = 'none';
  }
}

// Adds a limitation of the maximum text length on a text area
// input, that is enforced by IMAGES
//
// All previously assigned event handlers of the text area are preserved.
//
// @param TextAreaID HTML ID of the text area
// @param MaxLen Positive int specifying the maximum number of characters
// that can be entered in the text area
function SetLenLimit(TextAreaID, MaxLen)
{
  var TextArea = document.getElementById(TextAreaID);
  if (TextArea == null) {
    CipLogError('SetLenLimit(): Input "' + TextAreaID + '" not found');
    return;
  }

  EnforceLenLimitClosure = function()
  {
    if (TextArea.value.length > MaxLen) {
      TextArea.value = TextArea.value.substring(0, MaxLen);
    }
  };
  AddEventHandler(TextArea, 'onkeyup', EnforceLenLimitClosure);
  AddEventHandler(TextArea, 'onblur', EnforceLenLimitClosure);
}

// Installs an event handler on a text area input that dynamically updates
// a counter showing the remaining allowed number of characters
// 
// All previously assigned event handlers of the text area are preserved.
// 
// @param TextAreaID HTML ID of the text area
// @param CounterID HTML ID of the span or div element where the remaining
// number of characters will be put in
// @param MaxLen Positive int specifying the maximum number of characters
// that can be entered in the text area
function SetRemainingLenCounter(TextAreaID, CounterID, MaxLen)
{
  var TextArea = document.getElementById(TextAreaID);
  if (TextArea == null) {
    CipLogError('SetLenLimit(): Text area input "' + TextAreaID + '" not found');
    return;
  }
  var Counter = document.getElementById(CounterID);
  if (Counter == null) {
    CipLogError('SetLenLimit(): Counter input "' + CounterID + '" not found');
    return;
  }

  UpdateCounterClosure = function()
  {
    Counter.innerHTML = MaxLen - TextArea.value.length;
  };
  AddEventHandler(TextArea, 'onkeyup', UpdateCounterClosure);
  AddEventHandler(TextArea, 'onblur', UpdateCounterClosure);
  TextArea.onkeyup();
}

// -------------------
// debugging functions
// -------------------

// Set to true to enable error logging
var EnableDebug = true;

// Default error logger, logs to the FireBug console
function CipLogError(ErrMsg)
{
  if (EnableDebug) {
    console.error(ErrMsg);
  }
}

// -------------------------
// internal helper functions
// -------------------------

// Adds a new event handler function to the specified event handler of
// a DOM object
// 
// The new event will be appended to the end of the call chain and
// will fire after the previous events have sucessfully completed.
// 
// @param Element DOM object that we want to add the event handler to
// @param EventHandlerName Name of the event handler function that we
// want to add the event to, e.g. 'onclick' or
// 'onkeyup'
// @param Function New event handler to be added to the existing ones
function AddEventHandler(Element, EventHandlerName, Function)
{
  var EventHandler = Element[EventHandlerName];
  if (EventHandler) {
    Element[EventHandlerName] = function()
    {
      EventHandler();
      Function();
    };
  } else {
    Element[EventHandlerName] = Function;
  }
}

var g_ActiveCharacter = 0;

function FocusCharacter(a_CharacterNumber, a_CharacterName, a_NumberOfCharacters)
{
  // it it was clicked on the same row there is nothing to do
  if (a_CharacterNumber == g_ActiveCharacter) {
    return;
  } else {
    g_ActiveCharacter = a_CharacterNumber;
  }
  // reset other row lines
  for (var i = 1; i <= a_NumberOfCharacters; i++) {
    if (i != a_CharacterNumber && document.getElementById('CharacterRow_' + i) != null) {
      document.getElementById('PlayButtonOf_' + i).style.display = 'none';
      document.getElementById('CharacterNumberOf_' + i).style.display = 'inline';
      document.getElementById('CharacterRow_' + i).style.fontWeight = 'normal';
      document.getElementById('CharacterOptionsOf_' + i).style.display = 'none';
      document.getElementById('CharacterNameOf_' + i).style.fontSize = '10pt';
    }
  }
  // set the new selected line
  document.getElementById('PlayButtonOf_' + a_CharacterNumber).style.display = 'block';
  document.getElementById('CharacterNumberOf_' + a_CharacterNumber).style.display = 'none';
  document.getElementById('CharacterRow_' + a_CharacterNumber).style.fontWeight = 'bold';
  document.getElementById('CharacterOptionsOf_' + a_CharacterNumber).style.display = 'block';
  document.getElementById('CharacterNameOf_' + a_CharacterNumber).style.fontSize = '13pt';
  document.getElementsByName('selectedcharacter')[0].value = document.getElementById('CharacterNameOf_' + a_CharacterNumber).innerHTML;
}

function InRowWithOverEffect(a_RowID, a_Color)
{
  document.getElementById(a_RowID).style.backgroundColor = a_Color;
}

function OutRowWithOverEffect(a_RowID, a_Color)
{
  document.getElementById(a_RowID).style.backgroundColor = a_Color;
}

function InMiniButton(a_Button, a_IsPreviewString)
{
  a_Button.src = IMAGES + "account/" + a_IsPreviewString + "play-button-over.gif";
}

function OutMiniButton(a_Button, a_IsPreview)
{
  a_Button.src = IMAGES + "account/" + a_IsPreview + "play-button.gif";
}

// TibiaWebsite_flashclientrelease/html/account/?subtopic=play&name=First+Char
function EnablePlayButton()
{
  l_Elements = document.getElementsByName("FlashClientPlayButton");
  for (var i = 0; i < l_Elements.length; i++) {
    l_PlayLink = l_Elements[i].getAttribute("playlink");
    l_PreviewState = l_Elements[i].getAttribute("previewstate");
    l_IsPreviewString = '';
    if (l_PreviewState > 1) {
      l_IsPreviewString = 'preview-';
    }
    if (g_FlashClientInPopUp == true) {
      l_Elements[i].innerHTML = '<a href="' + l_PlayLink + '" onClick="openGameWindow(\'' + l_PlayLink + '\'); return false;" ><img style="border:0px;" onMouseOver="InMiniButton(this, \'' + l_IsPreviewString + '\');" onMouseOut="OutMiniButton(this, \'' + l_IsPreviewString + '\');" src="' + IMAGES + 'account/' + l_IsPreviewString + 'play-button.gif" /></a>';
    } else {
      l_Elements[i].innerHTML = '<a href="' + l_PlayLink + '" ><img style="border:0px;" onMouseOver="InMiniButton(this, \'' + l_IsPreviewString + '\');" onMouseOut="OutMiniButton(this, \'' + l_IsPreviewString + '\');" src="' + IMAGES + 'account/' + l_IsPreviewString + 'play-button.gif" /></a>';
    }
  }
}

function ShowHelperDiv(a_ID)
{
  document.getElementById(a_ID).style.visibility = 'visible';
  document.getElementById(a_ID).style.display = 'block';
}

function HideHelperDiv(a_ID)
{
  document.getElementById(a_ID).style.visibility = 'hidden';
  document.getElementById(a_ID).style.display = 'none';
}

var g_EntityMap = {
  "&" : "&amp;",
  "<" : "&lt;",
  ">" : "&gt;",
  '"' : '&quot;',
  "'" : '&#39;',
  "/" : '&#x2F;'
};

function escapeHtml(a_String)
{
  return String(a_String).replace(/[&<>"'\/]/g, function(s)
  {
    return g_EntityMap[s];
  });
}

// build the helper div to display on mouse over
function BuildHelperDiv(a_DivID, a_IndicatorDivContent, a_Title, a_Text)
{
  var l_Qutput = '';
  l_Qutput += '<span class="HelperDivIndicator" onMouseOver="ActivateHelperDiv($(this), \'' + a_Title + '\', \'' + escapeHtml(a_Text) + '\');" onMouseOut="$(\'#HelperDivContainer\').hide();" >' + a_IndicatorDivContent + '</span>';
  return l_Qutput;
}

// build the helper div to display on mouse over
function BuildHelperDivLink(a_DivID, a_IndicatorDivContent, a_Title, a_Text, a_SubTopic)
{
  var l_Qutput = '';
  l_Qutput += '<a href="../common/help.php?subtopic=' + a_SubTopic + '" target="_blank" ><span class="HelperDivIndicator" onMouseOver="ActivateHelperDiv($(this), \'' + a_Title + '\', \'' + a_Text + '\');" onMouseOut="$(\'#HelperDivContainer\').hide();" >' + a_IndicatorDivContent + '</span></a>';
  return l_Qutput;
}

// displays a helper div at the current mause position
function ActivateHelperDiv(a_Object, a_Title, a_Text, a_HelperDivPositionID)
{
  var l_Left = 0;
  var l_Top = 0;
  if (a_HelperDivPositionID.length > 0) {
    l_Left = $('#' + a_HelperDivPositionID).offset().left;
    l_Top = $('#' + a_HelperDivPositionID).offset().top;
  } else {
    l_Left = (a_Object.offset().left + a_Object.width());
    l_Top = a_Object.offset().top;
  }
  $('#HelperDivContainer').css('top', l_Top);
  $('#HelperDivContainer').css('left', l_Left);
  $('#HelperDivHeadline').html(a_Title);
  $('#HelperDivText').html(a_Text);
  $('#HelperDivContainer').show();
}

// toggle collapsable tables
function CollapseTable(a_ID)
{
  $('#' + a_ID).slideToggle('slow');
  console.log($('#Indicator_' + a_ID).attr('class'));
  if ($('#Indicator_' + a_ID).attr('class') == 'CircleSymbolPlus') {
    $('#Indicator_' + a_ID).css('background-image', 'url(' + IMAGES + 'global/content/circle-symbol-minus.gif)');
    $('#Indicator_' + a_ID).attr('class', 'CircleSymbolMinus');
  } else {
    $('#Indicator_' + a_ID).css('background-image', 'url(' + IMAGES + 'global/content/circle-symbol-plus.gif)');
    $('#Indicator_' + a_ID).attr('class', 'CircleSymbolPlus');
  }
}

// toggle guild application text
function ToggleApplicationText(a_ID) {
  $("#applicationtext-" + a_ID).toggle("fast");
  if ($('#applicationcircle-' + a_ID).attr('class') == 'CircleSymbolPlus') {
    $('#applicationcircle-' + a_ID).css('background-image', 'url(' + IMAGES + 'global/content/circle-symbol-minus.gif)');
    $('#applicationcircle-' + a_ID).attr('class', 'CircleSymbolMinus');
  } else {
    $('#applicationcircle-' + a_ID).css('background-image', 'url(' + IMAGES + 'global/content/circle-symbol-plus.gif)');
    $('#applicationcircle-' + a_ID).attr('class', 'CircleSymbolPlus');
  }
}