<?php
include 'funciones_hashing.php';
require 'conexion_db.php';

$nombre_usuario = $_POST['nombre_usuario'];
$contrasena_ingresada = $_POST['contrasena'];
$ip_address = $_SERVER['REMOTE_ADDR']; // Obtener la dirección IP del usuario

// Tiempo límite en minutos
$time_limit = 10; 
// Número máximo de intentos permitidos
$max_attempts = 3; 

// Inicializar la respuesta por defecto
$response = array('credencialesValidas' => false);

// Limpiar intentos antiguos
$sql = "DELETE FROM login_attempts WHERE attempt_time < (NOW() - INTERVAL ? MINUTE)";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'i', $time_limit);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Contar intentos recientes
$sql = "SELECT COUNT(*) AS attempts FROM login_attempts WHERE nombre_usuario = ? AND ip_address = ? AND attempt_time >= (NOW() - INTERVAL ? MINUTE)";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'ssi', $nombre_usuario, $ip_address, $time_limit);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $attempts);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($attempts >= $max_attempts) {
    // Demasiados intentos
    $response['error'] = 'Demasiados intentos fallidos. Inténtalo más tarde.';
} else {
    // Recuperar el usuario rol y hash de la contraseña del usuario de la base de datos
    $sql = "SELECT id_usuario, rol, contrasena, nombre_usuario FROM usuarios WHERE nombre_usuario = ?";
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $nombre_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) == 1) {
            $row = mysqli_fetch_assoc($resultado);
            $contrasena = $row['contrasena'];

            if (verifyPassword($contrasena_ingresada, $contrasena)) {
                session_start();
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['rol'] = $row['rol'];
                // NUEVO Guardar nombre de usuario en la sesión
                $_SESSION['nombre_usuario'] = $row['nombre_usuario']; 

                $response['credencialesValidas'] = true;
                $response['rol'] = $row['rol'];
            } else {
                // Registrar intento fallido
                $sql = "INSERT INTO login_attempts (nombre_usuario, ip_address) VALUES (?, ?)";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, 'ss', $nombre_usuario, $ip_address);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        } else {
            // Registrar intento fallido
            $sql = "INSERT INTO login_attempts (nombre_usuario, ip_address) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, 'ss', $nombre_usuario, $ip_address);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conexion);

header('Content-Type: application/json');
echo json_encode($response);
?>
