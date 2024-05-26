<?php

session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'voluntario1') {
  // El usuario no está autenticado o no tiene el rol correcto
  header('Location: login.php');
  exit;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Voluntario 1</title>
  <style>
    html {
        background-color: lightcoral;
    }
  </style>
</head>
<body>
  <h1>Bienvenido al dashboard de Vluntario nivel1</h1>
  <p>Opciones:</p>
  <a href="cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>