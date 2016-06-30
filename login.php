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
	$tipo = $_POST['tipo'];
	setcookie("tipo", $tipo);
    $senha	= $_POST['senha'];
        if (isset($entrar)) {
        	if($tipo == 0){
            	$query = mysqli_query($c,"SELECT senha FROM aluno WHERE Matricula = '$login'") or die("erro ao selecionar");
        	}else{
        		$query = mysqli_query($c,"SELECT senha FROM usuarios WHERE login = '$login' and isAdmin = 1 ") or die("erro ao selecionar");
        	}

			$row = mysqli_fetch_assoc($query);
			$senhaHash = $row["senha"];
			echo $senha;
                if (mysqli_num_rows($query)<=0){
                	if($tipo == 0){
                    	echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.html';</script>";
		        	}else{
                    	echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='diemp/login.html';</script>";
		        	}
                }else{
					if($Hasher->CheckPassword($senha, $senhaHash)){
						echo"<script language='javascript' type='text/javascript'>window.location.href='index.php';</script>";
					}
					else{
						if($tipo == 0){
	                    	echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.html';</script>";
			        	}else{
	                    	echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='diemp/index.html';</script>";
			        	}
					}
                }

        }
?>