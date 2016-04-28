<html><head><meta charset="utf-8"></head>
<?php
include("conection.php");

function querySql($c,$query,$type){
	$resp = mysqli_query($c, $query); // Consulta SQL
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	else{ // Caso consulta seja bem sucedida:
		$resposta;
		if($type=="find"){
			$line=mysqli_fetch_assoc($resp);
			
			if($line) $resposta=true; // Existe
			else $resposta=false; // Não existe
		}
		else if($type=="create" || $type=="delete" || $type=="update"){
			$resposta=true; // INSERT ou DELETE realizado com sucesso
			if(($type=="delete" || $type=="update") && mysqli_affected_rows()==0) $resposta=false;
			// Caso tenha sido realizado um delete ou update de uma tupla que não existe o mysql_affected_rows() retornará zero
		}
		else if($type=="getline"){
			$line=mysqli_fetch_assoc($resp);
			$resposta=$line;
		}
	}
	return $resposta;
}

// AS FUNÇÕES com início "getTable" servem para retornar tabelas formatadas e padronizadas com linhas do banco de dados.
// As funções getTable 2,3,32 e 4 são variações da getTable inicial, com pequenos ajustes que se adaptam para consultas diferentes.

function getTable($c,$query,$name,$type){
	$resp = mysqli_query($c, $query);// Consulta SQL
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		
		$keys=array_keys($line);          // Pega um array com o nome(key) das colunas que referenciam os campos da tupla pegada em $line
		$length=count($keys);             // Pega o número de elementos do array $keys
		
		$resposta="<div class='CSSTableGenerator' style='width: 95%'>
		<table>
		<tr>
			<td colspan='".$length."'><center>$name</td>
		</tr>";
		
		$resposta.="<tr>";
		for($i=1;$i<$length;$i++){
			$colName=$keys[$i];
			if($colName == "CPF") $resposta.="<td style='width:115px;background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
			else $resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
			
		}
		$resposta.="</tr>";
		
		while($line){ // Põe linhas da tabela						
			// Neste for() eu ponho os campos de cada coluna, porém, para acessar os valores dentro
			// do array $line eu preciso do nome(key) que o referencia ($line[key]),
			// e não de um número. Este nome é o nome da coluna em que ele está, na qual obtenho do array $keys.
			
			$id = $line['id'];
			$resposta.="<tr>";
			for($i=1;$i<$length;$i++){ // Põe nomes das colunas da tabela
				$informacao=$line[ $keys[$i] ];
				if($type==0) $resposta.="<td class='campo'><center>{$informacao}</td>";
				else if($type==1 && $i==1) $resposta.="<td class='campo'><a href='student_search.php?id=$id'>{$informacao}</a></td>";
				else if($type==2 && $i==1) $resposta.="<td><center><a href='company_search.php?id=$id'>{$informacao}</a></td>";
				else $resposta.="<td><center><div class='fonte'>{$informacao}</div></td>";
				
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}


function getOfferTable32($c,$query){
	$resp = mysqli_query($c, $query);
	
	if(!$resp){
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$keys=array_keys($line);          
		$length=count($keys);             
		$length2 = $length + 1;
		$resposta="<div class='CSSTableGenerator' style='width: 95%' >
		
		<table>
		<tr>
			<td colspan='".$length2."'><center>Ofertas de Estágio</td>
		</tr>";

		$resposta.="<tr>";

/*
for($i=0;$i<$length;$i++){
			$colName=$keys[$i];
			$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
		}
*/

		//$resposta.="<td style='background-color: #193a73;width:2%'><center><big><big><b><font color='white'>ID</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Salário</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Benefícios</td>";
		$resposta.="<td style='background-color: #193a73;width:7%'><center><big><big><b><font color='white'>Data de Vigência</td>";
		$resposta.="<td style='background-color: #193a73;width:7%'><center><big><big><b><font color='white'>Data de Publicação</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Horário de Início</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Horário de Fim</td>";
		$resposta.="<td style='background-color: #193a73;width:20%'><center><big><big><b><font color='white'>Local</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Função</td>";
		$resposta.="<td style='background-color: #193a73;'><center><big><big><b><font color='white'>Técnico(s) Desejado(s)</td>";
		//$resposta.="<td style='background-color: #193a73;width:2%'><center><big><big><b><font color='white'>ID do Convênio</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Email da Empresa</td>";

		$resposta.="<td style='background-color: #193a73; width: 50px'><center><big><big><b><font color='white'>Excluir</td>";
		$resposta.="<td style='background-color: #193a73; width: 50px'><center><big><big><b><font color='white'>Atualizar</td>";
		$resposta.="</tr>";

		while($line){				
			$resposta.="<tr>";//<form method='GET' action='company_update.php'>";
			
			for($i=1;$i<$length+1;$i++){
				$informacao=$line[ $keys[$i] ];			
				if($i == 12){
					$resposta.="<input type='hidden' name='tablefield[]' value='{$informacao}'>";
					$resposta.="<td><center><input type='submit' onClick='deletarValor(this);' value='{$line[$keys[0] ]}' class='confirmar' id='botaoDeletar'></td>";
					$resposta.="<td><center><input type='submit' onClick='atualizarValor(this);' value='{$line[$keys[0] ]}' class='confirmar' id='botaoConfirmar'></td>";
					$resposta.="</form>";
				}
				else{
					if($i == 3){
						$resposta.="<td width='150 px'><center><input type='text' class='column_{$line[$keys[0] ]}_{$i}' style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}'></td>";//$resposta.="<td width='550px'><input class='getId' style='text-align:left; background:inherit; border:none' size='80px' size='60px' style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}' disabled></td>";
					}else if($i == 9){
						$resposta.="<td width='150 px'><center><textarea class='column_{$line[$keys[0] ]}_{$i}' style='background: transparent;resize: none; border: none; height:70px;' disabled>{$informacao}</textarea></td>";
					}else if($i != 10){
						$resposta.="<td width='150 px'><center><input type='text' class='column_{$line[$keys[0] ]}_{$i}' style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}' disabled></td>";
					}
				}
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}


function getOfferTable($c,$query,$type){
	$resp = mysqli_query($c, $query);// Consulta SQL
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		
		$keys=array_keys($line);          // Pega um array com o nome(key) das colunas que referenciam os campos da tupla pegada em $line
		$length=count($keys);             // Pega o número de elementos do array $keys
		
		$resposta="<div class='CSSTableGenerator' style='width: 95%'>
		<table>
		<tr>
			<td colspan='".$length."'><center>Ofertas de Estágio</td>
		</tr>";
		
		$resposta.="<tr>";

		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Salário</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Benefícios</td>";
		$resposta.="<td style='background-color: #193a73;width:7%'><center><big><big><b><font color='white'>Data de Vigência</td>";
		$resposta.="<td style='background-color: #193a73;width:7%'><center><big><big><b><font color='white'>Data de Publicação</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Horário de Início</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Horário de Fim</td>";
		$resposta.="<td style='background-color: #193a73;width:20%'><center><big><big><b><font color='white'>Local</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Função</td>";
		$resposta.="<td style='background-color: #193a73;'><center><big><big><b><font color='white'>Técnico(s) Desejado(s)</td>";
		//$resposta.="<td style='background-color: #193a73;width:2%'><center><big><big><b><font color='white'>ID do Convênio</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Email da Empresa</td>";

		$resposta.="</tr>";
		
		while($line){ // Põe linhas da tabela						
			// Neste for() eu ponho os campos de cada coluna, porém, para acessar os valores dentro
			// do array $line eu preciso do nome(key) que o referencia ($line[key]),
			// e não de um número. Este nome é o nome da coluna em que ele está, na qual obtenho do array $keys.
			
			$id = $line['id'];
			$resposta.="<tr>";
			for($i=1;$i<$length;$i++){ // Põe nomes das colunas da tabela
				$informacao=$line[ $keys[$i] ];
				if($i != 10 && $i != 9){
					$resposta.="<td class='campo'><center>{$informacao}</td>";
				}else if($i == 9){
					$resposta.="<td width='150 px'><center><textarea style='background: transparent;resize: none; border: none; height:70px;' disabled>{$informacao}</textarea></td>";
				}
				
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}


function getTableCS($c,$query,$name,$type, $num_rows, $compania, $pag, $limite){
	$resp = mysqli_query($c, $query);// Consulta SQL
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	
	$tot_pag = Ceil($num_rows/ $limite); // Ceil arredonda o resultado para cima
	$inicio = ($pag * $limite) - $limite;
		
		$line=mysqli_fetch_assoc($resp);
		if(!$line){
			$resposta=false;
		}
		else{
			
			$keys=array_keys($line);          // Pega um array com o nome(key) das colunas que referenciam os campos da tupla pegada em $line
			$length=count($keys);             // Pega o número de elementos do array $keys
			
			$resposta="<div class='CSSTableGenerator' style='width: 95%'>
			<table>
			<tr>
				<td colspan='".$length."'><center>$name</td>
			</tr>";
			
			$resposta.="<tr>";
			for($i=1;$i<$length;$i++){
				$colName=$keys[$i];
				$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
			}
			$resposta.="</tr>";
			
			while($line){ // Põe linhas da tabela						
				// Neste for() eu ponho os campos de cada coluna, porém, para acessar os valores dentro
				// do array $line eu preciso do nome(key) que o referencia ($line[key]),
				// e não de um número. Este nome é o nome da coluna em que ele está, na qual obtenho do array $keys.
				
				$id = $line['id'];
				$resposta.="<tr>";
				for($i=1;$i<$length;$i++){ // Põe nomes das colunas da tabela
					$informacao=$line[ $keys[$i] ];
					if($type==0) $resposta.="<td><center><big><big><font>{$informacao}</td>";
					else if($type==1 && $i==1) $resposta.="<td><a href='student_search.php?id=$id'><div class='fonte'>{$informacao}</div></a></td>";
					else if($type==2 && $i==1) $resposta.="<td><a href='company_search.php?id=$id'><div class='fonte'>{$informacao}</div></a></td>";
					else{ $resposta.="<td><center><div class='fonte'>{$informacao}</div></td>";
					}
				}
				$resposta.="</tr>";
				$line = mysqli_fetch_assoc($resp);
			}
			$resposta.="</table>";
			$resposta.="</div><div class='paginacao'>";
			for( $i = 1; $i<=$tot_pag; $i++){
				
				if($pag == $i)
					$resposta.= "| $i |"; // Escreve somente o número da página sem ação alguma
				else
					$resposta.="<a href='company_search.php?company=$compania&pag=$i'>  | $i |  </a>";
			}
						$resposta.="</div>";
		}	
		
	return $resposta;
}

function getTable2($c,$query,$name){
	$resp = mysqli_query($c, $query);
	
	if(!$resp){ 
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$keys=array_keys($line);         
		$length=count($keys);             
		
		$resposta="<div class='CSSTableGenerator' style='width: 95%' >
		<table>
		<tr>
			<td colspan='".$length."'><center>$name</td>
		</tr>";
		
		$resposta.="<tr>";
		for($i=0;$i<$length;$i++){
			$colName=$keys[$i];
			$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
		}
		$resposta.="</tr>";
		while($line){		
			$resposta.="<tr>";
			for($i=0;$i<$length;$i++){
				$informacao=$line[ $keys[$i] ];							
				$resposta.="<td><center><big><input style='background: transparent; border: 1px solid #ccc;' name='tablefield[]' value='{$informacao}'></td>";
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}

function getTable3($c,$query,$name){
	$resp = mysqli_query($c, $query);
	
	if(!$resp){
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$keys=array_keys($line);          
		$length=count($keys);             
		
		$resposta="<div class='CSSTableGenerator' style='width: 95%' >
		
		<table>
		<tr>
			<td colspan='".$length."'><center>$name</td>
		</tr>";
		
		$resposta.="<tr>";
		for($i=0;$i<$length;$i++){
			$colName=$keys[$i];
			if($colName !="id") $resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
			else $resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Editar</td>";
		}
		$resposta.="</tr>";
		while($line){
			$resposta.="<tr>";
			$id_conv = $line[$keys[3]];
			
			$aux = explode("/", $line[$keys[0]]);
			$conv_numero = $aux[0];
			
			$aux = explode("-", $line[$keys[1]]);
			$dtInicio =  $aux[2]."/".$aux[1]."/".$aux[0];
			
			$aux = explode("-", $line[$keys[2]]);
			$dtFim =  $aux[2]."/".$aux[1]."/".$aux[0];
			for($i=0;$i<$length;$i++){
				$informacao=$line[ $keys[$i] ];	
				if(($i == 1 || $i == 2 ) && ($name == "Convênios")){
					$aux = explode("-", $informacao);
					$informacao = $aux[2]."/".$aux[1]."/".$aux[0];
				}
				if($i == 3){
					$resposta.="<input type='hidden' name='tablefield[]' value='{$informacao}' readonly>";
					if($name == "Convênios")
						$resposta.="<td><center><big><input onClick=\"updateAgreement('$id_conv','$conv_numero','$dtInicio', '$dtFim');\" type='submit' id='botaoEditar'></td></tr>";
				}
				else
				$resposta.="<td><center><input style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}' readonly ></td>";
			
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}

function getTable32($c,$query,$name){
	$resp = mysqli_query($c, $query);
	
	if(!$resp){
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$keys=array_keys($line);          
		$length=count($keys);             
		$length2 = $length + 1;
		$resposta="<div class='CSSTableGenerator' style='width: 95%' >
		
		<table>
		<tr>
			<td colspan='".$length2."'><center>$name</td>
		</tr>";
		
		$resposta.="<tr>";
		for($i=0;$i<$length;$i++){
			$colName=$keys[$i];
			if($keys[$i] !="id") $resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
		}
		$resposta.="<td style='background-color: #193a73; width: 50px'><center><big><big><b><font color='white'>Excluir</td>";
		$resposta.="<td style='background-color: #193a73; width: 50px'><center><big><big><b><font color='white'>Atualizar</td>";
		$resposta.="</tr>";
		while($line){				
			$resposta.="<tr><form method='GET' action='company_update.php'>";
			
			for($i=0;$i<$length;$i++){
				$informacao=$line[ $keys[$i] ];			
				if($i == 3){
					$resposta.="<input type='hidden' name='tablefield[]' value='{$informacao}'>";
					$resposta.="<td><center><a href='company_delete.php?id={$informacao}'><img src='delete.png' height='20' /></a></td>";
					if($name == "Empresas"){
						$resposta.="<td><center><input type='submit' id='botaoConfirmar'></td>";
						$resposta.="</form>";
					}
				}
				else{
					if($i ==0){
					$resposta.="<td width='550px'><input style='text-align:left; background:inherit; border:none' size='80px' size='60px' style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}'></td>";
					}
					else{
						$resposta.="<td width='150 px'><center><input style='background: transparent; border: none;' name='tablefield[]' value='{$informacao}'></td>";
					}
				}
			}
			$resposta.="</tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}

function getTable4($c,$query,$name){
	$resp = mysqli_query($c, $query);
	
	if(!$resp){
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$keys=array_keys($line);          
		$length=count($keys);        
		$length--;  
		
		$resposta="<div class='CSSTableGenerator' style='width: 95%' >
		<table>
		<tr>
			<td colspan='".$length."'><center>$name</td>
		</tr>";
		
		$resposta.="<tr>";
		for($i=0;$i<$length;$i++){
			$colName=$keys[$i];
			if($i == 1 || $i == 2 || $i == 3)
				$resposta.="<td style='background-color: #193a73; width:90px'><center><big><big><b><font color='white'>$colName</td>";
			else if($i != 4 && $i != 7){
				$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
			}
		}
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Editar</td>";
		$resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>Excluir</td></tr>";
		while($line){					
			$resposta.="<tr>";
			for($i=0;$i<=$length;$i++){
				$informacao=$line[ $keys[$i] ];							
				if($i != 0){
					if(($i == 1) || ($i == 2 ) || ($i == 3)){
						$aux = explode("-", $informacao);
						$informacao = $aux[2]."/".$aux[1]."/".$aux[0];
					}
					if(($i == 1) || ($i == 2 ) || ($i == 3)){
						$resposta.="<td><center><input size='5px' style='background: transparent; border: none; ' 
										name='tablefield[]' value='{$informacao}' readonly></td>";
					}
					else if($i != 4 && $i != 8 && $i!= 3 && $i !=7 ){
						$resposta.="<td><center><input style='word-wrap: break-word; background: transparent;
								border: none;' name='tablefield[]' value='{$informacao}' readonly></td>";
				    }
					else{
						$resposta.="<center><input type='hidden' name='tablefield[]' value='{$informacao}' readonly>";
					}
				}
				else{
					$j = $i+4; 
					$k = $i+7;
					$emp_nome = $line[$keys[0]];
					$id_empresa = $line[$keys[$j]];
					$id_estagio = $line[$keys[$k]];
					$resposta.="<td><a style='margin-left:10px;' href='company_search.php?id=$id_empresa'><div class='fonte'>{$informacao}</div></a></td>";
				}	
			}
			$resposta.="<td><center><big><input onClick=\"updateData('$id_estagio','$emp_nome');\" type='submit' id='botaoEditar'></td>
			<td><center><big><a href='excluir_estagio.php?id={$line[$keys[7]]}'><img src='delete.png' height='16' /></a></td></tr>";
			$line = mysqli_fetch_assoc($resp);
		}
		$resposta.="</table></div>";
	}
	return $resposta;
}

function getTableAno ($c, $ano, $query, $name){	
	$resp = mysqli_query($c, $query); // query para descobrir quais estagios tem data inicio no ano dado
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	
	if($line=mysqli_fetch_assoc($resp))
		$keys=array_keys($line);// Pega um array com o nome(key) das colunas que referenciam os campos da tupla pegada em $line
	else{
		echo("<script>alert('Nenhum estágio iniciado neste ano');</script>");
		die();
	}
	$i = 0;
	while($line){
		$id_aluno[$i] = $line[$keys[0]]; //Salva no array id_aluno os id's dos alunos que tem dt_inicio no ano dado
		$line = mysqli_fetch_assoc($resp); 
		$i++;
	}
	
	$i = 0;
	$sql = "select id,Nome,Matricula as 'Matrícula',Unidade,CPF from aluno where id = '$id_aluno[$i]' ORDER BY nome";

	$resp = mysqli_query($c, $sql);
	$line=mysqli_fetch_assoc($resp);
	$keys=array_keys($line);          
	$length=count($keys);         

	$resposta="<div class='CSSTableGenerator' style='width: 95%'>
	<table>
	<tr>
		<td colspan='".$length."'><center>$name</td>
	</tr>";
	
	$resposta.="<tr>";
	for($i=1;$i<$length;$i++){
		$colName=$keys[$i];
		if($colName == "CPF") $resposta.="<td style='width:115px;background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
		else $resposta.="<td style='background-color: #193a73'><center><big><big><b><font color='white'>$colName</td>";
	}
	$resposta.="</tr>";	
	
	$i=0;
	$resp = mysqli_query($c, $sql);
	$line=mysqli_fetch_assoc($resp);
	

	while($line){ // Põe linhas da tabela						
			// Neste for() eu ponho os campos de cada coluna, porém, para acessar os valores dentro
			// do array $line eu preciso do nome(key) que o referencia ($line[key]),
			// e não de um número. Este nome é o nome da coluna em que ele está, na qual obtenho do array $keys.
			
			$id = $line['id'];
			$resposta.="<tr>";
			for($j=1;$j<$length;$j++){ // Põe nomes das colunas da tabela
				$informacao=$line[ $keys[$j] ];
				if($j==1) $resposta.="<td class='campo'><a href='student_search.php?id=$id'>{$informacao}</a></td>";
				else $resposta.="<td><center><div class='fonte'>{$informacao}</div></td>";
				
			}
			$resposta.="</tr>";
			
			$i++;
			$sql = "select id,Nome,Matricula as 'Matrícula',Unidade,CPF from aluno where id = $id_aluno[$i] ORDER BY nome";
			if(!$resp = mysqli_query($c, $sql)) break;
			$line=mysqli_fetch_assoc($resp);
	}
	
	$resposta.="</table></div>";
	return $resposta;

}

function getOptions($c,$query,$column){
	$resp = mysqli_query($c, $query); // Consulta SQL
	
	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	$line=mysqli_fetch_assoc($resp);
	if(!$line){
		$resposta=false;
	}
	else{
		$resposta="";		
		while($line){ // Põe options do select
			$informacao=$line[ $column ];							
			$resposta.="<option value=\"{$informacao}\">{$informacao}</option>";
			$line = mysqli_fetch_assoc($resp);
		}		
	}
	return $resposta;
}

function consultaBD($info,$query,$type){
	// Função para consultas tipo:SELECT(find), INSERT(create), DELETE(delete)
	// E para pegar valores de uma consulta, retornando o array com os dados de uma tupla
	// E para retornar as <option> de um select para uma tabela resultante da $query(consulta)
	
	list($host,$usuario,$senha,$banco)=explode("/",$info);

	$c = mysqli_connect($host,$usuario,$senha,$banco); // Conecta

	if(!$c){ // Checa conexão
		echo "erro na conexão";
		echo mysqli_connect_error();
		die();
	}

	if(!mysqli_select_db($banco)){ // Seleciona e checa banco
		echo "erro no select_db";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}

	$resp = mysqli_query($query); //Consulta SQL

	if(!$resp){ // Checa consulta
		echo "erro na consulta $query";
		echo mysqli_error();
		mysqli_close($c);
		die();
	}
	else{ // Caso consulta seja bem sucedida:
		$resposta=0;
		if($type=="find"){
			$line=mysqli_fetch_assoc($resp);
			
			if($line) $resposta=true; // Existe
			else $resposta=false; // Não existe
		}
		else if($type=="create" || $type=="delete" || $type=="update"){
			$resposta=true; // INSERT ou DELETE realizado com sucesso
			if(($type=="delete" || $type=="update") && mysqli_affected_rows()==0) $resposta=false;
			// Caso tenha sido realizado um delete ou update de uma tupla que não existe o mysql_affected_rows() retornará zero
		}
		else if($type=="getline"){
			$line=mysqli_fetch_assoc($resp);
			$resposta=$line;
		}
		else if($type=="getlist"){
			$line=mysqli_fetch_assoc($resp);
			if(!$line){
				$resposta=false;
			}
			else{
				
			}
			mysqli_close($c);
			
			return $resposta; // Retorna a resposta
		}
	}
}
?></html>
