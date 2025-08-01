<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $peso_promedio = $_POST['peso_promedio'];
    $cantidad = $_POST['cantidad'];
    $foto = "";

    // Subida de foto
    if (!empty($_FILES['foto']['name'])) {
        $nombreArchivo = time() . "_" . basename($_FILES['foto']['name']);
        $rutaDestino = "uploads/" . $nombreArchivo;

        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
            $foto = $rutaDestino;
        }
    }

    $stmt = $conexion->prepare("INSERT INTO salidas (usuario_id, lugar_id, fecha, hora, cantidad_pejerreyes, tamanio_promedio, foto) 
                                VALUES (?, NULL, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issids", $usuario_id, $fecha, $hora, $cantidad, $peso_promedio, $foto);

    if ($stmt->execute()) {
        $mensaje = "✅ Salida registrada con éxito";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Salida - Pesca San Luis</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <header class="header">
    <h1>Agregar Salida de Pesca</h1>
  </header>

  <div class="container">
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="lugar" placeholder="Lugar de pesca" required>
      <input type="date" name="fecha" required>
      <input type="time" name="hora" required>
      <input type="number" step="0.01" name="peso_promedio" placeholder="Peso promedio (kg)" required>
      <input type="number" name="cantidad" placeholder="Cantidad de pejerreyes" required>
      <input type="file" name="foto" accept="image/*">
      <button type="submit">Guardar Salida</button>
    </form>
    <?php if($mensaje) echo "<p style='color:green'>$mensaje</p>"; ?>
  </div>
</body>
</html>
