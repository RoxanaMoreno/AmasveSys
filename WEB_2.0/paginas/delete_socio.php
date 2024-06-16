<?php
session_start();

// Verificar sesión de administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $socio_numero = $_GET['id'];

    // Preparar la consulta para eliminar el socio
    $query = "DELETE FROM socios WHERE socio_numero = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $socio_numero);

    if ($stmt->execute()) {
        // Eliminación exitosa
        echo "Socio eliminado exitosamente.";
    } else {
        // Error en la eliminación
        echo "Error al eliminar el socio.";
    }

    $stmt->close();
} else {
    // Error: No se proporcionó un ID válido
    echo "No se proporcionó un ID de socio válido para eliminar.";
}

$conexion->close();
?>

<!-- Redireccionar automáticamente a la página de socios después de 2 segundos -->
<script>
setTimeout(function() {
    window.location.href = 'socios.php';
}, 2000); // 2000 milisegundos = 2 segundos
</script>
