<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");

		$permission = mysqli_query($c, "SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");

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

		

		if($isAdmin == 1){
			echo"<script language='javascript' type='text/javascript'>window.location.href='index.php';</script>";
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
	var curso = null;

	function cursoPorMatricula(str) {
	    $.get("getcourse.php",{tec:str},function(data){curso = data.substring(97);});
	}

	function receiveOffers(str) {
	    $.get("getoffers.php",{tec:str},function(data){offers = data.substring(97);});
	}


	//var numItems = $('.yourclass').length
	function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
	}

	function mostrarOfertas() {
		cursoPorMatricula(readCookie("login"));
		window.setTimeout(function(){
			if(curso!=null){
				receiveOffers(curso);
				window.setTimeout(function(){
					if(offers.search('Não há nenhuma empresa com técnico') == -1){
						//alert(offers);
						$(".stdIntro").append(offers + "<br/><br/>");
					}
				},1000);
				
			}
		},1000);


		//receiveOffers(readCookie("login"));
		/*window.setTimeout(function(){
			if(offers.search('Não há nenhuma empresa com técnico') == -1){
				//alert(offers);
				$(".stdIntro").append(offers + "<br/><br/>");
			}
		},1000);*/
		
	}


</script>
</head>

<body onload="mostrarOfertas();">
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
			<br/><br/><br/><br/><br/>
		</div>
	</div>	


</center>
</body>
</html>