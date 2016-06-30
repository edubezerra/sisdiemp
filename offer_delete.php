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

			if($_REQUEST["id"]){
				
				$id=$_REQUEST["id"];
				
				$sql="DELETE FROM oferta_estagio WHERE id='$id';";

				if(querySql($c, $sql, "delete")==true){
						$result = "
						<div class='alert'>
							<a style='color: white' href='index.php'>
								<div class='stdSearchResult' style='background-color: #333333'>
									<font color='white'><br>
										Oferta exclu&iacute;da com sucesso.
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
										Erro ao excluir oferta!
									</font>
								</div>
							</a>
						</div>";
					echo($result);
				}
				mysqli_close($c);
			}
		}
	}

	

	
?></html>