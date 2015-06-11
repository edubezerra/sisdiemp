<html><head><meta charset="utf-8"></head><?php
	$host = localhost;
	$usuario = "root";
	$senha = "";
	$banco = "diemp";
	
	$c = mysql_connect($host,$usuario,$senha); // Conecta
	
	if(!$c){ // Checa conexão
		echo "Eerro na conexão<br>";
		echo mysql_error();
		die();
	}

	if(!mysql_select_db($banco)){ // Seleciona e checa banco
		echo "Erro no select_db<br>";
		echo mysql_error();
		mysql_close($c);
		die();
	}
	
	mysql_query("SET CHARACTER SET 'utf8'");
?></html>