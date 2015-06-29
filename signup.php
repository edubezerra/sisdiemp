<html><head><meta charset="utf-8"></head><?php
	include_once('useful_functions.php');
	include_once('dbfunctions.php');
	include_once('conection.php');
	$result;
	if($_REQUEST["nome"] && $_REQUEST["cnpj"] && $_REQUEST["fim"] && $_REQUEST["comp"] && $_REQUEST["start"]){
		$name=$_REQUEST["nome"];
		$code=$_REQUEST["cnpj"];
		$comp = $_REQUEST["comp"];
		$start=$_REQUEST["start"];
		$end=$_REQUEST["fim"];
		
		// VALIDAÇÃO CNPJ INICIO
		
		$cnpj = soNumero($code);
		
		$soma_d1 = 
		$cnpj[0]*5 +
		$cnpj[1]*4 +
		$cnpj[2]*3 +
		$cnpj[3]*2 +
		$cnpj[4]*9 +
		$cnpj[5]*8 +
		$cnpj[6]*7 +
		$cnpj[7]*6 +
		$cnpj[8]*5 +
		$cnpj[9]*4 +
		$cnpj[10]*3 +
		$cnpj[11]*2;
		
		$resto = $soma_d1%11;
		$d1 = ($resto < 2)?(0):(11-$resto);
		
		$soma_d2 = 
		$cnpj[0]*6 +
		$cnpj[1]*5 +
		$cnpj[2]*4 +
		$cnpj[3]*3 +
		$cnpj[4]*2 +
		$cnpj[5]*9 +
		$cnpj[6]*8 +
		$cnpj[7]*7 +
		$cnpj[8]*6 +
		$cnpj[9]*5 +
		$cnpj[10]*4 +
		$cnpj[11]*3 +
		$cnpj[12]*2;
		
		$resto = $soma_d2%11;
		$d2 = ($resto < 2)?(0):(11-$resto);
		
		if(!preg_match('/(^[\d\D\s]{3,500}$)/',$name)){
			echo("<script>alert('Razão Social inválida!')</script>");
			die();
		}
		
		if(($cnpj[12] != $d1)||($cnpj[13] != $d2)||(!preg_match('/(^[\d]{14}$)/',$cnpj))){
			echo("<script>alert('CNPJ Inválido!')</script>");
			die();
		}

		
		if(!preg_match('/(^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$)/',$start)){
			echo("<script>alert('Data de Início do Convênio inválida!')</script>");
			die();
		}
		
		if((!preg_match('/(^[\d]{1,2}$)/',$end))){
			echo("<script>alert('Duração do Convênio inválida!')</script>");
			die();
		}
		$tmp = '';
		$tmp .= $cnpj[0];
		$tmp .= $cnpj[1];
		$tmp .= '.';
		$tmp .= $cnpj[2];		
		$tmp .= $cnpj[3];
		$tmp .= $cnpj[4];
		$tmp .= '.';
		$tmp .= $cnpj[5];
		$tmp .= $cnpj[6];
		$tmp .= $cnpj[7];
		$tmp .= '/';
		$tmp .= $cnpj[8];
		$tmp .= $cnpj[9];
		$tmp .= $cnpj[10];
		$tmp .= $cnpj[11];
		$tmp .= '-';
		$tmp .= $cnpj[12];
		$tmp .= $cnpj[13];
		
		$cnpj = addslashes($tmp);
		
		$start_date = explode('-',$start);
		$start_year_2 = $start_date[0]%100;
		$start_year = $start_date[0];
				
		$number = $start_year + $end;
	
		
		$end_date = '';
		$end_date .= $number;
		$end_date .= '-';
		$end_date .= $start_date[1];
		$end_date .= '-';
		$end_date .= $start_date[2];
		
		// VALIDAÇÃO CNPJ FIM
		
		$sql="select id
			  from empresa
			  where(cnpj='$code')";
		$line=querySql($c, $sql, "getline");
		$idEmpresa = $line["id"];
		
		if(querySql($c, $sql, "find")==false){
			$sql="insert into empresa(nome, numero, cnpj) values('$name','$comp','$cnpj')";
			if(querySql($c, $sql, "create")==true){
				$numeroConvenio=$comp."/".$start_year_2;
				
				$sql="select id from empresa where(nome='$name' and cnpj='$cnpj')";
				$line=querySql($c, $sql, "getline");
				$idEmpresa=$line["id"];
				
				$sql="insert into convenio(numero, id_empresa, data_inicio,data_fim) values('$numeroConvenio','$idEmpresa','$start','$end_date')";
				if(querySql($c, $sql, "create")==true){	
					$result = "
					<div class='alert'>
						<a style='color: white' href='company_search.php?id=$idEmpresa'>
							<div class='stdSearchResult' style='background-color: #333333'>
								<font color='white'><br>
									Empresa cadastrada e conveniada com sucesso.<br>Clique aqui para visualizar seus dados.
								</font>
							</div>
						</a>
					</div>";
					}
			}
		}
		else{
			$result = "
			<div class='alert'>
				<a style='color: white' href='company_search.php?id=$idEmpresa'>
					<div class='stdSearchResult' style='background-color: #333333'>
						<font color='white'><br>
							CNPJ já cadastrado.<br>Clique aqui para editar seus dados ou renovar convênio.
						</font>
					</div>
				</a>
			</div>";
		}
		mysql_close($c);
		echo("<script>window.location.href = 'company_search.php?id=$idEmpresa';</script>");
	}	
?></html>