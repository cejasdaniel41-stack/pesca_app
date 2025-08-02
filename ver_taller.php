<?php
session_start();
include 'conexion.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("ID de guía inválido");
}

// Obtener guía
$guia = $conexion->query("SELECT * FROM taller WHERE id = $id")->fetch_assoc();
if (!$guia) {
    die("Guía no encontrada");
}

// Función recursiva para mostrar líneas anidadas
function mostrarLineas($conexion, $taller_id, $padre_id = null, $nivel = 0) {
    $padreCond = is_null($padre_id) ? "IS NULL" : "= $padre_id";
    $result = $conexion->query("SELECT * FROM lineas_taller WHERE taller_id = $taller_id AND padre_id $padreCond ORDER BY orden");

    echo "<ul style='margin-left: " . ($nivel * 20) . "px'>";
    while ($linea = $result->fetch_assoc()) {
        echo "<li>";
        echo "<b>" . htmlspecialchars($linea['titulo']) . "</b> ";
        echo "<a href='agregar_linea.php?taller_id=$taller_id&padre_id=" . $linea['id'] . "'>[Agregar Sub-línea]</a> ";
        echo "<a href='editar_linea.php?id=" . $linea['id'] . "'>[Editar]</a> ";
        echo "<a href='eliminar_linea.php?id=" . $linea['id'] . "' onclick='return confirm(\"Seguro?\")'>[Eliminar]</a>";

        // Mostrar sublíneas recursivamente
        mostrarLineas($conexion, $taller_id, $linea['id'], $nivel + 1);
        echo "</li>";
    }
    echo "</ul>";
}

?>

<h2><?=htmlspecialchars($guia['titulo'])?></h2>
<p><?=nl2br(htmlspecialchars($guia['descripcion']))?></p>

<a href="agregar_linea.php?taller_id=<?=$guia['id']?>">[Agregar Línea Principal]</a>

<?php mostrarLineas($conexion, $guia['id']); ?>
