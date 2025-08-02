<?php
session_start();
include 'conexion.php';

$result = $conexion->query("SELECT * FROM lineas_pesca ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Líneas de Pesca - Taller de Pesca</title>
  <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
  <header>
    <h1>Líneas de Pesca</h1>
    <nav>
      <a href="taller.php" class="btn">Volver al Taller</a>
      <a href="agregar_linea_pesca.php" class="btn">Agregar Nueva Línea</a>
    </nav>
  </header>

  <?php if ($result->num_rows === 0): ?>
    <p>No hay líneas de pesca registradas aún.</p>
  <?php else: ?>
    <table class="tabla">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($linea = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($linea['nombre']) ?></td>
            <td>
              <?php if ($linea['imagen_url']): ?>
                <img src="<?= htmlspecialchars($linea['imagen_url']) ?>" alt="Imagen de <?= htmlspecialchars($linea['nombre']) ?>" class="imagen-linea" />
              <?php else: ?>
                Sin imagen
              <?php endif; ?>
            </td>
            <td>
              <a href="ver_linea.php?id=<?= $linea['id'] ?>">Ver</a> |
              <a href="editar_linea_pesca.php?id=<?= $linea['id'] ?>">Editar</a> |
              <a href="eliminar_linea_pesca.php?id=<?= $linea['id'] ?>" onclick="return confirm('¿Eliminar esta línea?')">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
