<?php
// Array with names
include_once("dbfunctions.php");
include_once("conection.php");

$name = $_REQUEST["name"];

if ($name !== "") {
    $query = mysqli_query($c, "SELECT Cnpj FROM empresa WHERE Nome = '$name'") or die("erro ao selecionar");
    $row = mysqli_fetch_assoc($query);
    
    echo $row["Cnpj"];

}

?>
