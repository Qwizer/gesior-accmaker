<?PHP
$host = "localhost"; /* HOST */
$user = "root"; /* USER */
$passwd = "fortera2017"; /* PASSWORD */
$db = "RelembraOT"; /* DB */
$retorno_token = '9F81ECDBC9554BB5BA82DE9AC26A700F'; // Token gerado pelo PagSeguro

##############################################################
#                         CONFIGURAÇÕES
##############################################################

if (empty($_POST['Referencia'])) { header("Location http://pagseguro.com.br");  }

list($accname, $world) = explode('-', $_POST['Referencia']);
if ($world=='sv') {
        $retorno_host = "$host"; // Local da base de dados MySql
        $retorno_database = "$db"; // Nome da base de dados MySql
        $retorno_usuario = "$user"; // Usuario com acesso a base de dados MySql
        $retorno_senha = "$passwd";  // Senha de acesso a base de dados MySql
}

###############################################################
#              NÃO ALTERE DESTA LINHA PARA BAIXOs#

$lnk = mysql_connect("$host", "$user", "$passwd") or die ('Nao foi possível conectar ao MySql: ' . mysql_error());
mysql_select_db("$db", $lnk) or die ('Nao foi possível ao banco de dados selecionado no MySql: ' . mysql_error());    

// Validando dados no PagSeguro
$PagSeguro = 'Comando=validar';
$PagSeguro .= '&Token=' . $retorno_token;
$Cabecalho = "Retorno PagSeguro";

foreach ($_POST as $key => $value)
{
 $value = urlencode(stripslashes($value));
 $PagSeguro .= "&$key=$value";
}

if (function_exists('curl_exec'))
{
 $curl = true;
}
elseif ( (PHP_VERSION >= 4.3) && ($fp = @fsockopen ('ssl://pagseguro.uol.com.br', 443, $errno, $errstr, 30)) )
{
 $fsocket = true;
}
elseif ($fp = @fsockopen('pagseguro.uol.com.br', 80, $errno, $errstr, 30))
{
 $fsocket = true;
}

if ($curl == true)
{
 $ch = curl_init();

 curl_setopt($ch, CURLOPT_URL, 'https://pagseguro.uol.com.br/Security/NPI/Default.aspx');
 curl_setopt($ch, CURLOPT_POST, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $PagSeguro);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_setopt($ch, CURLOPT_TIMEOUT, 30);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  curl_setopt($ch, CURLOPT_URL, 'https://pagseguro.uol.com.br/Security/NPI/Default.aspx');
  $resp = curl_exec($ch);

 curl_close($ch);
 $confirma = (strcmp ($resp, "VERIFICADO") == 0);
}
elseif ($fsocket == true)
{
 $Cabecalho  = "POST /Security/NPI/Default.aspx HTTP/1.0\r\n";
 $Cabecalho .= "Content-Type: application/x-www-form-urlencoded\r\n";
 $Cabecalho .= "Content-Length: " . strlen($PagSeguro) . "\r\n\r\n";

 if ($fp || $errno>0)
 {
    fputs ($fp, $Cabecalho . $PagSeguro);
    $confirma = false;
    $resp = '';
    while (!feof($fp))
    {
       $res = @fgets ($fp, 1024);
       $resp .= $res;
       if (strcmp ($res, "VERIFICADO") == 0)
       {
          $confirma=true;
          break;
       }
    }
    fclose ($fp);
 }
 else
 {
    echo "$errstr ($errno)<br />\n";
 }
}

if ($confirma) {
## Recebendo Dados ##
$TransacaoID = $_POST['TransacaoID'];
$VendedorEmail  = $_POST['VendedorEmail'];
$Referencia = $_POST['Referencia'];
$TipoFrete = $_POST['TipoFrete'];
$ValorFrete = $_POST['ValorFrete'];
$Extras = $_POST['Extras'];
$Anotacao = $_POST['Anotacao'];
$TipoPagamento = $_POST['TipoPagamento'];
$StatusTransacao = $_POST['StatusTransacao'];
$CliNome = $_POST['CliNome'];
$CliEmail = $_POST['CliEmail'];
$CliEndereco = $_POST['CliEndereco'];
$CliNumero = $_POST['CliNumero'];
$CliComplemento = $_POST['CliComplemento'];
$CliBairro = $_POST['CliBairro'];
$CliCidade = $_POST['CliCidade'];
$CliEstado = $_POST['CliEstado'];
$CliCEP = $_POST['CliCEP'];
$CliTelefone = $_POST['CliTelefone'];
$NumItens = intval($_POST['ProdValor_1']);
$ProdQuantidade_x = $POST['ProdQuantidade_1'];

# GRAVA OS DADOS NO BANCO DE DADOS #
mysql_query("INSERT into PagSeguroTransacoes SET
        TransacaoID='$TransacaoID',
        VendedorEmail='$VendedorEmail',
        Referencia='$Referencia',
        TipoFrete='$TipoFrete',
        ValorFrete='$ValorFrete',
        Extras='$Extras',
        Anotacao='$accname',
        TipoPagamento='$TipoPagamento',
        StatusTransacao='$StatusTransacao',
        CliNome='$CliNome',
        CliEmail='$CliEmail',
        CliEndereco='$CliEndereco',
        CliNumero='$CliNumero',
        CliComplemento='$CliComplemento',
        CliBairro='$CliBairro',
        CliCidade='$CliCidade',
        CliEstado='$CliEstado',
        CliCEP='$CliCEP',
        CliTelefone='$CliTelefone',
        NumItens='$NumItens',
        Data=now(),
ProdQuantidade_x='$ProdQuantidade_x';");

if ($StatusTransacao == "Aprovado") {
	$date = date('m/d/Y h:i:s a', time());
	
	$paylist = array("10" => 10,"20" => 20, "40" => 40, "80" => 100, "160" => 220, "300" => 500,);
	
	mysql_query("UPDATE accounts SET coins = coins + '$paylist[$NumItens]' WHERE name = '".htmlspecialchars($accname)."'");
	mysql_query("INSERT into pagamentos SET
	idtransacao_pagamento = '$TransacaoID',
	data_pagamento = now(),
	tipo_pagamento = 'PagSeguro',
	referencia_pagamento = '".htmlspecialchars($accname)."',
	valor_pagamento = '$NumItens',
	coins_pagamento = '$paylist[$NumItens]',
	status_pagamento = 'APROVADO';");
		
	mysql_query("UPDATE PagSeguroTransacoes SET StatusTransacao = 'Entregue' AND status = 1 WHERE CONVERT( `PagSeguroTransacoes`.`TransacaoID` USING utf8 ) = '$TransacaoID' AND CONVERT( `PagSeguroTransacoes`.`StatusTransacao` USING utf8 ) = 'Aprovado' LIMIT 1;");
	mysql_query('OPTIMIZE TABLE  `pagsegurotransacoes`');
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Donate Server</title>
<style type="text/css">
body {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 16px;
        width: 100%;
        margin: 0px auto;
        margin-top: 0px;
}
b {
        font-size: 18px;
        font-weight: bold;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="11%" align="center" valign="middle"><img src="images/true.png" height="auto" width="15" /></td>
    <td width="100%"><p><b>S</b>ua compra está sendo processada por nossos sistemas de apuração, dentro de no máximo 1 hora seus Tibia coins serão creditados, caso o pagamento não for efetuado, ficará em aberto 1 ou mais pagamentos pendentes em sua conta. Caso você tenha mais de 3 pagamentos pendentes por falta de pagamento, sua conta será bloqueada temporariamente para efetuar pagamentos.</p></td>
  </tr>
</table>
<!--p><b>ID de Transação:</b> <?php echo $_POST['TransacaoID']; ?></p-->
</body>
</html>