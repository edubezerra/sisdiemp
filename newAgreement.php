<html><head><meta charset="utf-8"></head>
<?php
	/* ---------- NOVO CONVÊNIO ------------- */
	if($_REQUEST["id"]){
		$id=$_REQUEST["id"];
		$url="company_search.php?id=$id";
		
		if($_REQUEST["inicio"] && $_REQUEST["fim"] && $_REQUEST["numero_conv"]){
			$inicio=$_REQUEST["inicio"];
			$fim=$_REQUEST["fim"];
			$numero_conv = $_REQUEST["numero_conv"];
			if(!preg_match('/[0-9]{4}/', $numero_conv) || preg_match('/[0-9]{3}/', $numero_conv)){
				echo("<script>alert('Número de convênio inválido');</script>");
			}
			else{
				include("conection.php");
				include_once("dbfunctions.php");
				
				$date = explode('-',$inicio);
				$year = $date[0];
				$month = $date[1];
				$day = $date[2];
				
				$start_year = $date[0];
				$end_year = $start_year+$fim;
				
				if($start_year < 1905){
					echo("<script>alert('Data de início inválida!');</script>");
				}
				else if($end_year-$start_year > 99){
					echo("<script>alert('Duração de convênio inválida!');</script>");	
				}
				else{
					$end_date = '';
					$end_date .= $end_year;
					$end_date .= '-';
					$end_date .= $date[1];
					$end_date .= '-';
					$end_date .= $date[2];
					
					$sql = "SELECT numero FROM convenio WHERE id_empresa = $id;";
					$line = querySql($c, $sql, "getline");
					
					$numero_convenio = $line["numero"];
					$numero_convenio = explode('/', $numero_convenio);
					$numero_empresa = $numero_convenio[0];
					
					$novo_convenio = '';
					$novo_convenio .= $numero_conv;
					$novo_convenio .= '/';
					$novo_convenio .= $year%100;
					mysql_close($c);
					
					include("conection.php");
					$sql="insert into convenio(numero, id_empresa, data_inicio,data_fim) values('$novo_convenio','$id','$inicio','$end_date')";
					$res = mysqlo_query($c, $sql);
					mysqli_close($c);
				}
			}
		}
		else{
			if(!$_REQUEST["inicio"])
				echo("<script>alert('Necessário informar o início do convênio!');</script>");	
			else if(!$_REQUEST["fim"])
				echo("<script>alert('Necessário informar o tempo de convênio!');</script>");	
			else
				echo("<script>alert('Necessário informar o número do convênio!');</script>");	
		}
	}
	echo("<script>window.location.href = '$url';</script>");
?></html>