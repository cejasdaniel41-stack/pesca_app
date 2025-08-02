<?php
session_start();
include 'conexion.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) die('ID inválido');

$linea = $conexion->query("SELECT * FROM lineas_pesca WHERE id = $id")->fetch_assoc();
if (!$linea) die('Línea no encontrada');
?>

<h2><?=htmlspecialchars($linea['nombre'])?></h2>
<p><?=nl2br(htmlspecialchars($linea['descripcion']))?></p>

<?php if ($linea['imagen_url']): ?>
  <img src="<?=htmlspecialchars($linea['imagen_url'])?>" alt="Imagen" style="max-width:400px;">
<?php endif; ?>

<p><a href="ver_lineas.php">Volver a la lista</a></p>
