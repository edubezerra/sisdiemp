<html><head><meta charset="utf-8"></head><?php
	$std=$_REQUEST["std"];
	$mat=$_REQUEST["mat"];
	$curso=$_REQUEST["curso"];
	$unit=$_REQUEST["unit"];
	$tfields=$_REQUEST["tablefield"];
	$url = "student_search.php?student=$std";
	
	$n=count($tfields);
	include_once("conection.php");
		
	for($i=0; $i < $n; $i = $i+8){
		$dt_ini = $tfields[$i+3];
		$dt_fim = $tfields[i+4];
		$dt_rescisao = $tfields[i+5];
		$estado_est = $tfields[i+6];
		$est_id = $tfields[i+2];
		
		$sql = "UPDATE estagio
			set Data_Inicio_Vigencia = '$dt_ini', Data_Fim_Vigencia = '$dt_fim',
			Data_Rescisao = '$dt_rescisao', Estado = '$estado_est'
			WHERE id = $est_id;";
				
		mysqli_query($c, $sql);
		
	}
	header("location:$url");
	mysqli_close($c);

?><html>