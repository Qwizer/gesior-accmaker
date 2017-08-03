<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$policyfile = "trusted.xml";
socket_bind($socket, "149.56.243.172", 843);
socket_listen($socket, 90);

while($client = socket_accept($socket)){
	
	if(socket_getpeername($client, $address, $port)) {
		echo "\nCliente $address conectou-se a porta $port \n";
	}
	
	$buffer = socket_read($client, 2048);
	
	echo "Clienet $address requisitou: $buffer \n";		
	echo "Enviando $policyfile conteúdo de volta para $address \n";
	
	$crossFile = file($policyfile);
	$crossFile = join('',$crossFile);
	
	socket_write($client, $crossFile . "\0");		
	socket_close($client);
}
socket_close($socket);

?>
