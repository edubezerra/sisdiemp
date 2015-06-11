<?php
	$login = $_POST['login'];
	setcookie("login", $login);
	include_once("dbfunctions.php");
	include_once("conection.php");
	require('phpass-0.3/PasswordHash.php');
	// instancie a classe PasswordHash
	// o primeiro parâmetro deve ser um múltiplo de 2 e cujo log, na base 2,
	// representa o número de iterações de streching
	// por isso, melhor se algo entre 8 e 32. Maior que isso pode exigir
	// muito processamento.
	// o segundo parâmetro refere-se à possibilidade de compatibilidade
	// com versões antigas do PHP.
	$Hasher = new PasswordHash(8, FALSE);
	// gere o hash. Depois, pode guarda-lo como faria com a senha
	$entrar = $_POST['entrar'];
    $senha	= $_POST['senha'];
        if (isset($entrar)) {
            $query = mysql_query("SELECT senha FROM usuarios WHERE login = '$login'") or die("erro ao selecionar");
			$row = mysql_fetch_assoc($query);
			$senhaHash = $row["senha"];
                if (mysql_num_rows($query)<=0){
                    echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.html';</script>";
                }else{
					if($Hasher->CheckPassword($senha, $senhaHash)){
						echo("<script>window.location.href = 'index.php';</script>");
					}
					else{
						echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='sair.html';</script>";
					}
                }
        }
?>