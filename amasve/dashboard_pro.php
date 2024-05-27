<?php

session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'pro') {
  // El usuario no está autenticado o no tiene el rol correcto
  header('Location: login.php');
  exit;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pro</title>
  <style>
    html {
        background-color: lightcoral;
    }
  </style>
</head>
<body>
  <h1>Bienvenido al dashboard usuario Pro</h1>
  <p>Opciones:</p>
  <a href="cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>