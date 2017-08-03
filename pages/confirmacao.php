<img id="ContentBoxHeadline" class="Title" src="layouts/tibiacom/images/header/headline-buypoints.gif" alt="Contentbox headline">
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);
/*/by Victor Fasano Raful /*/
#Credits may cause the deleted file not working
if(isset($_POST["acao"]) && $_POST["acao"] == "enviar")
{require ("gravar.php");}
if(isset($msg))
echo "<div id=\"msg\">$msg</div>";
if($logged)
{
$main_content .= '
Nossa ferramenta de confirmaao de pagamento somente e valida para quem efetuou o pagamento verdadeiro, caso <b>nao</b> tenha efetuado nenhum tipo de transacao
e esta usando nossas ferramentas para uso indevido como mandar <b>"recadinhos"</b> o jogador podera ser <b>punido</b> em 5 dias corridos.<br /><br />
<div class="TableContainer">
<div class="CaptionContainer">  
<div class="CaptionInnerContainer">     
<span class="CaptionEdgeLeftTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);">
</span>  
<span class="CaptionEdgeRightTop" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);">
</span>   
<span class="CaptionBorderTop" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);">
</span>  
<span class="CaptionVerticalLeft" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);">
</span> 
<div class="Text">Confirmacao de Pagamento</div>        
<span class="CaptionVerticalRight" style="background-image: url(layouts/tibiacom/images/content/box-frame-vertical.gif);">
</span> 
<span class="CaptionBorderBottom" style="background-image: url(layouts/tibiacom/images/content/table-headline-border.gif);">
</span>   
<span class="CaptionEdgeLeftBottom" style="background-image: url(layouts/tibiacom/images/content/box-frame-edge.gif);">
</span> 
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
<td valign="middle" width="25px;">
<iframe src="https://docs.google.com/forms/d/1DW3WjLsjsNKcMD_w4o6OBZEhMz1fJYdj3JylJadSZVg/viewform?embedded=true" width="565" height="1045" frameborder="0" marginheight="0" marginwidth="0">Carregando...</iframe>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>';
}
else
{
$main_content .='
<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="5" WIDTH="100%">
<tr BGCOLOR="'.$config['site']['vdarkborder'].'">
<td CLASS="white"><b>Error</b></td>
</tr>
<tr BGCOLOR='.$config['site']['darkborder'].'>
<td><font size="5">Login first.</font><br /><br /><a href="index.php?subtopic=accountmanagement">Login</a> or <a href="index.php?subtopic=createaccount">Register</a>.</td>
</tr>
</TABLE>
';}
