<?php
// Array with names
include_once("dbfunctions.php");
include_once("conection.php");

$cnpj = $_REQUEST["cnpj"];

if ($cnpj !== "") {
    $query = mysqli_query($c, "SELECT Nome FROM empresa WHERE Cnpj = '$cnpj'") or die("erro ao selecionar");
    $row = mysqli_fetch_assoc($query);
    
    echo $row["Nome"];

}

?>
