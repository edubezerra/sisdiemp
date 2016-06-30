<?php
// Array with names
if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");

		$permission = mysqli_query($c,"SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");

		if (!$permission) {
		    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysqli_error();
		    exit;
		}

		if (mysqli_num_rows($permission) <= 0) {
			//echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
		    //exit;
		    $row = mysqli_fetch_assoc($permission);
			$isAdmin = $row["isAdmin"];
		}else{
			$isAdmin = 0;
		}
		
		$tec = $_REQUEST["tec"];

		if($isAdmin == 1){
			//echo"<script language='javascript' type='text/javascript'>window.location.href='index.php';</script>";
			//$tec = $_REQUEST["tec"];

			if ($tec !== "") {
			    //$query = mysql_query("SELECT * FROM oferta_estagio where tecnico_desejado like '%$tec%'") or die("erro ao selecionar");
			    $sql = "SELECT * FROM oferta_estagio where tecnico_desejado like '%$tec%'";
			    /*
			    $num_rows = mysql_num_rows($query);
							if($num_rows <= 0){
								echo("Não há nenhuma empresa com técnico = \"$tec\".");
								die();
							}
				*/

				echo getOfferTable32($c,$sql);
				

				/*
			    while($row = mysql_fetch_assoc($query)){
			    	echo $row["id"],'%-.!.-%',$row["salario"],'%-.!.-%',$row["beneficios"],'%-.!.-%',$row["data_vigencia"],'%-.!.-%',$row["data_publicacao"],'%-.!.-%',$row["horarioInicio"],'%-.!.-%',$row["horarioFim"],'%-.!.-%',$row["funcao"],'%-.!.-%',$row["tecnico_desejado"],'%-.!.-%',$row["id_convenio"],'%-.!.-%',$row["email_empresa"],'<br>';
			    } 
				*/
			}
		}else {
			$sql = "SELECT * FROM oferta_estagio where tecnico_desejado like '%$tec%'";
			echo getOfferTable($c,$sql,0);
		}
	}



?>