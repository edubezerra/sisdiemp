<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");

		$isAdmin = 0;
		if($_COOKIE[tipo]!=0){
			$permission = mysqli_query($c, "SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");
			if (!$permission) {
			    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysqli_error();
			    exit;
			}

			if (mysqli_num_rows($permission) <= 0) {
				echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
			    exit;
			}

			$row = mysqli_fetch_assoc($permission);
			$isAdmin = $row["isAdmin"];
		}

		if($isAdmin == 1){
			echo"<script language='javascript' type='text/javascript'>window.location.href='index.php';</script>";
		}
	}
?>
<html>
<head>
<title>Sistema Diemp</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<meta charset="UTF-8">
</head>
<body>
	<center>
	<div class="main">
		<div class="logo">
			<img id="cefetimg" src="logoCefet.gif" alt="LogoCefet">
		</div>Sistema Diemp
		<div><a style=" color:white; width: 45px; margin-top:-25px; float: right; display: initial;" href="sair.php">Sair</a></div>
	</div>
	
	<div class="box">
	  <div class="intro">
		<span id="welcome">
			Bem-vindo ao <i>Sistema Diemp</i>
		</span>
		<br>
		<span id="info">
			Criado para o gerenciamento do Banco de Dados utilizado pelo Diemp. 
		</span>
	  </div>
	
	  <div class="optionsDiv">
			<div class="optionTitle">Ofertas de Estágio</div>
			<a href="offers_student.php"><div class="option">Visualizar Ofertas</div></a>
	  </div>
	  
	  <br><br>
	</div>
	
	</center>
</body>

</html>
