<?php
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
		set_time_limit(0);
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		include_once("dbfunctions.php");
		include_once("conection.php");
	//	$fp      = fopen($tmpName, 'r');
		$cont = 0;
		$contUp = 0;
		//$array = file($handle, FILE_TEXT | 	FILE_SKIP_EMPTY_LINES);
		//$data = explode(",", $array);
		if (($handle = fopen($tmpName, "r")) !== FALSE) {
			$data = fgetcsv($handle, 100, ",");
			while (($data = fgetcsv($handle,100,',')) != FALSE) {
				$nome = $data[0];
				$matricula = $data[1];
				$curso = $data[3];
				$cpf = $data[4];
				$unidade = $data[5];
				$sql = "select Matricula from aluno where Matricula = '$matricula';";
				if(!mysql_query( $sql )){
					$query = "INSERT INTO aluno(Nome, Matricula, Curso, Unidade, Cpf) VALUES('$nome','$matricula','$curso','$unidade','$cpf');";
					mysql_query($query);
					$cont++;
				}
				else{
					//$query = "UPDATE aluno SET Nome = '$nome', Matricula = '$matricula', Curso = '$curso', Unidade = '$unidade', Cpf = '$cpf' where Matricula = '$matricula'";
					//mysql_query($query);
					echo("<script>alert($contUp);</script>");
					$contUp++;
				}
			}
			fclose($handle);
			echo("cont ".$cont);
			echo("   contUp ".$contUp);
		}
	} 
?>