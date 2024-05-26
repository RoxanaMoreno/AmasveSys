<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'amasve');

$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conexion) {
  die('Error de conexión a la base de datos: ' . mysqli_connect_error());
}
