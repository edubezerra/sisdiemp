<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	include_once("useful_functions.php");
	include_once("dbfunctions.php");
	include("conection.php");

	$aluno = $_REQUEST["student"];
	$id = $_REQUEST["id"];
	
	if(isset($aluno)){
		$cpf = soNumero($aluno);
	}
?>

<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		
<script type="text/javascript">
	function showResults(){
		var name=$("#search").val();
		
		var info={what:"company", descricao: name};
		var expCpf=new RegExp("[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}");
		
		if(name!=""){
			$.post("search.php",info,function(data){
				if (!$(".stdSearchResult").length) $(".agreement").append(data);
			});
		}
	}
	function fechar(type){
		if(type == 1){
			$("#newAgreement").attr("id","updateData");
			$(".updateData").css({"visibility" : "hidden", "display" : "none"});
			$("#linkIni").attr("href", "index.php").css("cursor","pointer");
		}
		if(type == 2){
			$("#newAgreement").remove();
			$("#linkIni").attr("href", "index.php").css("cursor","pointer");
		}
	}
	function sendInfo(url){
	    var inicio=$("input.inicio").val();
		var fim=$("input.fim").val();
		var empresa=$("input.empresa").val();
		window.location.href=url+"&inicio="+inicio+"&fim="+fim+"&empresa="+empresa;
	}	
	function newAgreement(){
		if (!$("#newAgreement").length){
			var conteudo="<div id='addNew'><h3><center>Novo Estágio</center></h3> CNPJ <input style='width:180px; margin-right:24px; float:right' name='cnpj' type='text' class='inputAtt'required><br><br>Data de Início <input name='inicio' class='inputAtt' style='margin-right:25px; float: right;' type='date' required><br><br>Data de Fim<input name='fim' type='date' style='margin-right:25px; float: right;' class='inputAtt' required><br><br> Estado <select name='estado' style='margin-right:25px; float: right' class='fim' required><option value='Em andamento'>Em andamento</option><option value='Terminado'>Terminado</option><option value='Aguardando Documentos'>Aguardando Documentos</option><option value='Cancelado'>Cancelado</option><option value='Aditivo'>Aditivo</option></select><br><br><center><input style='float:none; margin: 10px 0px -10px -30px' class='submit' type='submit' value='OK'></center><br>";
			var novoConv="<div id='newAgreement'><img onclick='fechar(2)' id='close' alt='Fechar' width='32px' src='close.png'>"+conteudo+"</div></div>";
			$(".agreement").append(novoConv);
			window.scrollTo(0, window.outerHeight);
			$("#linkIni").removeAttr("href").css("cursor","pointer");
		}	
		else{
			if($("#updateData").length) fechar(2);
			else fechar(1);
			newAgreement();
		}
	}
	function updateData(id_estagio, empresa){
		if (!$("#newAgreement").length){
			var elem = document.getElementById("nomeEmp");
			elem.value = empresa;
			elem = document.getElementById("idEst");
			elem.value = id_estagio;
			$(".updateData").css({"visibility":"visible" , "display" : "block"});
			$("#updateData").attr("id" , "newAgreement");
			$("#linkIni").removeAttr("href").css("cursor","pointer");
			window.scrollTo(0, window.outerHeight);
		}
		else{
			if($("#updateData").length) fechar(2);
			else fechar(1);
			updateData(id_estagio, empresa);
		}
	}
	</script>

<html>
<head>
<title>Pesquisa de Alunos</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<meta charset="utf-8">
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		
</head>

<body>
	<center>
		<div class="main">
			<a id="linkIni" href="index.php">
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
					Pesquisa de Alunos
				</span>
				<p><p><p>
				<div id="eu">
					<form class="form-wrapper" action="student_search_new.php" method="get" style="width:380px">
						<label for="search" style="padding-left: 10px">CPF ou Nome</label>
						<input type="text" name="student" id="search" style="text-align: center" placeholder="CPF ou Nome" pattern="(^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$)|(^[\D\s]{3,300}$)" required autofocus><br>
						<input type="submit" value="buscar" style="float: center; width:80px" class="submit"> <br> <br>
					</form>
				</div>
				<a href='javascript:window.history.go(-1)'>Voltar <--- </a>	<br>
			</div>
				
	
			<!-- Inicio php -->
			<?php
			
			if((!$aluno)&&(!$id)){ // Se não tiver nenhuma pesquisa
				die();
			}

			$sql = '';
			if(strstr($aluno,".") && strstr($aluno,"-")){
				$sql = "select id,Nome as nome,curso as curso, Matricula as 'matricula',Unidade as unidade,CPF as cpf, telefone as telefone, endereco as endereco, email as email, data_nasc as nascimento  from aluno where cpf = '$aluno' ORDER BY nome";
			}elseif(is_numeric($aluno)){
				$temp = 
				substr($aluno, 0, 3) . "." .
				substr($aluno, 3, 3). "." . 
				substr($aluno, 6, 3). "-" . 
				substr($aluno, 9, 3); 
				$sql = "select id,Nome as nome,curso as curso, Matricula as 'matricula',Unidade as unidade,CPF as cpf, telefone as telefone, endereco as endereco, email as email, data_nasc as nascimento  from aluno where cpf = '$temp' ORDER BY nome";
				echo $temp;
			}else{
				$sql = "select id,Nome as nome,curso as curso, Matricula as 'matricula',Unidade as unidade,CPF as cpf, telefone as telefone, endereco as endereco, email as email, data_nasc as nascimento from aluno where nome like '%$aluno%' ORDER BY nome";
			}

			$conexao = mysql_connect("localhost", "root", "");

			if(!$conexao) die ("Falha ao conectar ao banco");
				$bd = mysql_select_db("diemp");
			
			$var = mysql_query($sql) or die(mysql_error());
			$line = mysql_fetch_assoc($var);

			while($line){
			$c_nome = $line["nome"];
			$c_cpf = $line["cpf"];
			$c_matricula = $line["matricula"];
			$c_curso = $line["curso"];
			$c_unidade = $line["unidade"];
			$c_telefone = $line["telefone"];
			$c_endereco = $line["endereco"];
			$c_email = $line["email"];
			$c_data_nasc = $line["nascimento"];
				
				$line = mysql_fetch_assoc($var);
			
					 echo("<form method='GET' action='stdEdit.php'>
						 <div class='stdSearchResult'>
							
							<br>
							<div class='descricao'>
								<div>

								</div>
								<div>
									<div class='what'>Nome:</div>
									<input name='std' class='info' type='text' value='$c_nome' readonly>
								</div>
								
								<div class='infoline'>
									<div class='what'>CPF:</div>
									<input class='info' type='text' value='$c_cpf' readonly>
								</div>
								
								<div class='infoline'>
									<div class='what'>Matricula:</div>
									<input name='mat' class='info' type='text' value='$c_matricula'readonly>
								</div>
								
								<div class='infoline'>
									<div name='curso' class='what'>Curso:</div>
									<input class='info' type='text' value='$c_curso' readonly>
								</div>
								
								<div class='infoline'>
									<div name='unit' class='what'>Unidade:</div>
									<input class='info' type='text' value='$c_unidade' readonly>
								</div>
								
								<div class='infoline'> 
									<div name='unit' class='what'>Telefone: </div>
									<input class='info' type='text' value='$c_telefone' readonly> 
								</div>
								
								<div class='infoline'>
									<div name='unit' class='what'>Endereço: </div>
									<input class='info' type='text' value='$c_endereco' readonly>
								</div>
								
								<div class='infoline'>
									<div name='unit' class='what'> E-mail: </div>
									<input class='info' type='text' value='$c_email' readonly>
								</div>
								
								<div class='infoline'>
									<div name='unit' class='what'> Nascimento: </div>
									<input class='info' type='text' value='$c_data_nasc' readonly> 
							</div></div>
						</div></form>	
					<br>");}
			?>
			<!-- Fim php -->
		</div>
	</center>
</body>

</html>