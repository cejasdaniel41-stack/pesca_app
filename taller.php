<?php
session_start();
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Taller de Pesca</title>
  <link rel="stylesheet" href="css/estilos.css" />
  <style>
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
  </style>
</head>
<body>
  <header>
    <h1>Taller de Pesca</h1>
    <nav class="menu">
      <a href="ver_lineas.php">Ver Líneas de Pesca</a>
      <a href="agregar_linea_pesca.php">Agregar Línea de Pesca</a>
      <a href="agregar_taller.php">Agregar Guía de Pesca</a>
      <a href="ver_taller.php">Ver Guías de Pesca</a>
      <a href="index.php">Volver al Inicio</a>
    </nav>
  </header>

  <main style="text-align:center; margin-top: 40px;">
    <p>Bienvenido al Taller de Pesca. Desde aquí podés gestionar las guías y tipos de líneas de pesca.</p>
  </main>
</body>
</html>
