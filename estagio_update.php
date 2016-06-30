<html><head><meta charset="utf-8"></head><?php

	$id=$_REQUEST["id_aluno"];
	$url="student_search.php?id=$id";
	if($_REQUEST["inicio"] && $_REQUEST["fim"] && $_REQUEST["id_estagio"] && $_REQUEST["estado"] ){
		$id_estagio = $_REQUEST["id_estagio"];
		$inicio=$_REQUEST["inicio"];
		$fim=$_REQUEST["fim"];
		$estado = $_REQUEST["estado"];
		$rescisao = $_REQUEST["rescisao"];
		echo("<script>alert($estado);</script>");
		include("conection.php");
		include_once("dbfunctions.php");
		
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
		}
		else{
			if(!empty($rescisao)){
				$sql = "UPDATE estagio
					SET Data_Inicio_Vigencia = '$inicio', Data_Fim_Vigencia = '$fim', Data_Rescisao = '$rescisao',
					Estado = '$estado'
					WHERE id = $id_estagio;";
			}
			else{
				$sql = "UPDATE estagio
					SET Data_Inicio_Vigencia = '$inicio',Data_Rescisao = '0000-00-00', Data_Fim_Vigencia = '$fim',
					Estado = '$estado'
					WHERE id = $id_estagio;";
			}
			mysqli_query($c, $sql);
		}
		mysqli_close($c);
	}
	echo("<script>window.location.href = '$url';</script>");
?></html>