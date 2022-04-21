<?php 

require 'includes/config/database.php';
$db = conectDB();

//Crear Usuario 
$nombre = "Edmundo"; 
$apellido = "Ramirez"; 
$email = "admin@admin.com"; 
$password = "admin@12345"; 
$telefono = "33-39-99-52-36";

$passwordHash = password_hash($password, PASSWORD_DEFAULT); 


$queryInsert = "INSERT INTO usuarios (nombre, apellido, email, password, telefono) 
                VALUES( '${nombre}', '${apellido}', '${email}', '${passwordHash}', '${telefono}')";

echo $queryInsert;                

mysqli_query($db, $queryInsert);                 