<?php
$host = "localhost";
$user = "root"; // tu usuario de MySQL
$pass = ""; // tu contraseña de MySQL
$db = "pesca_db"; // nombre de la base de datos

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
