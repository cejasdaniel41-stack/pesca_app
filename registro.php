<?php
include 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $nombre = explode("@", $email)[0]; // Se usa la parte antes de @ como nombre
    $stmt->bind_param("sss", $nombre, $email, $password);

    if ($stmt->execute()) {
        $mensaje = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
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
  <title>Registro - Pesca San Luis</title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    .form-container {
      max-width: 350px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    input[type="email"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #0288d1;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #01579b;
    }
    .mensaje {
      text-align: center;
      margin-top: 10px;
      color: green;
    }
  </style>
</head>
<body>
  <header class="header">
    <h1>Registro</h1>
  </header>

  <div class="form-container">
    <form method="POST">
      <input type="email" name="email" placeholder="Correo electrónico" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Registrarse</button>
    </form>
    <?php if($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>
  </div>
</body>
</html>
