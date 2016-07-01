<?php
// Array with names
include_once("dbfunctions.php");
include_once("conection.php");
$tec = $_REQUEST["tec"];
$query = mysqli_query($c, "SELECT Curso FROM aluno where Matricula like '%$tec%'") or die("erro ao selecionar");
$row = mysqli_fetch_assoc($query);
echo $row['Curso'];

?>
