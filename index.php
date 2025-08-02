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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Salidas de Pesca - Pesca San Luis</title>
  <link rel="stylesheet" href="css/estilos.css" />
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
    .menu {
      text-align: center;
      margin: 20px 0;
    }
    .menu a {
      margin: 0 10px;
      padding: 8px 15px;
      background: #0277bd;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .menu a:hover {
      background: #015a8a;
    }
    .btn {
      background-color: #0277bd;
      border: none;
      color: white;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
    }
    .btn:hover {
      background-color: #015a8a;
    }
    .permisos {
      margin-top: 20px;
      text-align: center;
    }
    .permisos h3 {
      color: #0277bd;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <header class="header">
    <h1>Salidas de Pesca</h1>
    <nav class="menu">
      <a href="ver_lineas.php">Líneas de Pesca</a>
      <a href="taller.php">Taller de Pesca</a>
      <a href="agregar_salida.php">Agregar Salida</a>
    </nav>
  </header>

  <div class="permisos">
    <h3>🎫 Permisos</h3>
    <a href="https://permisosdepesca.sanluis.gov.ar/login" target="_blank" class="btn">📄 Sacar Permiso de Pesca</a>
    <a href="cargar_permiso.php" class="btn">👀 Ver / Cargar Permiso Anual</a>
  </div>

  <?php if ($resultado->num_rows === 0): ?>
    <p style="text-align:center; color:#555;">📭 No hay salidas registradas aún.</p>
  <?php else: ?>
    <?php while($fila = $resultado->fetch_assoc()) { ?>
      <div class="card">
        <?php if(!empty($fila['foto'])) { ?>
          <img src="<?= htmlspecialchars($fila['foto']) ?>" alt="Foto de pesca" />
        <?php } ?>

        <h3><?= htmlspecialchars($fila['email']) ?></h3>
        <p class="info">
          📍 Lugar: <?= htmlspecialchars($fila['lugar']) ?><br />
          📅 Fecha: <?= htmlspecialchars($fila['fecha']) ?> ⏰ <?= htmlspecialchars($fila['hora']) ?><br />
          🎣 Cantidad: <?= htmlspecialchars($fila['cantidad_pejerreyes']) ?><br />
          ⚖️ Peso Promedio: <?= htmlspecialchars($fila['tamanio_promedio']) ?> kg
        </p>
        <button class="btn">⭐ Puntuar</button>
      </div>
    <?php } ?>
  <?php endif; ?>
</body>
</html>
