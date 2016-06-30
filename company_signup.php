<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
?>
<html>
<head>
<title>Cadastro de Empresa</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<meta charset="UTF-8">
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		
<script type="text/javascript">{
	
	//Função para vereficar se os campos foram preenchidos!
	function showResults(){
		var name=$(".campo:nth-of-type(1)").val();
		var code=$(".campo:nth-of-type(2)").val();
		var email=$(".campo:nth-of-type(3)").val();
		var comp=$(".campo:nth-of-type(4)").val();
		var start=$(".campo:nth-of-type(5)").val();
		var end=$(".campo:nth-of-type(6)").val();
		
		var info={nome: name, cnpj: code, email: email, comp: comp, start: start, fim: end};
		if(!name)
			alert("Cadastro não efetuado! \n É necessário inserir o nome da empresa.");
		else if (!code)
			alert("Cadastro não efetuado! \n É necessário inserir o CNPJ da empresa.");
		else if(!email)
			alert("Cadastro não efetuado! \n É necessário inserir o email da empresa.");
		else if(!comp)
			alert("Cadastro não efetuado! \n É necessário inserir o número da empresa.");
		else if(!start)
			alert("Cadastro não efetuado! \n É necessário inserir a data de início do convênio.");
		else if(end > 10 || end < 1)
			alert("Cadastro não efetuado! \n É necessário inserir tempo de convênio maior que 0 e menor que 10 anos.");
		else
			$.post("signup.php",info,function(data){
				$(".box").append(data);
			});
	}
}
</script>
</head>

<body>
<center>
	<div class="main">
		<a href="index.php">
		<div class="logo">
			<img id="cefetimg" src="logoCefet.gif" alt="LogoCefet">
		</div>
		</a>
		Sistema Diemp
		<div><a style=" color:white; width: 45px; margin-top:-25px; float: right; display: initial;" href="sair.php">Sair</a></div>
	</div>
	<div class="box">
		<div class="stdIntro">
			<span id="welcome">
				Cadastro de Empresas
			</span>
			<p><p><p>
			<div id="eu">
				<form class="form-wrapper">
					<label for="Nome ou Razão Social" style="padding-left: 10px"> Nome/Razão social  </label> 
					<label for="CNPJ" style="padding-left: 165px">	CNPJ </label> <br>
					<input type="text" class="campo" style="width: 300px; text-align: center" placeholder="Nome ou Razão Social" id="Nome ou Razão Social" required>
					<input type="text" class="campo" style="width: 300px; text-align: center padding-right:45px" placeholder="CNPJ" id="CNPJ" required > <br>
					
					<label for="Email" style="padding-left: 10px"> Email </label> 
					<label for="Numero" style="padding-left: 270px">Numero da empresa </label> <br>
					<input type="text" class="campo" id="email" style="width: 300px; text-align: center" placeholder="Email da empresa" id="Email" required>
					<input type="text" class="campo" style="width: 300px; text-align: center" placeholder="Número da Empresa" id="Numero" required> <br>
					
					<label for="Inicio" style="padding-left: 10px"> Inicio do convenio</label> 
					<label for="Anos" style="padding-left: 170px">Anos de duração </label> <br> 
					<input type="text" class="campo" style="width: 300px; text-align: center" placeholder="Inicio do Convênio" onfocus="(this.type='date')" id="Inicio" required>
 					<input type="number" class="campo" style="width: 300px; text-align: center" placeholder="Anos de Duração" id="Anos" required> <br>

					<input onclick="showResults()" value="Cadastrar" style="width: 300px; font-size: 16px;" class="submit" readonly> <br> <br>
				</form>
			</div><br>
		</div>
		<a href='javascript:window.history.go(-1)'><---Voltar  </a>	<br>
	</div>	
		
</center>
</body>
</html>