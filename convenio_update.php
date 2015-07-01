<html><head><meta charset="utf-8"></head>
<?php
	/* ---------- ATUALIZAR CONVÊNIO ------------- */
	if($_REQUEST["id"]){
		$id_emp=$_REQUEST["id"];
		$url="company_search.php?id=$id_emp";
		include("conection.php");
		include_once("dbfunctions.php");

		if($_REQUEST["idConv"]){
			$id=$_REQUEST["idConv"];
			if($_REQUEST["dataIni"] && $_REQUEST["dataFim"] && $_REQUEST["numero"]){
				$inicio=$_REQUEST["dataIni"];
				$fim=$_REQUEST["dataFim"];
				$numero_conv = $_REQUEST["numero"];

				if(!preg_match("/[0-9]{4}/", $numero_conv) || !preg_match("/[0-9]{3}/", $numero_conv)  ){
					echo("<script>alert('Número de convênio inválido');</script>");
				}
				else{
					
					$date = explode('/',$inicio);
					$year = $date[2];
					$month = $date[1];
					$day = $date[0];
					
					$dateEnd = explode('/',$fim);
					$yearEnd = $date[2];
					$monthEnd = $date[1];
					$dayEnd = $date[0];
					
					
					if($year < 1905){
						echo("<script>alert('Data de início inválida!');</script>");
					}
					else if($yearEnd-$year < 0){
						echo("<script>alert('Duração de convênio inválida!');</script>");	
					}
					else{
						$end_date = '';
						$end_date .= $yearEnd;
						$end_date .= '-';
						$end_date .= $monthEnd;
						$end_date .= '-';
						$end_date .= $dayEnd;
						
						$start_date = '';
						$start_date .= $year;
						$start_date .= '-';
						$start_date .= $month;
						$start_date .= '-';
						$start_date .= $day;					
						
						$numero_convenio = $line["numero"];
						$numero_convenio = explode('/', $numero_convenio);
						$numero_empresa = $numero_convenio[0];
						
						$novo_convenio = '';
						$novo_convenio .= $numero_conv;
						$novo_convenio .= '/';
						$novo_convenio .= $year%100;
						
						$sql="update convenio set Numero = '$novo_convenio', data_inicio = '$start_date', data_fim = '$end_date' where id = $id;";
						$res = mysql_query($sql);
						mysql_close($c);
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
	}
	echo("<script>window.location.href = '$url';</script>");
?></html>