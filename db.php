<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; 
$db   = "taller_db";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>