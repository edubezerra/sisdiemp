<html><head><meta charset="utf-8"></head><?php
    $resp="";
	if($_REQUEST["what"]=="units"){
	
		include "dbfunctions.php";
		include "conection.php";
	
		$sql="select distinct unidade from aluno where unidade <> ''";
		$resp=getOptions($c,$sql,"unidade");
		if($resp==false) $resp="Unidades não encontradas";
		
		mysql_close($c);
	}
	else if($_REQUEST["what"]=="courses" && $_REQUEST["unit"]){
	
		$unit=$_REQUEST["unit"];
		
		include "dbfunctions.php";
		
		include "conection.php";
		
		$sql="select distinct curso from aluno where(unidade like '$unit')";
		$resp=getOptions($c,$sql,"curso");
		if($resp==false) $resp="<option>Cursos não encontrados</option>";
		
		mysql_close($c);
	}
	else if($_REQUEST["what"]=="intern" && $_REQUEST["unit"]!="Selecione a Unidade..." && $_REQUEST["course"]!="Selecione o Curso..."){
	
		$unit=$_REQUEST["unit"];
		$course=$_REQUEST["course"];		
		
		include "dbfunctions.php";
		include "conection.php";
		
		$sql="select distinct a.id, a.nome as Nome, a.matricula as Matricula, a.curso as Curso, a.unidade as Unidade, a.cpf as CPF
			  from aluno a inner join estagio e on(a.id=e.id_aluno)
			  where(a.unidade like '$unit' and a.curso like '$course')
			  order by a.nome";
		
		$resp=getTable($c,$sql,"Estagiários",1);
		if($resp==false) $resp="<b>Estagiários não encontrados</b>";
				
		mysql_close($c);
	}
	else if($_REQUEST["what"]=="company" && $_REQUEST["descricao"]){
	    $info=$_REQUEST["descricao"];
		
		$resp="<div class='stdSearchResult'>
			<br>
			<div class='descricao'>
				<div>
					<div class='what'>Nome:</div>
					<input name='comp' class='info' value='$info' title='$info' type='text' readonly>
				</div>
				
				<div class='infoline'>
					<div class='what'>CNPJ:</div>
					<input name='cnpj' class='info' value='$info' type='text' readonly>
				</div>
			</div>
			
			<br>
			<div class='CSSTableGenerator' >
			<table>
			<tr>
				<td colspan='2'><center>Convênios</td>
			</tr>
			
			<tr>
				<td style='background-color: #193a73'><center><big><big><b><font color='white'>Data Inicio</td>
				<td style='background-color: #193a73'><center><big><big><b><font color='white'>Data Término</td>
			</tr>
			<tr>
				<td><center><big>10/10/1990</td>
				<td><center><big>10/10/1994</td>
			</tr>
			<tr>
				<td><center><big>15/12/1996</td>
				<td><center><big>15/12/2000</td>
			</tr>
			<tr>
				<td colspan='2'><center><button onclick='newAgreement()' class='button'>+ Novo Convênio</button></td>
			</tr>
			</table>
					
			</div>
							
		</div><br>";
		
	}
	echo $resp;
?></html>
