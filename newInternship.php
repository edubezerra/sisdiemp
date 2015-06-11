<html><head><meta charset="utf-8"></head>
<?php
	$url="student_search.php";
	if($_REQUEST["aluno"] && $_REQUEST["cpf"] && $_REQUEST["newCompany"] && $_REQUEST["inicio"] && $_REQUEST["fim"]){
		$nome=$_REQUEST["aluno"];
		$cpf=$_REQUEST["cpf"];
		$novaEmp=$_REQUEST["newCompany"];
		$inicio=$_REQUEST["inicio"];
		$fim=$_REQUEST["fim"];
		
		include "dbfunctions.php";
		
		$c=beginConnection("localhost/root//diemp");
		
		$sql="select";
		
		if(querySql($c, $sql, "find") == false){ // Se estágio ainda não existe, criar
			$sql="select a.id as id
				  from aluno a
				  where(a.aluno='$nome' and a.cpf='$cpf')";
			$line=querySql($c,$sql,"getline");
			$id=$line["id"];
			
			$sql="insert into ";
		}
		$url.="?nome=".$nome."&cpf=".$cpf;
	}
	header("location:$url");
?></html>