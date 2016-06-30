<html><head><meta charset="utf-8"></head><?php
	$host = localhost;
	$usuario = "root";
	$senha = "";
	$banco = "diemp";
	
	$c = mysqli_connect($host,$usuario,$senha,$banco); // Conecta
	
	if(!$c){ // Checa conexão
		echo "Erro na conexão<br>";
		echo mysqli_connect_error();
		die();
	}

	mysqli_query($c,"SET CHARACTER SET 'utf8'");
?></html>