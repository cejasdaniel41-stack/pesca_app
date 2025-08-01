<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $latitud = $_POST['latitud'] ?? '';
    $longitud = $_POST['longitud'] ?? '';
    $fecha = date("Y-m-d H:i:s");

    if (isset($_FILES['foto'])) {
        $carpeta = "uploads/";
        if (!file_exists($carpeta)) mkdir($carpeta, 0777, true);

        $nombreFoto = time() . "_" . basename($_FILES['foto']['name']);
        $ruta = $carpeta . $nombreFoto;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
            $sql = "INSERT INTO capturas (usuario, foto, latitud, longitud, fecha) 
                    VALUES ('$usuario', '$ruta', '$latitud', '$longitud', '$fecha')";
            if ($conexion->query($sql)) {
                echo json_encode(["status" => "ok", "mensaje" => "Captura guardada"]);
            } else {
                echo json_encode(["status" => "error", "mensaje" => $conexion->error]);
            }
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Error al subir la foto"]);
        }
    } else {
        echo json_encode(["status" => "error", "mensaje" => "No se recibió ninguna foto"]);
    }
} else {
    echo json_encode(["status" => "error", "mensaje" => "Método no permitido"]);
}
?>
