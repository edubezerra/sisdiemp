<html><head><meta charset="utf-8"></head>
<?php
	include_once("dbfunctions.php");
	include_once("conection.php");
	require('phpass-0.3/PasswordHash.php');
	
	function fail($pub, $pvt = '')
	{
		$msg = $pub;
		if ($pvt !== '')
			$msg .= ": $pvt";
		exit("An error occurred ($msg).\n");
	}
	// instancie a classe PasswordHash
	// o primeiro parâmetro deve ser um múltiplo de 2 e cujo log, na base 2,
	// representa o número de iterações de streching
	// por isso, melhor se algo entre 8 e 32. Maior que isso pode exigir
	// muito processamento.
	// o segundo parâmetro refere-se à possibilidade de compatibilidade
	// com versões antigas do PHP.
	$Hasher = new PasswordHash(8, FALSE);
	// gere o hash. Depois, pode guarda-lo como faria com a senha
	$senha = $_POST['senha'];
	$senhaHash = $Hasher->HashPassword($senha);
	if (strlen($senhaHash) < 20)
		fail('Falha ao criptografar senha');
	unset($hasher);
	$login = $_POST['login'];
	$query_select = "SELECT login FROM usuarios WHERE login = '$login'";
	$select = mysqli_query($c, $query_select);
	$array = mysqli_fetch_array($select);
	$logarray = $array['login'];
		if($login == "" || $login == null){
			echo"<script language='javascript' type='text/javascript'>alert('O campo login deve ser preenchido');window.location.href='cadastro.html';</script>";
	 
		}else{
			if($logarray == $login){
 
				echo"<script language='javascript' type='text/javascript'>alert('Esse login já existe');window.location.href='cadastro.html';</script>";
				die();
 
			}else{
				$query = "INSERT INTO usuarios (login,senha) VALUES ('$login','$senhaHash')";
				$insert = mysqli_query($c, $query);
				 
				if($insert){
					echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='login.html'</script>";
				}else{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro.html'</script>";
				}
			}
		}
	mysqli_close($c);
?></html>
