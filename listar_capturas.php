<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$resultado = $conexion->query("SELECT * FROM capturas ORDER BY fecha DESC");
$datos = [];

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
?>
