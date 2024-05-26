<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
  // El usuario no está autenticado o no tiene el rol correcto
  header('Location: login.php');
  exit;
}
// NUEVO
// Obtener el nombre del usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <style>
    body {
      background-color: lightblue;
    }
    .navbar-brand img {
      height: 40px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="./images/amasvesys.png" alt="Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Voluntarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Socios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Beneficiarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Vistas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Consultas</a>
          </li>
        </ul>
        <a class="btn btn-outline-danger" href="cerrar_sesion.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <h3>Bienvenido al dashboard <?php echo htmlspecialchars($nombre_usuario); ?></h3>
  </div>

 
</body>
</html>
