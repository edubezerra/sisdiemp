<?php
	include_once("dbfunctions.php");
	include_once("conection.php");
	
	$cnpj = $_POST["cnpj"];
	$q = "select Nome, email from empresa where Cnpj = '$cnpj'";
	$query = mysqli_query($c, $q);
	
	$dados = mysqli_fetch_array($query); 
	$nome = $dados['Nome'];
	$email = $dados['email'];
	$saida = $nome.'|'.$email;
	echo '|'.$nome.'|'.$email;
	#testando o retorno de variaveis;
	#$test = "Test";
	#$test2 = "ainda testando";
	#echo $test;
	#echo $test2;
?> 