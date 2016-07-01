<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");

		
		$permission = mysqli_query($c,"SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");
		if (!$permission) {
		    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysqli_error();
		    exit;
		}

		if (mysqli_num_rows($permission) <= 0) {
			//echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
		    //exit;
		    $isAdmin=0;
		}else{
			$row = mysqli_fetch_assoc($permission);
			$isAdmin = $row["isAdmin"];
		}		

		if($isAdmin == 0){
			echo"<script language='javascript' type='text/javascript'>window.location.href='index_aluno.php';</script>";
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
			<div class="optionTitle">Aluno</div>
			<a href="student_search.php"><div class="option">Pesquisar</div></a>
			<a href="pesquisar_ano.php"><div class="option">Pesquisar por ano de estágio</div></a>
			<a href="student_import.php"><div class="secondoption">Importar estudantes</div></a>
	  </div>
	  
	  <div class="optionsDiv">
			<div class="optionTitle">Empresa</div>
			<a href="company_search.php"><div class="option">Pesquisar</div></a>
			<a href="company_signup.php"><div class="option">Cadastrar Empresa</div></a>
			<a href="company_signup.php"><div class="option">Cadastrar empresa conveniada </div></a>
			<a href="company_complete.php"><div class="secondoption">Completar Cadastros</div></a>
	  </div>
	  
	  <div class="optionsDiv">
			<div class="optionTitle">Estagiários</div>
			<a href="intern_search.php"><div class="secondoption">Pesquisar por Curso</div></a>
	  </div>

	  <div class="optionsDiv">
			<div class="optionTitle">Ofertas de Estágio</div>
			<a href="offers_admin.php"><div class="secondoption">Visualizar/Editar Ofertas</div></a>
			<a href="offer_signup.php"><div class="secondoption">Cadastrar Oferta</div></a>
	  </div>
	  
	  <br><br>
	</div>
	
	</center>
</body>

</html>
