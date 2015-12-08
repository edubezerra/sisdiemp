<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	include_once("useful_functions.php");
	include_once("dbfunctions.php");
	include("conection.php");

	$ano = $_REQUEST["ano"];
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
			var conteudo="<div id='addNew'><h3><center>Novo EstÃ¡gio</center></h3> CNPJ <input style='width:180px; margin-right:24px; float:right' name='cnpj' type='text' class='inputAtt'required><br><br>Data de Início <input name='inicio' class='inputAtt' style='margin-right:25px; float: right;' type='date' required><br><br>Data de Fim<input name='fim' type='date' style='margin-right:25px; float: right;' class='inputAtt' required><br><br> Estado <select name='estado' style='margin-right:25px; float: right' class='fim' required><option value='Em andamento'>Em andamento</option><option value='Terminado'>Terminado</option><option value='Aguardando Documentos'>Aguardando Documentos</option><option value='Cancelado'>Cancelado</option></select><br><br><center><input style='float:none; margin: 10px 0px -10px -30px' class='submit' type='submit' value='OK'></center><br>";
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
					Pesquisa de estagiÃ¡rios por ano
				</span>
				<p><p><p>
				<div id="eu">
					<form class="form-wrapper" action="pesquisar_ano.php" method="get" style="width:380px">
						<label for="search"> Ano de inÃ­cio de estÃ¡gio</label>
						<input type="number" name="ano" id="search" style="text-align: center" placeholder="Ano de inÃ­cio de estÃ¡gio" required autofocus>
						<input type="submit" value="buscar" style="width:80px" class="submit">
					</form>
				</div>
			</div>
			<!-- Inicio php -->
			<?php
			if(!$ano){ // Se nÃ£o tiver nenhuma pesquisa
				die();
			}
			if($ano <1000 || $ano >  date('Y'))	// se data menor que 1000 ou maior que esse ano
				die();
										
			$sql = "select id_aluno from estagio where Data_Inicio_Vigencia between '$ano-01-01' and '$ano-12-31' ";
			$table = getTableAno($ano, $sql, "Alunos");
			echo($table);

			mysql_close($c);	
			?>
			<!-- Fim php -->
		</div> 
	</center>
</body>

</html>
