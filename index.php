<?php
session_start();
include 'conexion.php';

$query = "SELECT s.*, u.email 
          FROM salidas s 
          JOIN usuarios u ON s.usuario_id = u.id 
          ORDER BY s.fecha DESC, s.hora DESC";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salidas de Pesca - Pesca San Luis</title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    .card {
      max-width: 400px;
      margin: 15px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      padding: 15px;
      text-align: left;
    }
    .card img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .card h3 {
      margin: 5px 0;
      color: #0277bd;
    }
    .info {
      font-size: 14px;
      color: #333;
    }
  </style>
</head>
<body>
  <header class="header">
    <h1>Salidas de Pesca</h1>
  </header>

  <div style="text-align:center; margin:15px;">
    <a href="agregar_salida.php" class="btn">➕ Agregar Salida</a>
  </div>

  <?php if ($resultado->num_rows === 0): ?>
      <p style="text-align:center; color:#555;">📭 No hay salidas registradas aún.</p>
  <?php else: ?>
      <?php while($fila = $resultado->fetch_assoc()) { ?>
        <div class="card">
          <?php if($fila['foto']) { ?>
            <img src="<?php echo $fila['foto']; ?>" alt="Foto de pesca">
          <?php } ?>

          <h3><?php echo htmlspecialchars($fila['email']); ?></h3>
          <p class="info">
            📍 Lugar: <?php echo htmlspecialchars($fila['lugar']); ?><br>
            📅 Fecha: <?php echo $fila['fecha']; ?> ⏰ <?php echo $fila['hora']; ?><br>
            🎣 Cantidad: <?php echo $fila['cantidad_pejerreyes']; ?><br>
            ⚖️ Peso Promedio: <?php echo $fila['tamanio_promedio']; ?> kg
          </p>
          <button class="btn">⭐ Puntuar</button>
        </div>
      <?php } ?>
  <?php endif; ?>
</body>
</html>
