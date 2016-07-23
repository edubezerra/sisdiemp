<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 ">
</head>
<body>
<?php
	
	$conexao = mysql_connect("localhost", "root", "");

	if(!$conexao) die ("Falha ao conectar ao banco");
		$bd = mysql_select_db("diemp");

	if(isset($_FILES['arquivo'])){
		$extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
		$novo_nome = md5(time()) . $extensao;
		$diretorio = "upload/";

		if($extensao == '.csv')
			move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);
		else
			echo "<script> alert('Arquivo não é válido.'); </script>";	

		$objeto = fopen($diretorio.$novo_nome, 'r');

		set_time_limit(300);

		$COD_CURSO = 0;
		
		while (($dados = fgetcsv($objeto, 1000, ",")) !== FALSE) {	
			
			for ($i=0; $i < count($dados); $i++) { 
				$dados[$i] = mysql_escape_string($dados[$i]);
			}

			
			$dataForm = date_converter($dados[27]);

			$sql = "SELECT ID FROM Pessoa WHERE CPF = '$dados[4]'";

			$var = mysql_query($sql) or die(mysql_error());

			$result = mysql_fetch_assoc($var);

			$existe = count($result["ID"]);

			if($existe == 0){
				$sql = "SELECT ID FROM CURSO WHERE COD_CURSO =  '$dados[2]'";
				$var = mysql_query($sql) or die(mysql_error());
				$var = mysql_fetch_array($var);
				$COD_CURSO = $var["ID"];

				$sql = "INSERT INTO PESSOA(
					NOME,
					CPF,
					SITUACAO,
					DDI_RESIDENCIAL,
					DDD_RESIDENCIAL,
					FONE_RESIDENCIAL,
					DDI_COMERCIAL,
					DDD_COMERCIAL,
					FONE_COMERCIAL,
					DDI_CELULAR,
					DDD_CELULAR,
					FONE_CELULAR,
					TIPO_LOGRADOURO,
					LOGRADOURO,
					NUMERO,
					COMPLEMENTO,
					BAIRRO,
					CEP,
					DISTRITO,
					MUNICIPIO,
					UF,
					PAIS,
					EMAIL,
					DT_NASC
				) VALUES (
					'$dados[0]',
					'$dados[4]',
					'$dados[6]',
					'$dados[7]',
					'$dados[8]',
					'$dados[9]',
					'$dados[10]',
					'$dados[11]',
					'$dados[12]',
					'$dados[13]',
					'$dados[14]',
					'$dados[15]',
					'$dados[16]',
					'$dados[17]',
					'$dados[18]',
					'$dados[19]',
					'$dados[20]',
					'$dados[21]',
					'$dados[22]',
					'$dados[23]',
					'$dados[24]',
					'$dados[25]',
					'$dados[26]',
					'$dataForm'
				);";
			}else{
				$sql = "UPDATE PESSOA SET
						NOME = '$dados[0]',
						CPF = '$dados[4]',
						SITUACAO = '$dados[6]',
						DDI_RESIDENCIAL = '$dados[7]',
						DDD_RESIDENCIAL = '$dados[8]',
						FONE_RESIDENCIAL = '$dados[9]',
						DDI_COMERCIAL = '$dados[10]',
						DDD_COMERCIAL = '$dados[11]',
						FONE_COMERCIAL = '$dados[12]',
						DDI_CELULAR = '$dados[13]',
						DDD_CELULAR = '$dados[14]',
						FONE_CELULAR = '$dados[15]',
						TIPO_LOGRADOURO = '$dados[16]',
						LOGRADOURO = '$dados[17]',
						NUMERO = '$dados[18]',
						COMPLEMENTO = '$dados[19]',
						BAIRRO = '$dados[20]',
						CEP = '$dados[21]',
						DISTRITO = '$dados[22]',
						MUNICIPIO = '$dados[23]',
						UF = '$dados[24]',
						PAIS = '$dados[25]',
						EMAIL = '$dados[26]',
						DT_NASC = '$dataForm'
					WHERE 
						CPF = '$dados[4]'";
			}

			if($dados[0] != 'NOME_ALUNO'){
				if($existe == 0){
					mysql_query($sql) or die(mysql_error());
					$sql = "INSERT INTO PESSOA__CURSO(
							ID_PESSOA,
							ID_CURSO,
							MATRICULA)
							SELECT
							p.id,
							'$COD_CURSO',
							'$dados[1]'
							FROM pessoa p
							WHERE CPF = '$dados[4]'
							;";
					mysql_query($sql) or die(mysql_error());
				}else{
					mysql_query($sql) or die(mysql_error());
				}
			}
		}

		fclose($objeto);
		
		echo "<script> alert('Arquivo válido e enviado com sucesso.'); </script>";	

		unlink($diretorio.$novo_nome);

		echo "<script> location.href='/student_import.php'; </script>";
	}else{
		echo "<script> alert('Arquivo não é válido.'); </script>";	
	}

	function date_converter($_date = null) {
	$format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
	if ($_date != null && preg_match($format, $_date, $partes)) {
		return $partes[3].'-'.$partes[2].'-'.$partes[1];
	}
	return false;
}

?>
</body>
</html>