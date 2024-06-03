<?php

session_start();


// Destruir la sesión
// Session_destroy() elimina todas las variables de sesión y termina la sesión por completo
session_destroy();

// Redirigir a la página de login
header('Location: ../index.php');

?>
