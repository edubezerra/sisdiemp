<html><head><meta charset="utf-8"></head>
<?php
	if($_REQUEST["nome"] && $_REQUEST["id"]){
		include_once("useful_functions.php");
		include_once("dbfunctions.php");
		include_once("conection.php");

		$comp=$_REQUEST["nome"];
		$code=$_REQUEST["cnpj"];
		$number = $_REQUEST["numero"];
		$id=$_REQUEST["id"];
		$url = "company_search.php?id=$id";
		// VALIDAÇÃO CNPJ INICIO
			$cnpj = soNumero($code);
			
			$soma_d1 = 
			$cnpj[0]*5 +
			$cnpj[1]*4 +
			$cnpj[2]*3 +
			$cnpj[3]*2 +
			$cnpj[4]*9 +
			$cnpj[5]*8 +
			$cnpj[6]*7 +
			$cnpj[7]*6 +
			$cnpj[8]*5 +
			$cnpj[9]*4 +
			$cnpj[10]*3 +
			$cnpj[11]*2;
			
			$resto = $soma_d1%11;
			$d1 = ($resto < 2)?(0):(11-$resto);
			
			$soma_d2 = 
			$cnpj[0]*6 +
			$cnpj[1]*5 +
			$cnpj[2]*4 +
			$cnpj[3]*3 +
			$cnpj[4]*2 +
			$cnpj[5]*9 +
			$cnpj[6]*8 +
			$cnpj[7]*7 +
			$cnpj[8]*6 +
			$cnpj[9]*5 +
			$cnpj[10]*4 +
			$cnpj[11]*3 +
			$cnpj[12]*2;
			
			$resto = $soma_d2%11;
			$d2 = ($resto < 2)?(0):(11-$resto);
			
			// VALIDAÇÃO CNPJ FIM
			
			$sql = "select Nome from empresa where Cnpj = '$code'";
			$query = mysqli_query($c, $sql);
			$num_rows = mysqli_num_rows($query);
			if(($cnpj[12] != $d1)||($cnpj[13] != $d2)||(!preg_match('/(^[\d]{14}$)/',$cnpj)) || ($num_rows > 0)){
				if($num_rows >0)
					echo("<script>alert('Este CNPJ já está cadastrado no sistema');</script>");
				else
					echo("<script>alert('CNPJ inválido');</script>");
				$sql = "update empresa set Nome = '$comp', Numero = '$number'  where id = $id";
				mysqli_query($c, $sql);
			}
			else{
				$sql="update empresa set Nome = '$comp', Cnpj = '$code', Numero= '$number'  where id = $id";
				mysqli_query($c, $sql);
			}
		mysqli_close($c);
	}
	echo("<script>window.location.href = '$url';</script>");
?></html>
