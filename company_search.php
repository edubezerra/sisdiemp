<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	
	include_once("useful_functions.php");
	include_once("dbfunctions.php");
	include("conection.php");
	
	$compania = $_REQUEST["company"];
	$id = $_REQUEST["id"];
	$pag = $_REQUEST["pag"];
	if(!isset($pag))
		$pag = 1;
	if(isset($id)){
		$sql = "select nome, numero, cnpj from empresa where id like $id";
		$res = mysql_query($sql);
		$line = mysql_fetch_assoc($res);
		$c_nome = $line['nome'];
		$c_cnpj = $line['cnpj'];
		$c_numero = $line['numero'];
	}
	

?>

<html>

<head>
<meta charset="UTF-8">
<title>Pesquisa de Empresas</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />


<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
	
<script type="text/javascript">
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
	function newAgreement(){
		if (!$("#newAgreement").length){
			var conteudo="<div id='addNew'><h3><center>Novo Convênio<center></h3>Data de Início <input name='inicio' class='inputAtt' style='margin-right:25px; float: right' type='date'><br><br>Anos de Duração <input name='fim' type='number' style='margin-right:25px; float: right; width:145px' class='inputAtt'><br><br><font size='2'>Número do Convênio<input name='numero_conv' type='number' style='margin-right:25px; float: right; width:140px' class='inputAtt'><br><br><center><input style=' margin:10px 0 -10px -30px; float:none'class='submit' type='submit' value='OK'><br><br></center>";
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
	function updateData(){
		if (!$("#newAgreement").length){
			$(".updateData").css({"visibility":"visible" , "display" : "block"});
			$("#updateData").attr("id" , "newAgreement");
			$("#linkIni").removeAttr("href").css("cursor","pointer");
			window.scrollTo(0, window.outerHeight);
		}
		else{
			if($("#updateData").length) fechar(2);
			else fechar(1);
			updateData();
		}
	}
	
</script>

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
			Pesquisa de Empresas
		</span>
		<p><p><p>
		<div id="eu">
			<form class="form-wrapper" action="company_search.php" >
				<input type="text" name="company" id="search" autofocus="autofocus" style="text-align: center" placeholder="CNPJ ou Razão Social" pattern="(^[0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2}$)|(^[\D\s]{3,500}$)" required>
				<input type="submit" value="go" class="submit">
			</form>
		</div>
	</div>

	<!-- Inicio php -->
	<?php
		if((!isset($compania)) && (!isset($id))){
			die();
		}
		if(isset($id)){
				$sql="select id, nome as Nome, numero as Numero, cnpj as CNPJ from empresa where id = $id";
				$res = mysql_query($sql);
				$num_rows = mysql_num_rows($res);
		}
		else{
			$nome = $compania;
			$tmp = false;  // $tmp == Consulta ao banco com apenas uma linha de resposta;

			if(preg_match('/^[0-9+\/.-]{18}$/i', $nome)){
				$c_cnpj = $nome;
				$nome = 5;
				
				$sql="select id, nome as Nome, numero as Numero from empresa where cnpj= '$c_cnpj'";
				$res = mysql_query($sql);
				$num_rows = mysql_num_rows($res);
				if($num_rows <= 0){
					echo("Não há nenhuma empresa com CNPJ = \"$compania\".");
					die();
				}		
				$line = mysql_fetch_assoc($res);
				$id = $line['id'];
				$c_nome = $line['Nome'];
				$c_numero = $line['Numero'];
			}
			else{
				$limite = 20;
				$inicio = (($pag* $limite)- $limite);
				$sql = "select id, nome as Nome, numero as Numero, cnpj as CNPJ from empresa where Nome like '%$compania%' ORDER BY nome"; 
				$sql_pag= "$sql limit $inicio, $limite";
				$res = mysql_query($sql);
				$num_rows = mysql_num_rows($res);
			}
			if($nome == $compania){
				if($num_rows == 1){
					$tmp = true;
					$line = mysql_fetch_assoc($res);
					$c_cnpj = $line["CNPJ"];
					$c_numero = $line["Numero"];
					$id = $line["id"];
					$c_nome = $line["Nome"];
				//	mysql_close($c);
				//	include("conection.php");
				//	$resp=getTable($c,$sql,"Empresas",2);
				//	echo($resp);
				}
				else{
					$line = mysql_fetch_assoc($res);
					if(!$line)
						echo("Não há nenhuma empresa com \"$compania\" em parte da sua Razão Social.");
					else{
						mysql_close($c);
						include("conection.php");
						$resp=getTableCS($c,$sql_pag,"Empresas",2, $num_rows, $compania, $pag, $limite);
						echo($resp);
					}
				}
			}
		}
		//$nulo = '(null)';
		//	if(($c_cnpj == '')||($c_cnpj == $nulo)){
		//		$c_cnpj = "Não cadastrado";
		//	}
		if(($num_rows == 1) || (isset($id))){
			$sql="select conv.numero as 'Número', conv.data_inicio as 'Data Início', conv.data_fim as 'Data Fim',  conv.id as 'id'
				from empresa emp 
				inner join convenio conv 
				on emp.id = conv.id_empresa
				where emp.id='$id'
				order by conv.numero";	 
			echo("<div class='stdSearchResult'>
					<br>
					<div class='descricao'>
						<div>
							<div class='what'>Nome:</div>
							<input class='info' name='comp' type='text' value='$c_nome' readonly>
						</div>
						<div class='infoline'>
							<div class='what'>CNPJ:</div>
							<input class='info' name='code' type='text' placeholder='Não Cadastrado' value='$c_cnpj' readonly>
						</div>
						<div class='infoline'>
							<div class='what'> Número: </div>
							<input class='info' name='comp' type='text' placeholder='Número não cadastrado' value='$c_numero' readonly>
						</div>
							<input class='info' name='id' type='hidden' value='$id'>
						
					</div>
					
					<br>
				");
			$table=getTable3($c, $sql, "Convênios");
			echo($table);
				echo("
						<br>
						<hr width=90%>
						
						<table style='background: transparent; border-radius: 20px;'>
							<tr>
								<td><center>
									<div class='classname' onClick='updateData()' style='cursor: pointer;
										height: 45px; padding-top: 5px; font-size: 18px; width: 200px;'>
											Atualizar Dados</div></td>
										
								<td><center>
									<div class='classname' onClick='newAgreement()' style='cursor: pointer;
										height: 45px; padding-top: 5px; font-size: 18px; width: 200px;'>
											Novo Convênio</div></td>
							</tr>
						</table>
						
						<form method='post' action='compEdit.php'>
						<div class='updateData' id='newAgreement' style='visibility:hidden; display:none'>
							<img onclick='fechar(1)' id='close' alt='Fechar' width='32px' src='close.png'>
						<div id='addNew'><h3><center>Atualizar Dados</center></h3>
					<input type='hidden' value='$id' name='id'>
					Nome <input name='nome' class='inputAtt' value='$c_nome' style='margin-right:25px; float: right' type='text' required><br><br>
					CNPJ <input name='cnpj' class='inputAtt' value='$c_cnpj' type='text' style='margin-right:25px; float: right' ><br><br>
					Número <input name='numero' type='text' value='$c_numero' style='margin-right:25px; float: right' class='inputAtt' ><br><br>
					<center><input style='float:none; margin: 10px 0px -10px -30px' class='submit' type='submit' value='OK'></center><br>
					</div></div></form>");
					echo("<form class='agreement' method='get' action='newAgreement.php'>
					<input type='hidden' name='id' value='$id'></form>");
			
			echo("</div>");
			mysql_close($c);
		}	
	?>	
	<!-- Fim php -->
	</div>
</center>
</body>
</html>