<html><head><meta charset="utf-8"></head>
<?php
	/* ------ NOVO ESTAGIO --------  */
		$id=$_REQUEST["id"];
		$url="student_search.php?id=$id";
		
		if($_REQUEST["inicio"] && $_REQUEST["fim"] && $_REQUEST["cnpj"] && $_REQUEST["estado"]){
			$inicio=$_REQUEST["inicio"];
			$fim=$_REQUEST["fim"];
			$estado = $_REQUEST["estado"];
			$cnpj = $_REQUEST["cnpj"];
			include("conection.php");
			include_once("dbfunctions.php");
			$sql= "SELECT id FROM empresa WHERE cnpj = '$cnpj';";
			$res = mysqli_query($c, $sql);
			if(!$res){
				echo("<script>alert('CNPJ inexistente no sistema!');</script>");
				mysqli_close($c);
				echo("<script>window.location.href = '$url';</script>");
			}
			$line = mysqli_fetch_assoc($res);
			$empresa = $line['id'];
			
			$start_date = explode('-',$inicio);
			$start_year = $start_date[0];
			$start_month = $start_date[1];
			$start_day = $start_date[2];
			
			$end_date = explode('-',$fim);
			$end_year = $end_date[0];
			$end_month = $end_date[1];
			$end_day = $end_date[2];
						
			if($start_year > $end_year){
				echo("<script>alert('Data(s) invalida(s)!');</script>");
				mysqli_close($c);
				echo("<script>window.location.href = '$url';</script>");
			}
			else{
				$sql = "SELECT id, numero FROM convenio WHERE id_empresa = $empresa;";
				$line = querySql($c, $sql, "getline");
				$id_convenio = $line["id"];
				if($line){
					$sql="insert into estagio(data_inicio_vigencia, data_fim_vigencia, 
						data_rescisao,id_aluno,id_convenio, Estado) values('$inicio','$fim','0000-00-00','$id','$id_convenio', '$estado')";
					$res = mysqli_query($c, $sql);	
				}
			}
			mysqli_close($c);
		
		}
		else{
			if(!$_REQUEST["inicio"])
				echo("<script>alert('Necessário informar o início do estágio!');</script>");	
			else if(!$_REQUEST["fim"])
				echo("<script>alert('Necessário informar o final do estágio!');</script>");	
			else if(!$_REQUEST["cnpj"])
				echo("<script>alert('Necessário informar o CNPJ da empresa!');</script>");	
			else
				echo("<script>alert('Necessário informar o estado do estágio!');</script>");	

		}
	echo("<script>window.location.href = '$url';</script>");
?></html>