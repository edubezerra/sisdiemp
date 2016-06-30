<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");
		
		$sql =  "SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'";
		$permission = mysqli_query($c,$sql) or die("erro ao selecionar");

		if (!$permission) {
		    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
		    exit;
		}

		if (mysqli_num_rows($permission) <= 0) {
			echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
		    exit;
		}

		$row = mysqli_fetch_assoc($permission);
		$isAdmin = $row["isAdmin"];

		if($isAdmin == 0){
			echo"<script language='javascript' type='text/javascript'>window.location.href='index_aluno.php';</script>";
		}
	}
?>
<html>
<head>
<title>Cadastro de Oferta</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="jquery.timepicker.css" />

<meta charset="UTF-8">

<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="jquery.timepicker.js"></script>
		
<script type="text/javascript">
	var offers = null;

	function receiveOffers(str) {
	    if (str.length != 0) 
			$.get("getoffers.php",{tec:str},function(data){offers = data.substring(97);});
	}

	function fillUnits(){
		$.post("search.php",{what:"units"},function(data){
			$("#Unidade").append(data);
		});
	}
	function fillCourses(chosenUnit){
		$.post("search.php",{what:"courses", unit:chosenUnit},function(data){
			$("#Curso").html("<option>Selecione o Curso...</option>");
			$("#Curso").append(data);
		});
	}


	//var numItems = $('.yourclass').length


	function mostrarOfertas () {
		receiveOffers($(".campo:nth-of-type(2)").val());
		window.setTimeout(function(){
			if(offers.search('Não há nenhuma empresa com técnico') == -1){
				//alert(offers);
				$(".stdIntro").append(offers + "<br/><br/>");
			}
		},1000);
		
	}

	function atualizarValor (obj) {
		//alert(obj.value);

		var today = new Date();

		var data1 = new Date($(".column_" + obj.value + "_4").val());//Publicação
		data1 = new Date (data1.getTime() + 25*60*60*1000 + 59*60*1000 + 59*1000);//Corrigindo problema de fuso

		var data2 = new Date($(".column_" + obj.value + "_3").val());//Vigência
		data2 = new Date (data2.getTime() + 25*60*60*1000 + 59*60*1000 + 59*1000);//Corrigindo problema de fuso

		if(data1 < today && today < data2){
    		alert("A oferta não pode mais ser editada, ela já foi publicada!");
    	}else if(today > data2){
    		alert("A oferta não pode mais ser editada, ela está inativa pois sua vigência acabou!");
    	}else{

			var salario=$(".column_" + obj.value + "_1").val();
			var beneficios=$(".column_" + obj.value + "_2").val();
			var dataVigencia=$(".column_" + obj.value + "_3").val();
			var dataPublicacao=$(".column_" + obj.value + "_4").val();
			var horarioInicio=$(".column_" + obj.value + "_5").val();
			var horarioFim=$(".column_" + obj.value + "_6").val();
			var local=$(".column_" + obj.value + "_7").val();
			var funcao=$(".column_" + obj.value + "_8").val();
			var tecnicos=$(".column_" + obj.value + "_9").val();
			var idConvenio=$(".column_" + obj.value + "_10").val();
			var email=$(".column_" + obj.value + "_11").val();

			

			var info={id: obj.value, email: email, tecnicos: tecnicos, funcao: funcao, salario: salario, dataVigencia: dataVigencia, dataPublicacao:dataPublicacao, horarioInicio: horarioInicio, horarioFim: horarioFim, beneficios: beneficios, local: local};
			//if(!idConvenio)
			//	alert("Cadastro não efetuado! \n É necessário inserir o id do convênio.");
			if(!email)//else if (!email)
				alert("Cadastro não efetuado! \n É necessário inserir o email da empresa.");
			else if(!tecnicos)
				alert("Cadastro não efetuado! \n É necessário inserir os cursos técnicos almejados pela empresa.");
			else if(!funcao)
				alert("Cadastro não efetuado! \n É necessário inserir a função que o estagiário efetuará.");
			else if(!salario)
				alert("Cadastro não efetuado! \n É necessário inserir o salário a ser pago.");
			else if(!dataVigencia)
				alert("Cadastro não efetuado! \n É necessário inserir a data de vigência.");
			else if(!dataPublicacao)
				alert("Cadastro não efetuado! \n É necessário inserir a data de publicação.");
			else if(!horarioInicio)
				alert("Cadastro não efetuado! \n É necessário inserir o horário de estágio.");
			else if(!horarioFim)
				alert("Cadastro não efetuado! \n É necessário inserir o horário de estágio.");
			else if(!beneficios)
				alert("Cadastro não efetuado! \n É necessário inserir os benefícios.");
			else if(!local)
				alert("Cadastro não efetuado! \n É necessário inserir o local de trabalho.");
			else
				$.post("offer_update.php",info,function(data){
					$(".box").append(data);
				});
		}

	}

	function deletarValor (obj) {
	//alert(obj.value);
		var info={id: obj.value};
		
		$.post("offer_delete.php",info,function(data){
			$(".box").append(data);
		});
	}

</script>
</head>

<body onload="fillUnits();">
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
		<div class="stdIntro" style="width:85%">
			<br/>
			<span id="welcome">
				Visualizar/Editar Ofertas
			</span>
			<h5>Selecione o curso que deseja usar de filtro para as ofertas</h5>
			<form class="form-wrapper" style="width:450px">
			<label for="Unidade"> Unidade </label>
			<select onchange="fillCourses(this.value)" class="campo" style="width: 450px; text-align: center" id="Unidade" required>
				<option>Selecione a Unidade...</option>
			</select><br>
			<label for="Curso">Curso </label>
			<select class="campo" style="width: 450px; text-align: center" id="Curso" required>
				<option>Selecione o Curso...</option>
			</select><br>
			<input onclick="mostrarOfertas();" value="Mostrar" style="width: 450px; font-size: 16px;" class="submit"><br><br>
		</form>
		<br>
		</div>
		<a href='javascript:window.history.go(-1)'><---Voltar  </a>	<br>
	</div>	


</center>
</body>
</html>