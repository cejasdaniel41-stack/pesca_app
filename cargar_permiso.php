<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";
$ruta_pdf = "";

// Buscar permiso ya cargado
$query = $conexion->prepare("SELECT archivo_pdf FROM permisos_pesca WHERE usuario_id = ?");
$query->bind_param("i", $usuario_id);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    $ruta_pdf = $row['archivo_pdf'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['permiso']['name'])) {
        $archivo = $_FILES['permiso'];

        if ($archivo['type'] !== 'application/pdf') {
            $mensaje = "<p style='color:red;'>❌ Solo se permiten archivos PDF.</p>";
        } else {
            $target_dir = "uploads/permisos/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $nombreArchivo = uniqid("permiso_") . ".pdf";
            $target_file = $target_dir . $nombreArchivo;

            if (move_uploaded_file($archivo['tmp_name'], $target_file)) {
                $check = $conexion->prepare("SELECT id FROM permisos_pesca WHERE usuario_id = ?");
                $check->bind_param("i", $usuario_id);
                $check->execute();
                $checkResult = $check->get_result();

                if ($checkResult->num_rows > 0) {
                    $sql = $conexion->prepare("UPDATE permisos_pesca SET archivo_pdf = ?, fecha_subida = NOW() WHERE usuario_id = ?");
                    $sql->bind_param("si", $target_file, $usuario_id);
                } else {
                    $sql = $conexion->prepare("INSERT INTO permisos_pesca (usuario_id, archivo_pdf) VALUES (?, ?)");
                    $sql->bind_param("is", $usuario_id, $target_file);
                }

                if ($sql->execute()) {
                    $mensaje = "<p style='color:green;'>✅ Permiso cargado correctamente.</p>";
                    $ruta_pdf = $target_file;
                } else {
                    $mensaje = "<p style='color:red;'>❌ Error al guardar en la base de datos.</p>";
                }
            } else {
                $mensaje = "<p style='color:red;'>❌ Error al subir el archivo.</p>";
            }
        }
    } else {
        $mensaje = "<p style='color:red;'>⚠️ Seleccioná un archivo PDF.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cargar Permiso de Pesca</title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    embed {
      width: 100%;
      height: 600px;
      border: 1px solid #ccc;
      margin-top: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <header>
    <h1>Permiso de Pesca Anual</h1>
    <nav>
      <a href="index.php" class="btn">🏠 Volver al Inicio</a>
    </nav>
  </header>

  <main class="container">
    <?= $mensaje ?>

    <form method="post" enctype="multipart/form-data">
      <label for="permiso">Subir permiso (PDF):</label><br>
      <input type="file" name="permiso" id="permiso" accept="application/pdf" required><br><br>
      <button type="submit" class="btn btn-pequeño">📄 Cargar Permiso</button>
    </form>

    <?php if ($ruta_pdf): ?>
      <h3>📄 Tu permiso cargado:</h3>
      <embed src="<?= htmlspecialchars($ruta_pdf) ?>" type="application/pdf">
    <?php else: ?>
      <p style="color:#666;">📌 Aún no has cargado tu permiso.</p>
    <?php endif; ?>
  </main>
</body>
</html>
