<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

// Obtener el nombre del usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

$id_evento = $_GET['id'] ?? null;

if ($id_evento) {
    $query = "DELETE FROM eventos WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_evento);
    $stmt->execute();
    $stmt->close();
}
?>

<div>
    <p>Evento eliminado correctamente.</p>
    <button class="btn btn-secondary" onclick="loadContent('eventos.php')">Volver</button>
</div>

<?php
$conexion->close();
?>
