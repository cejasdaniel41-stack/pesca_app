<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $video_url = $conexion->real_escape_string($_POST['video_url'] ?? '');

    // Procesar imagen subida (si hay)
    if (!empty($_FILES['imagen']['name'])) {
        $target_dir = "uploads/lineas/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        // Generar nombre único para evitar sobreescritura
        $ext = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('img_').'.'.$ext;
        $target_file = $target_dir . $nombreArchivo;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen_url = $conexion->real_escape_string($target_file);
        } else {
            $imagen_url = '';
            echo "<p style='color:red;'>Error al subir la imagen.</p>";
        }
    } else {
        // Si no subieron archivo, tomar URL manual
        $imagen_url = $conexion->real_escape_string($_POST['imagen_url'] ?? '');
    }

    $sql = "INSERT INTO lineas_pesca (nombre, descripcion, imagen_url, video_url) 
            VALUES ('$nombre', '$descripcion', '$imagen_url', '$video_url')";
    if ($conexion->query($sql)) {
        header('Location: ver_lineas.php');
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . htmlspecialchars($conexion->error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agregar Línea de Pesca - Taller de Pesca</title>
  <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
  <header>
    <h1>Agregar Línea de Pesca</h1>
    <nav>
      <a href="ver_lineas.php" class="btn">Volver a Líneas de Pesca</a>
      <a href="taller.php" class="btn">Volver al Taller</a>
    </nav>
  </header>

  <main style="max-width: 600px; margin: 20px auto;">
    <form method="post" enctype="multipart/form-data" class="formulario">
      <label for="nombre">Nombre:</label><br />
      <input type="text" id="nombre" name="nombre" required /><br /><br />

      <label for="descripcion">Descripción:</label><br />
      <textarea id="descripcion" name="descripcion" rows="5" required></textarea><br /><br />

      <label for="imagen">Imagen (archivo):</label><br />
      <input type="file" id="imagen" name="imagen" accept="image/*" /><br /><br />

      <label for="imagen_url">O URL de imagen (opcional):</label><br />
      <input type="text" id="imagen_url" name="imagen_url" /><br /><br />

      <label for="video_url">URL video YouTube (opcional):</label><br />
      <input type="url" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=..." /><br /><br />

      <button type="submit" class="btn">Guardar</button>
    </form>
  </main>
</body>
</html>
