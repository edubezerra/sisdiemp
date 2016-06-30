<html><head><meta charset="utf-8"></head><?php
	
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once('useful_functions.php');
		include_once('dbfunctions.php');
		include_once('conection.php');

		$permission = mysqli_query($c, "SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");

		if (!$permission) {
		    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysqli_error();
		    exit;
		}

		if (mysqli_num_rows($permission) <= 0) {
			echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
		    exit;
		}

		$row = mysqli_fetch_assoc($permission);
		$isAdmin = $row["isAdmin"];

		if($isAdmin == 1){
			$result;

			if($_REQUEST["id"] && $_REQUEST["email"] && $_REQUEST["tecnicos"] && $_REQUEST["funcao"] && $_REQUEST["salario"] && $_REQUEST["dataVigencia"] && $_REQUEST["dataPublicacao"] && $_REQUEST["horarioInicio"] && $_REQUEST["horarioFim"] && $_REQUEST["beneficios"] && $_REQUEST["local"]){
				
				$id=$_REQUEST["id"];
				//$idConvenio=$_REQUEST["idConvenio"];
				$email=$_REQUEST["email"];
				$tecnicos=$_REQUEST["tecnicos"];
				$funcao=$_REQUEST["funcao"];
				$salario=$_REQUEST["salario"];
				$dataVigencia =$_REQUEST["dataVigencia"];
				$dataPublicacao = $_REQUEST["dataPublicacao"];
				$horarioInicio=$_REQUEST["horarioInicio"];
				$horarioFim=$_REQUEST["horarioFim"];
				$beneficios=$_REQUEST["beneficios"];
				$local=$_REQUEST["local"];
				
				$sql="UPDATE oferta_estagio SET salario='$salario', beneficios='$beneficios', local='$local', data_vigencia='$dataVigencia', data_publicacao='$dataPublicacao', horarioInicio='$horarioInicio', horarioFim='$horarioFim', funcao='$funcao', tecnico_desejado='$tecnicos', email_empresa='$email', id_convenio='0' WHERE id='$id';";

				if(querySql($c, $sql, "update")==true){
						$result = "
						<div class='alert'>
							<a style='color: white' href='index.php'>
								<div class='stdSearchResult' style='background-color: #333333'>
									<font color='white'><br>
										Oferta alterada com sucesso.
									</font>
								</div>
							</a>
						</div>";
						echo($result);
						//}
				}else{
					$result = "
						<div class='alert'>
							<a style='color: white'>
								<div class='stdSearchResult' style='background-color: #333333'>
									<font color='white'><br>
										Erro!
									</font>
								</div>
							</a>
						</div>";
					echo($result);
				}
				mysqli_close($c);
				//echo("<script>window.location.href = 'company_search.php?id=$idEmpresa';</script>");
			}
		}
	}

	

	
?></html>