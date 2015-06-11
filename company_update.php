<html><head><meta charset="utf-8"></head><?php
	$fields=$_REQUEST["tablefield"];
	$url = "company_complete.php";
	include_once("conection.php");
	$i = 0;
	$nome=$fields[$i];
	$cnpj=trim($fields[$i+1], "\t ");
	$numero=trim($fields[$i+2], "\t ");
	$id=$fields[$i+3];
	$cnpj_valido = false;
	if(!empty($cnpj)){
		$cnpj_numbers = preg_replace("/[^0-9]/", "", $cnpj);
		$soma_d1 = 
		$cnpj_numbers[0]*5 +
		$cnpj_numbers[1]*4 +
		$cnpj_numbers[2]*3 +
		$cnpj_numbers[3]*2 +
		$cnpj_numbers[4]*9 +
		$cnpj_numbers[5]*8 +
		$cnpj_numbers[6]*7 +
		$cnpj_numbers[7]*6 +
		$cnpj_numbers[8]*5 +
		$cnpj_numbers[9]*4 +
		$cnpj_numbers[10]*3 +
		$cnpj_numbers[11]*2;
		
		$resto = $soma_d1%11;
		$d1 = ($resto < 2)?(0):(11-$resto);
		
		$soma_d2 = 
		$cnpj_numbers[0]*6 +
		$cnpj_numbers[1]*5 +
		$cnpj_numbers[2]*4 +
		$cnpj_numbers[3]*3 +
		$cnpj_numbers[4]*2 +
		$cnpj_numbers[5]*9 +
		$cnpj_numbers[6]*8 +
		$cnpj_numbers[7]*7 +
		$cnpj_numbers[8]*6 +
		$cnpj_numbers[9]*5 +
		$cnpj_numbers[10]*4 +
		$cnpj_numbers[11]*3 +
		$cnpj_numbers[12]*2;

		$new_cnpj = '';
		$new_cnpj .= $cnpj_numbers[0];
		$new_cnpj .= $cnpj_numbers[1];
		$new_cnpj .= '.';
		$new_cnpj .= $cnpj_numbers[2];
		$new_cnpj .= $cnpj_numbers[3];
		$new_cnpj .= $cnpj_numbers[4];
		$new_cnpj .= '.';
		$new_cnpj .= $cnpj_numbers[5];
		$new_cnpj .= $cnpj_numbers[6];
		$new_cnpj .= $cnpj_numbers[7];
		$new_cnpj .= '/';
		$new_cnpj .= $cnpj_numbers[8];
		$new_cnpj .= $cnpj_numbers[9];
		$new_cnpj .= $cnpj_numbers[10];
		$new_cnpj .= $cnpj_numbers[11];
		$new_cnpj .= '-';
		$new_cnpj .= $cnpj_numbers[12];
		$new_cnpj .= $cnpj_numbers[13];
		$resto = $soma_d2%11;
		$d2 = ($resto < 2)?(0):(11-$resto);
		if(!(($cnpj_numbers[12] != $d1)||($cnpj_numbers[13] != $d2)||(!preg_match('/(^[\d]{14}$)/',$cnpj_numbers))))
			$cnpj_valido = true;
		else
			$cnpj_valido = false;
	}
			
	if($cnpj_valido){	
		if(!empty($numero)){
			$sql = "UPDATE empresa SET nome = '$nome', cnpj = '$cnpj', Numero = $numero WHERE id = $id;";
			mysql_query($sql);
			echo("<script>alert('Atualizações realizadas com sucesso');</script>");
		}
		else{
				$sql = "UPDATE empresa SET nome = '$nome', cnpj = '$cnpj' WHERE id = $id;";
				mysql_query($sql);	
				echo("<script>alert('CNPJ atualizado');</script>");
		}
	}
	else{
		if(!empty($numero)){
			echo("<script>alert('Cnpj inválido! Número salvo com sucesso');</script>");
			$sql = "UPDATE empresa SET nome = '$nome', Numero = $numero WHERE id = $id;";
			mysql_query($sql);
		}
		else{
			echo("<script>alert('Cnpj inválido!');</script>");
			$sql = "UPDATE empresa SET nome = '$nome' WHERE id = $id;";
			mysql_query($sql);
		}
	}
	mysql_close($c);
	echo("<script>window.location.href = '$url';</script>");
?></html>
