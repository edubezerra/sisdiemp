<?php 
	include("conection.php");
	$id = $_REQUEST["id"];
	if($id){
		$sqlExcluir = "select id_aluno from estagio where id = '$id';";
		if($resp = mysql_query($sqlExcluir)){
			$line = mysql_fetch_assoc($resp);
			$key = array_keys($line);
			$id_aluno = $line[$key[0]];
			$sqlExcluir = "delete from estagio where id = '$id';";
			mysql_query($sqlExcluir);
		}
	}
	echo("<script>document.location='student_search.php?id='+$id_aluno+'';</script>");
?>