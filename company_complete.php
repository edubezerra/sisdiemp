


<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	include_once("useful_functions.php");
	include_once("dbfunctions.php");
	include("conection.php");
?>

<html>

<head>
<meta charset="UTF-8">
<title>Pesquisa de Empresas</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />


<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		
<script type="text/javascript">
	function fechar(){
		$("#newAgreement").remove();
	}
	function newAgreement(){
		if (!$("#newAgreement").length){
		  var conteudo="<h3>Novo Convênio</h3>Data de Início <input name='inicio' class='inicio' type='date'><br><br>Anos de Duração <input name='fim' type='number' class='fim'><br><input type='submit' value='OK' id='newConvButton'>";
		  var novoConv="<div id='newAgreement'><img onclick='fechar()' id='close' alt='Fechar' width='32px' src='close.png'>"+conteudo+"</div>";
		  $(".agreement").append(novoConv);
		  window.scrollTo(0, window.outerHeight);
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
		<div class="stdIntro2">
		<span id="welcome">
			Completar Cadastro de Empresas
		</span>
		<p><p><p>
	</div>

		<!-- Inicio php -->
		<?php
			$sql="select nome as Nome, cnpj as CNPJ, Numero as Número, id as id from empresa where Numero = 0 or Numero is NULL or CNPJ is NULL or CNPJ = 0 order by nome limit 50";	 			 
			$table=getTable32($c, $sql, "Empresas");
			echo($table);
				 echo("</form>
						<br>
						<hr width=90%>
					</div>");			
			mysql_close($c);
		?>
		<!-- Fim php -->
	</div>
</center>
</body>
</html>