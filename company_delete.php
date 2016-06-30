<header><script>
	function redireciona(id){
		alert('Empresa excluida com sucesso!');
		document.location='company_delete2.php?id='+id+'';
	}
	function volta(){
		document.location='company_complete';
	}
</script>
<meta charset="UTF-8">
</header>
<?php
		$url = "company_complete.php";
		$id = $_REQUEST["id"];
		include("conection.php");
		$sql = "SELECT nome FROM empresa
				WHERE id = $id;";
		$resp = mysqli_query($c, $sql);
		$line = mysqli_fetch_assoc($resp);
		$nome = $line["nome"];
		mysqli_close($c);
		echo("<center>
			<table border='2' width='650px' style='text-align: center;'>
				<tr>
					<td colspan='2'><font size='6'>Tem certeza que deseja excluir a empresa $nome?</td>
				</tr>
				<tr>
					<td onclick='redireciona($id)' style='cursor: pointer; background: black; color: white'>
						<font size='7'>Sim
					</td>
					<td onclick='volta()' style='cursor: pointer; background: black; color: white'>
						<font size='7'>Não
					</td>
				</tr>
			</table>");
?>
