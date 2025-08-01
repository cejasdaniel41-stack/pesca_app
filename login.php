<?php
session_start();
include 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "❌ Contraseña incorrecta";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pesca San Luis</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <header class="header">
    <h1>Iniciar Sesión</h1>
  </header>

  <div class="container">
    <form method="POST">
      <input type="email" name="email" placeholder="Correo electrónico" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Ingresar</button>
    </form>
    <?php if($mensaje) echo "<p style='color:red'>$mensaje</p>"; ?>
    <a href="registro.php" class="btn">Crear Cuenta</a>
  </div>
</body>
</html>
