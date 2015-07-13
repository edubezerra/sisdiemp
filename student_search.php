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
			var conteudo="<div id='addNew'><h3><center>Novo Estágio</center></h3> CNPJ <input style='width:180px; margin-right:24px; float:right' name='cnpj' type='text' class='inputAtt'required><br><br>Data de Início <input name='inicio' class='inputAtt' style='margin-right:25px; float: right;' type='date' required><br><br>Data de Fim<input name='fim' type='date' style='margin-right:25px; float: right;' class='inputAtt' required><br><br> Estado <select name='estado' style='margin-right:25px; float: right' class='fim' required><option value='Em andamento'>Em andamento</option><option value='Terminado'>Terminado</option><option value='Aguardando Documentos'>Aguardando Documentos</option><option value='Cancelado'>Cancelado</option></select><br><br><center><input style='float:none; margin: 10px 0px -10px -30px' class='submit' type='submit' value='OK'></center><br>";
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
					<form class="form-wrapper" action="student_search.php" method="get" style="width:380px">
						<input type="text" name="student" id="search" style="text-align: center" placeholder="CPF ou Nome" pattern="(^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$)|(^[\D\s]{3,300}$)" required autofocus>
						<input type="submit" value="buscar" style="width:80px" class="submit">
					</form>
				</div>
			</div>
			<!-- Inicio php -->
			<?php
			
			if((!$aluno)&&(!$id)){ // Se não tiver nenhuma pesquisa
				die();
			}
			
			$nome = $aluno;
			$tmp = false;
			
			if(preg_match('/^[0-9]{11}$/', $cpf)){
				$nome = 5;
				if((preg_match('/^[0-9]{11}$/', $cpf))){
					$variavel = '';
					$variavel .= $cpf[0];
					$variavel .= $cpf[1];
					$variavel .= $cpf[2];
					$variavel .= '.';
					$variavel .= $cpf[3];
					$variavel .= $cpf[4];
					$variavel .= $cpf[5];
					$variavel .= '.';
					$variavel .= $cpf[6];
					$variavel .= $cpf[7];
					$variavel .= $cpf[8];
					$variavel .= '-';
					$variavel .= $cpf[9];
					$variavel .= $cpf[10];
					
					$sql2 = "SELECT id from aluno WHERE cpf = '$variavel'";
					$res2 = mysql_query($sql2);
					$line2 = mysql_fetch_assoc($res2);
					
					$id = $line2["id"];
				}
			}

			if($nome == $aluno || isset($id) ){	
				if(isset($id)){
					$sql = "select id,Nome,Matricula as 'Matrícula',Unidade,CPF from aluno where id = '$id' ORDER BY nome";
				}
				else{
					$sql = "select id,Nome,Matricula as 'Matrícula',Unidade,CPF from aluno where nome like '%$aluno%' ORDER BY nome";
				}
				$res = mysql_query($sql);
			
				$num_rows = mysql_num_rows($res);
				
				if($num_rows == 1){
					$tmp = true;
					$line = mysql_fetch_assoc($res);
					$cpf = $line["cpf"];
					$id = $line["id"];
					$permit = $id;
				}
				else{
					echo("<div class='stdSearchResult' style='width: 900px'><br>");
					$resp=getTable($c,$sql,"Alunos",1);
					if(!$resp){
						echo("Não há nenhum(a) aluno(a) com \"$aluno\" em parte de seu nome.");
					}
					else{
						echo($resp);
					}
					echo("</div>");
				}
							
			}
			if(($nome != $aluno)||($tmp == true)||(($cpf == '')&&(isset($id)))){
				if((($cpf == '')&&(isset($id)))){
					$sql="select nome, cpf, matricula, curso, unidade from aluno where id = $id";
				}
				else{
					if($num_rows != 1){
						$temp[0] = $cpf[0];
						$temp[1] = $cpf[1];
						$temp[2] = $cpf[2];
						$temp[3] = '.';
						$temp[4] = $cpf[3];
						$temp[5] = $cpf[4];
						$temp[6] = $cpf[5];
						$temp[7] = '.';
						$temp[8] = $cpf[6];
						$temp[9] = $cpf[7];
						$temp[10] = $cpf[8];
						$temp[11] = '-';
						$temp[12] = $cpf[9];
						$temp[13] = $cpf[10];
						
						$my_string = $temp;
						foreach ($my_string as $stringArray)
						{
							$stringArrayF = $stringArrayF.$stringArray;
						}
						$cpf = $stringArrayF;
					}
					$sql="select id, nome, cpf, matricula, curso, unidade from aluno where id = '$id'";
				}
				$res = mysql_query($sql);
				$line = mysql_fetch_assoc($res);
				
				while($line){
					$c_nome = $line["nome"];
					$c_cpf = $line["cpf"];
					$c_matricula = $line["matricula"];
					$c_curso = $line["curso"];
					$c_unidade = $line["unidade"];
					
					$line = mysql_fetch_assoc($res);
				}
				$nulo = '(null)';
				if(($c_cpf == '')||($c_cpf == $nulo)){
					$c_cpf = "Não cadastrado";
				 }
				 
				 echo("<form method='GET' action='stdEdit.php'>
					 <div class='stdSearchResult'>
						<br>
						<div class='descricao'>
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
						</div>
					</div></form>	
				<br>");
			}
			
			$sql="select emp.nome as 'Nome', est.data_inicio_vigencia as 'Data Inicio', est.data_fim_vigencia as 'Data Fim', 
					est.data_rescisao as 'Data Rescisão', emp.id as 'emp_id', est.Estado as 'Estado',
					conv.id as 'conv_id', est.id as 'est_id'
				from empresa emp
					inner join convenio conv on emp.id = conv.id_empresa
					inner join estagio est on conv.id = est.id_convenio
					inner join aluno alu on est.id_aluno = alu.id 
				where alu.id='$id'
				order by est.data_inicio_vigencia, emp.nome";
		
			$table=getTable4($c, $sql, "Estágios");
			echo($table);
			
			if((isset($_REQUEST["id"]))||(isset($permit))||(preg_match('/(^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$)/',$aluno))){

				if($count>0){
					$nome[$count];
					for($i=0;$i<$count;$i++){
						$line = mysql_fetch_assoc($res);
						$nome[$i] = $line['Nome'];
						$idEst[$i] = $line['est_id'];
					}
				}
						echo("
						<br>
						<hr width=90%>
						
						<table style='background: transparent; border-radius: 20px;'>
							<tr>
								<td><center>
									<div class='classname' onClick='newAgreement();' style='cursor: pointer;
										height: 45px; padding-top: 5px; font-size: 18px; width: 200px;'>
											Novo Estágio</div>
								</div></td>
							</tr>
						</table>
						
						<form method='get' action='estagio_update.php' ><input type='hidden' name='id_aluno' value='$id'>
							<div class='updateData' id='updateData' style='visibility:hidden; display:none'>
							<img onclick='fechar(1)' id='close' alt='Fechar' width='32px' src='close.png'>
							<div id='addNew'><h3><center>Atualizar Dados</center></h3>
								
								<input type='hidden' id='idEst' name='id_estagio' value='$idEst[$i]'>
								<big><input type='text' id='nomeEmp' name='nome_empresa' value='nomeEmp' style='border:none' readonly></big><br><br>
								Data de Início <input name='inicio' class='inputAtt' style='margin-right:25px; float: right;' type='date' required><br><br>
								Data de Fim <input name='fim' type='date' style='margin-right:25px; float: right' class='inputAtt' required><br><br>
								<font size='2'>Data de Rescisão</font> <input name='rescisao' type='date' 
								style='width:150px; margin-right:25px; float: right;' class='inputAtt'><br><br>
								Estado <select name='estado' style='margin-right:25px; float: right' class='fim' required>
										<option value='Em andamento'>Em andamento</option>
										<option value='Termo de Compromisso'>Terminado</option>
										<option value='Aguardando Documentos'>Aguardando Documentos</option>
										<option value='Cancelado'>Cancelado</option>
										<option value='Aditivo'>Aditivo</option></select><br><br>
								<center><input style='float:none; margin: 10px 0px -10px -30px' class='submit' type='submit' value='OK'></center>
							<br></form></div></div>");
			}
					echo("<form class='agreement' method='POST' action='newAgreement2.php'><input type='hidden' name='id' value='$id'>");
					echo("</form>");

			mysql_close($c);	
			?>
			<!-- Fim php -->
		</div> 
	</center>
</body>

</html>