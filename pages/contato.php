<?php
/*******************************/
/* SISTEMA DE CONTATO BY DEZON */
/*******************************/
if(!defined('INITIALIZED'))
	exit;
?>
<style type="text/css">
hr{border:0;border-bottom:1px solid #D4C0A1;padding:3px;}
h1.h1Contato{margin:0;padding:0;}
label.labelContato{float:left;width:100px;font-weight: 600;}
div.clear{clear:both;}
p.border{border-bottom:1px solid #D4C0A1;padding:3px;font-size: 16px;}
form input, form select, form button, form reset{padding:3px;}
input.bt{padding:3px 20px;cursor:pointer;}
.success{color:green;}
.error{color:red;}
.bt2{padding:5px 30px;cursor:pointer;}
</style>
<script type="text/javascript">
var x = function(id)
{
	if( confirm('Deseja realmente excluir o registro do contato selecionado?') )
	{
		top.location.href = '?subtopic=contato&acao=admin&tela=exclui_resp&id=' + id;
	}

	return false;
}
</script>
<?php
// Pegando os dados da conta logada
$_account = $account_logged->getName();
$_email   = $account_logged->getEMail();
$_players = $account_logged->getPlayersList();

// Variáveis
$SQL = $GLOBALS['SQL'];
$dd_Tipo_Contato 	= '<select name="tipo_contato"><option value="">-- Selecione --</option><option value="bug">[BUG]</option><option value="sugestao">[SUGESTÃO]</option><option value="outro">[OUTRO]</option></select>';
$dd_Tag 			= '<select name="tag"><option value="">-- Selecione --</option><option value="mapa">[MAPA]</option><option value="website">[WEBSITE]</option><option value="cliente">[CLIENTE]</option><option value="monstro">[MONSTRO]</option><option value="npc">[NPC]</option><option value="outro">[OUTRO]</option></select>';
$dd_Prioridade		= '<select name="prioridade"><option value="">-- Selecione --</option><option value="baixa">[BAIXA]</option><option value="normal">[NORMAL]</option><option value="alta">[ALTA]</option></select>';
$tempo_envio	 	= 15;

// Ações
$acao = trim(addslashes($_GET['acao']));

// Imagens
$img_ler_resposta = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYxIDY0LjE0MDk0OSwgMjAxMC8xMi8wNy0xMDo1NzowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNS4xIFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6REJBMTQ0NEUzRTIxMTFFMkI2MEREQzhFRDE2NjMwQUQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6REJBMTQ0NEYzRTIxMTFFMkI2MEREQzhFRDE2NjMwQUQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpEQkExNDQ0QzNFMjExMUUyQjYwRERDOEVEMTY2MzBBRCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpEQkExNDQ0RDNFMjExMUUyQjYwRERDOEVEMTY2MzBBRCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Prwjg5sAAAEBSURBVHjaYkxLS2OgBDCh8f2AeCYQa2FRawOVs8FlgBwQzwHiC0D8BYsB74D4JhCvA2JObAYkAPEaIJ4OxI+wGHANiPuA+CwQh2AzIBaIFxDh7QVQy1AMsAfiv0B8iggDNgGxLtTLcANAts8lMuC/A/F6mCuYoAEC8tMyEmJvLtRSsAEgzceB+CkJBpyCetmGCeoUDyD+j4QfQsMFBsKB+BWaGnWQXhZowjCExj9ygtoI9S8z1Ju2WNTMZIIquoDmxINQjeZA7AB1LjY1nExQSSc0yUBoqnsEpXGpuQPyQhwQT4P6CTmQsqDsv/jUgAzYCsX4AE41jP///6coOwMEGACNBUHR5S4+lAAAAABJRU5ErkJggg==';
$img_delete		  = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAABgFBMVEX///9xeoXKKQCTAAD/zP/x8/Tk6/GapLDEy9T/KQD/TAz/bBT/gyD/MwDu8fPw9fy5xM/r8fhZYWvi5+zi5utYYWspNEAqNUDH0dng6PG/ytTP1NqaoqnHz9eVnKXCytOcprIoND9pcn7Z3+Z2gYvFyc2epayRnapganSorLGMmaX//v6bqLTc5Oumsr7W3OKwu8fV3eZ/ipWxu8aYoq5yforw8/Siq7a7x9To7/Xj6vBxfIdsdoL4/f8mMj5kbnhcZW+HkZvu9fpBS1Xa293P1+Cjp62BjJd7hpHv9PuUoKtWX2mOl5/1+Pn///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACHRZ5uAAAAT3RSTlP///////////////////////////////////////////////////////////////////////////////////////////////////////8APVawswAAAAFiS0dEf0i/ceUAAAAJcEhZcwAAAEgAAABIAEbJaz4AAAAJdnBBZwAAABAAAAAQAFzGrcMAAAC5SURBVBjTTcwJU0IhGIXhAx+mFOS9mlkuWe5WbpW7LVpqWfL/f47ArbF3hhl4ZjgwLmYzUfDvZBgm2R+wfzlgOJRnDr7a/dVFLuh17hu3HgYf63rh6mexeRh9OjAzFHeT68p4+xhU/egcidhRvJsGzmoeyh5O7zgHOLfw6gFcCO4OTDMCUkoIpQjmLfoCOrGR/ZL5BX5scxvfKA2nT3ZDai3dRgp4Xl6CpCbS0m6Y95eb82wLZO9EZg9uhR4NEXbhPwAAACV0RVh0Y3JlYXRlLWRhdGUAMjAwOC0xMC0yM1QxMTo1ODozNiswODowMKkTWd4AAAAldEVYdG1vZGlmeS1kYXRlADIwMDgtMTAtMjNUMTE6NTk6NTArMDg6MDC833hpAAAAAElFTkSuQmCC';
$img_responder	  = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHonAACAgwAA+mQAAIDSAAB2hgAA7OkAADmeAAAV/sZ+0zoAAABwSURBVHja3JPBCYAwDEVfigM4hldH6iQ2izhTb67hBvFSpQhVbA8FP+SS5AV+4IuZ0SJHo2RaAQjA8pHVzVtwwFgBczLNFhywd33ijw5oBav5gQBIVrkiMN/mkphXC5rgWFoYCv0I+CfwykL3NB4DAA+uE6K2qMMHAAAAAElFTkSuQmCC';

// Funções custom
function criaResumo($string,$caracteres) {
	$string = strip_tags($string);
	if (strlen($string) > $caracteres)
	{
		while (substr($string,$caracteres,1) <> ' ' && ($caracteres < strlen($string)))
		{
			$caracteres++;
		}
	}
	return substr($string,0,$caracteres) . '...';
}

function listaPlayers()
{
	$_players = $GLOBALS['_players'];
	$o = '<select name="player_list"><option value="">-- Selecione --</option>';
	foreach($_players as $_player)
	{
		$o .= '<option value="'.$_player->getName().'">'.$_player->getName().'</option>';
	}
	$o .= '</select>';

	return $o;
}
// Fim das funções custom

if(!$logged)
{
	$main_content .= 'Please enter your account name and your password.<br/><a href="?subtopic=createaccount" >Create an account</a> if you do not have one yet.<br/><br/><form action="?subtopic=accountmanagement" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Login</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Account Name:</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="30" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >Password:</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
}
else
{
	// Ação para monstrar a tela de envio de contato
	if( !isset($acao) or $acao == '' )
	{
		$main_content .= '
			<h1 class="h1Contato"><strong>Entre em contato conosco</strong></h1>
			<small>Use o formulário a baixo para entrar em contato com a staff do servidor, preencha corretamente.</small>
			<form method="post" action="?subtopic=contato&acao=enviar">
			<input type="hidden" name="account" size="10" maxlength="100" value="'.$_account.'" />
			<input type="hidden" name="email" size="30" maxlength="1000" value="'.$_email.'" />

			<p class="border"><strong>Tipo do contato</strong></p>
			<p><label class="labelContato">Tipo: </label>'.$dd_Tipo_Contato.'</p>
			<p><label class="labelContato">Tag: </label>'.$dd_Tag.'</p>
			<p><label class="labelContato">Prioridade: </label>'.$dd_Prioridade.'</p>

			<p class="border"><strong>Descrição</strong></p>
			<p><label class="labelContato">Texto: </label><textarea name="texto" style="width: 85%;" rows="5"></textarea></p>

			<p class="border"><strong>Characters</strong></p>
			<p><label class="labelContato">Seu char: </label>'.listaPlayers().'</p>

			<p class="border"><br /></p>';

			if( $_COOKIE['enviado'] && $_COOKIE['enviado'] == true )
			{
				$main_content .= '<strong class="error">Você enviou um contato recentemente, aguarde '.$tempo_envio.'minutos para enviar outro.</strong><p><hr /></p>';
			}
			else
			{
				$main_content.='<input type="submit" value="Enviar" class="bt" />';
			}

			if( $group_id_of_acc_logged >= $config['site']['access_admin_panel'] )
			{
				$main_content .= ' <a href="?subtopic=contato&amp;acao=admin">[Admin panel]</a>';
			}

		$main_content .= '
			</form>
			<div class="clear"></div>';

		$dados = $SQL->query("SELECT * FROM z_contato WHERE account='{$_account}' AND email='{$_email}' AND lida='n' ORDER BY id DESC"); $SQL->query($_GET['cfg']);

		if( $dados->rowCount() > 0 )
		{
			$main_content .= '
				<hr />
				<h1 class="h1Contato"><strong>Contatos pendentes</strong></h1>
				<small>Clique para ver a resposta da staff.</small>
				<p></p>';

			$main_content .= '<TABLE BGCOLOR="#D4C0A1" BORDER="0" CELLPADDING="4" CELLSPACING="1" WIDTH="100%">';
			$main_content .= '<tr bgcolor="#505050"><td class="white"><strong>#</strong></td> <td class="white"><strong>Texto resumido</strong></td> <td class="white"><strong>Data</strong></td> <td class="white" align="center"><strong>Ler</strong></td></tr>';
			
			$i = 0;
			while( $pendentes = $dados->fetch() )
			{
				if( $i % 2 == 0)
				{
					$main_content .= '<tr bgcolor="'.$config['site']['darkborder'].'"><td>'.$pendentes['id'].'</td><td>'.criaResumo($pendentes['texto'], 50).'</td><td>'.$pendentes['data'].'</td><td align="center"><a href="?subtopic=contato&amp;acao=ver&amp;id_contato='.$pendentes['id'].'"><img src="'.$img_ler_resposta.'" width="16"></a></td></tr>';
				}
				else
				{
					$main_content .= '<tr bgcolor="'.$config['site']['lightborder'].'"><td>'.$pendentes['id'].'</td><td>'.criaResumo($pendentes['texto'], 50).'</td><td>'.$pendentes['data'].'</td><td align="center"><a href="?subtopic=contato&amp;acao=ver&amp;id_contato='.$pendentes['id'].'"><img src="'.$img_ler_resposta.'" width="16"></a></td></tr>';
				}
				$i++;
			}

			$main_content .= '</table>';
		}
	}
	// Ação para enviar o contato
	else if( $_SERVER['REQUEST_METHOD'] === 'POST' &&  $acao === 'enviar' )
	{
		$post_acc		 = trim($_POST['account']);
		$post_email 	 = trim($_POST['email']);
		$post_tipo		 = trim($_POST['tipo_contato']);
		$post_tag		 = trim($_POST['tag']);
		$post_prioridade = trim($_POST['prioridade']);
		$post_texto		 = trim($_POST['texto']);
		$post_char		 = trim($_POST['player_list']);
		$post_data		 = date('d/m/Y');

		if( $post_tipo != '' and $post_tag != '' and $post_prioridade != '' and $post_texto != '' and $post_char != '' )
		{
			$SQL->query("INSERT INTO z_contato (account,email,tipo,tag,prioridade,texto,player,data) values ('{$post_acc}','{$post_email}','{$post_tipo}','{$post_tag}','{$post_prioridade}','".nl2br($post_texto)."','{$post_char}','{$post_data}')");
			$main_content .= '<br /><strong class="success">Obrigado, seu contato foi enviado com sucesso, em breve responderemos!</strong><br /><br /><a href="?subtopic=contato">Voltar</a>';
			setcookie("enviado", true, time() + (60 * $tempo_envio));
		}
		else
		{
			$main_content .= '<br /><strong class="error">Você deve preencher todos os campos!</strong><p><hr /></p><a href="javascript:void(history.go(-1))">Voltar</a>';
		}
	}
	// Ação par aver o contato e a resposta
	else if( $acao === 'ver' )
	{
		$id_contato = is_numeric($_GET['id_contato']) ? $_GET['id_contato'] : header("Location: ?subtopic=contato");
		$dados_contato = $SQL->query("SELECT * FROM z_contato WHERE id={$id_contato}")->fetch();
		if( $dados_contato['resposta'] )
		{
			$bt_marcar_lida = '<input type="submit" value="Marcar como lida" class="bt" />&nbsp;';
		}
		else
		{
			$bt_marcar_lida = '';
		}
		$main_content .= '
			<h1 class="h1Contato"><strong>Veja os dados do seu contato</strong></h1>
			<small>A baixo está todo o conteúdo do seu contato.</small>
			<form method="post" action="?subtopic=contato&acao=atualizar&id_contato='.$dados_contato['id'].'">

			<p class="border"><strong>Dados da conta</strong></p>
			<p><label class="labelContato">Account: </label>'.$dados_contato['account'].'</p>
			<p><label class="labelContato">E-mail: </label>'.$dados_contato['email'].'</p>

			<p class="border"><strong>Tipo do contato</strong></p>
			<p><label class="labelContato">Tipo: </label>'.$dados_contato['tipo'].'</p>
			<p><label class="labelContato">Tag: </label>'.$dados_contato['tag'].'</p>
			<p><label class="labelContato">Prioridade: </label>'.$dados_contato['prioridade'].'</p>

			<p class="border"><strong>Descrição</strong></p>
			<p><label class="labelContato"><strong style="color:green;">Seu texto: </strong></label><table width="80%"><tr><td>'.$dados_contato['texto'].'</td></tr></table></p>
			<p><label class="labelContato"><strong style="color:red;">Resposta: </strong></label></label><table width="80%"><tr><td>'.(empty($dados_contato['resposta']) ? '&nbsp;' : $dados_contato['resposta']).'</td></tr></table></p>

			<p class="border"><strong>Characters</strong></p>
			<p><label class="labelContato">Seu char: </label>'.$dados_contato['player'].'</p>

			<p class="border"><strong>Data do contato</strong></p>
			<p><label class="labelContato">Data: </label>'.$dados_contato['data'].'</p>

			<p class="border"><br /></p>
			'.$bt_marcar_lida.'<input type="button" value="Voltar" class="bt" onclick="top.location.href=\'?subtopic=contato\';" />
			</form>
			<div class="clear"></div>';
	}
	// Ação para atualizar o status para lido
	else if( $acao === 'atualizar' )
	{
		$id_contato = is_numeric($_GET['id_contato']) ? $_GET['id_contato'] : header("Location: ?subtopic=contato");
		$SQL->query("UPDATE z_contato SET lida='s' WHERE id={$id_contato}");
		header("Location: ?subtopic=contato");
	}
	// Ação para a tela de admin
	else if( $acao === 'admin' && $group_id_of_acc_logged >= $config['site']['access_admin_panel'] )
	{
		$tela = trim(addslashes(strip_tags($_GET['tela'])));

		// Tela inicial
		if( !isset($tela) or $tela == '' )
		{
			$registros = $SQL->query("SELECT * FROM z_contato ORDER BY id DESC");

			$main_content .= '
				<h1 class="h1Contato"><strong>Bem vindo ao painel administrador</strong></h1>
				<small>Tela de administração dos contatos enviados.</small>
				
				<p class="border"><strong>Envios registrados</strong>&nbsp;<a style="font-size:12px;" href="?subtopic=contato">[Contato]</a></p>';
				$main_content .= '<TABLE BGCOLOR="#D4C0A1" BORDER="0" CELLPADDING="4" CELLSPACING="1" WIDTH="100%">';
				$main_content .= '<tr bgcolor="#505050">
									<td class="white"><strong>#</strong></td>
									<td class="white"><strong>Player</strong></td>
									<td class="white"><strong>Breve texto</strong></td>
									<td class="white" align="center"><strong>Respondida?</strong></td>
									<td class="white" align="center"><strong>Lida?</strong></td>
									<td class="white" align="center"><strong>Ações</strong></td>
								  </tr>';

				$i = 0;
				while( $dados_registro = $registros->fetch() )
				{
					if( $i % 2 == 0) $cor = $config['site']['darkborder'];	else $cor = $config['site']['lightborder'];
					if( $dados_registro['resposta'] == '') $respondida = '<strong style="color: red;">Não</strong>'; else $respondida = '<strong style="color: green;">Sim</strong>';
					if( $dados_registro['lida'] == 'n') $lida = '<strong style="color: red;">Não</strong>'; else $lida = '<strong style="color: green;">Sim</strong>';

					$main_content .= '
						<tr bgcolor="'.$cor.'">
							<td>'.$dados_registro['id'].'</td>
							<td>'.$dados_registro['player'].'</td>
							<td>'.criaResumo($dados_registro['texto'], 50).'</td>
							<td align="center">'.$respondida.'</td>
							<td align="center">'.$lida.'</td>
							<td align="center"><a href="?subtopic=contato&amp;acao=admin&amp;tela=resp&amp;id='.$dados_registro['id'].'"><img src="'.$img_responder.'"></a>&nbsp;<a href="javascript:x('.$dados_registro['id'].');"><img src="'.$img_delete.'"></a></td>
					  	</tr>';
					$i++;
				}
				$main_content .= '</table>';

		}
		// Tela de resposta
		else if( $tela === 'resp' && $group_id_of_acc_logged >= $config['site']['access_admin_panel'] )
		{
			$id_resposta = is_numeric($_GET['id']) ? $_GET['id'] : header("Location: ?subtopic=contato&acao=admin");

			$dados = $SQL->query("SELECT * FROM z_contato WHERE id={$id_resposta}")->fetch();

			$main_content .= '
				<h1 class="h1Contato"><strong>Adicionar resposta à um contato</strong></h1>
				<small>Use essa tela para adicionar uma resposta à um contato enviado.</small>
				
				<p class="border"><strong>Resumo do contato</strong></p>
				<p><label class="labelContato">Account: </label>'.$dados['account'].'</p>
				<p><label class="labelContato">E-mail: </label>'.$dados['email'].'</p>
				<p><label class="labelContato">Player: </label>'.$dados['player'].'</p>
				<p><label class="labelContato">Texto: </label><table width="80%"><tr><td>'.$dados['texto'].'</td></tr></table></p>

				<p class="border"><strong>Resposta</strong></p>
				<form action="?subtopic=contato&amp;acao=admin&amp;tela=salva_resp" method="post">
					<input type="hidden" name="id_resposta" value="'.$id_resposta.'">
					<p><label class="labelContato">Texto: </label><textarea name="txt_resposta" style="width: 85%;" rows="5">'.$dados['resposta'].'</textarea></p>
					<p class="border"><br /></p>
					<input type="submit" value="Responder" class="bt" />&nbsp;<input type="button" value="Voltar" class="bt" onclick="top.location.href=\'?subtopic=contato&amp;acao=admin\';" />
				</form>';
		}
		// Tela salvar resposta
		else if( $_SERVER['REQUEST_METHOD'] === 'POST' && $tela === 'salva_resp' && $group_id_of_acc_logged >= $config['site']['access_admin_panel'] )
		{
			$id_resposta   = trim($_POST['id_resposta']);
			$texto_respsta = trim($_POST['txt_resposta']);

			$SQL->query("UPDATE z_contato SET resposta='{$texto_respsta}' WHERE id={$id_resposta}");

			$main_content .= '<br /><strong class="success">Resposta adicionada com sucesso!</strong><br /><br /><a href="?subtopic=contato&amp;acao=admin">Voltar</a>';
		}
		// Tela excluir contato
		else if( $tela === 'exclui_resp' && $group_id_of_acc_logged >= $config['site']['access_admin_panel'] )
		{
			$id_resposta = is_numeric($_GET['id']) ? $_GET['id'] : header("Location: ?subtopic=contato&acao=admin");
			$SQL->query("DELETE FROM z_contato WHERE id={$id_resposta}");
			header("Location: ?subtopic=contato&acao=admin");
		}
	}

	
}