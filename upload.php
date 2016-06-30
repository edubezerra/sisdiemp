<html><head><meta charset="utf-8"></head><?php
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
		set_time_limit(0);
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		include_once("dbfunctions.php");
		include_once("conection.php");
		mysqli_autocommit($c, FALSE);
	//	$fp      = fopen($tmpName, 'r');
		$cont = 0;
		$contUp = 0;
		$erro = 0;
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
				$telefone =  $data[10]."|".$data[13];
				$endereco = $data[14].$data[15].$data[16].$data[17].$data[18].$data[19].$data[21].$data[22];
				$email = $data[24];
				$data_nasc = $data[25];
				if($last_matricula!=$matricula){
					echo "Nome = $nome      ";
					echo "Matricula = $matricula       ";
					echo "Curso = $curso    ";
					echo "Cpf = $cpf     ";
					echo "Unidade = $unidade       ";
					echo "Telegone = $telefone     ";
					echo "Endereco = <br> $endereco      ";
				
					$sql = "select Matricula from aluno where Matricula = '$matricula';";
					$q= mysqli_query($c, $sql);
					if(!$q){
						$query = "INSERT INTO aluno(Nome, Matricula, Curso, Unidade, Cpf, telefone, email, data_nasc, endereco) VALUES('$nome','$matricula','$curso','$unidade','$cpf','$telefone', '$email', '$data_nasc', '$endereco');";
						if(!mysqli_query($c, $query)) $erro=1;
						$cont++;
					}
					else{                                                                                            //, telefone='$telefone', email = '$email', data_nasc = '$data_nasc', endereco = '$endereco'
						$query2 = "UPDATE aluno SET Nome = '$nome', Matricula = '$matricula', Curso = '$curso', Unidade = '$unidade', Cpf = '$cpf' where Matricula = '$matricula'";
						if(!mysqli_query($c, $query2)) $erro=2;
						$contUp++;
					}
				}
				$last_matricula = $matricula;
				if($erro > 0)
					break;
			}
			fclose($handle);
			if ($erro == 0){ mysqli_commit($c);
				echo("<script>alert('$contUp updates no banco. $cont inserções');</script>");} 
			else { 
				mysqli_rollback($c); 
				echo $erro;
				echo("<script>alert('Erro na importação de dados. Nenhum dado foi importado');</script>");
				
			}
		}
	} 
	//echo("<script>window.location.href = 'index.php';</script>");
?><html>