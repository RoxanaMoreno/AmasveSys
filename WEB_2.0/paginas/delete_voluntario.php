<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar voluntario
    $query = "DELETE FROM voluntarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Eliminación exitosa
        echo "Voluntario eliminado exitosamente.";
    } else {
        // Error en la eliminación
        echo "Error al eliminar el voluntario.";
    }

    $stmt->close();
}

$conexion->close();
?>

<script>
loadContent('voluntarios.php');
</script>
