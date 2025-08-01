<?php
$host = "nozomi.proxy.rlwy.net";
$usuario = "root";
$password = "qbFCEMSZrUVkuJHoQzAnDZQMvaNBvAuA";
$bd = "railway";
$puerto = 55292; // Ej: 3306

$conexion = new mysqli($host, $usuario, $password, $bd, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
