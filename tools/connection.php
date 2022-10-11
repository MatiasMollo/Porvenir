<?php

$host = "localhost";
$dbName = "porvenir";
$user = "root";
$password = "";

/*
$conn = mysqli_connect($host,$user,$password,$dbName);
if(mysqli_connect_errno()){
  echo "No se pudo conectar a la db: " . mysqli_connect_error();
}*/

/*
$conn = new mysqli($host,$user,$password,$dbName);

if($conn->connect_errno){
  echo "No se pudo conectar a la base de datos: " . $conn->connect_error;
}*/


try{
  $conn = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //Atributos para errores
}
catch(PDOException $e){
  echo "Conexion Fallida" . $e->getMessage();
}





?>
