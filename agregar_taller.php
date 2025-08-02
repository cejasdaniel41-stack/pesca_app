<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'] ?? 1; // Ajustar según login real
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);

    $sql = "INSERT INTO taller (usuario_id, titulo, descripcion) VALUES ('$usuario_id', '$titulo', '$descripcion')";
    if ($conexion->query($sql)) {
        $id = $conexion->insert_id;
        header("Location: ver_taller.php?id=$id");
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<form method="post">
  <label>Título de la guía:</label><br>
  <input type="text" name="titulo" required><br><br>

  <label>Descripción:</label><br>
  <textarea name="descripcion" required></textarea><br><br>

  <button type="submit">Crear Guía</button>
</form>
