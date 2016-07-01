<html><head><meta charset="utf-8"></head><?php
	include_once('useful_functions.php');
	$result;
	$acesso="localhost/root//diemp";
	if($_REQUEST["nome"] && $_REQUEST["cnpj"] && $_REQUEST["fim"] && $_REQUEST["comp"]){
		$name=$_REQUEST["nome"];
		$code=$_REQUEST["cnpj"];
		$comp = $_REQUEST["comp"];
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

		// VALIDAÇÃO CNPJ FIM
		// Expressão regular do CNPJ ou CPF: ([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})
		
		include 'dbfunctions.php';
		
		$c=beginConection($acesso);
		
		$sql="select *
			  from empresa
			  where(nome='$name' or cnpj='$code')";
		if(querySql($c, $sql, "find")==false){
			$sql="insert into empresa(nome, cnpj) values('$name','$code')";
			if(querySql($c, $sql, "create")==true){
				$numeroConvenio=$comp."/".$end;
				
				$sql="select id from empresa where(nome='$name' and cnpj='$code')";
				$line=querySql($c, $sql, "getline");
				$idEmpresa=$line["id"];
				
				$sql="insert into convenio(numero, id_empresa) values('$numeroConvenio','$idEmpresa')";
				if(querySql($c, $sql, "create")==true)				
					$result = "
					<div class='alert'>
						<a style='color: white' href='company_search.php?company=$cnpj'>
							<div class='stdSearchResult' style='background-color: #333333'>
								<font color='white'><br>
									Empresa cadastrada e conveniada com sucesso.<br>Clique aqui para visualizar seus dados.
								</font>
							</div>
						</a>
					</div>";
			}
		}
		else{
			$result = "
			<div class='alert'>
				<a style='color: white' href='company_search.php?company=$cnpj'>
					<div class='stdSearchResult' style='background-color: #333333'>
						<font color='white'><br>
							Empresa já cadastrada.<br>Clique aqui para editar seus dados ou renovar convênio.
						</font>
					</div>
				</a>
			</div>";
		}
		
		
	}
	mysqli_close($c);
	echo $result;
?></html>
