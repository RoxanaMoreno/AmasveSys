<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

// Verificar si se recibieron los parámetros necesarios
if (!isset($_GET['id_voluntario']) || !isset($_GET['id_evento'])) {
    echo "Parámetros incompletos.";
    exit;
}

$id_voluntario = $_GET['id_voluntario'];
$id_evento = $_GET['id_evento'];

// Verificar si el voluntario está realmente asignado al evento antes de eliminar
$stmt_check = $conexion->prepare("SELECT evento_id, voluntario_id FROM voluntarios_eventos WHERE evento_id = ? AND voluntario_id = ?");
if ($stmt_check === false) {
    die('Error en la consulta SQL para verificar relación: ' . $conexion->error);
}

$stmt_check->bind_param('ii', $id_evento, $id_voluntario);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    echo "El voluntario no está asignado a este evento.";
    exit;
}

// Eliminar la relación voluntario-evento
$stmt_delete = $conexion->prepare("DELETE FROM voluntarios_eventos WHERE evento_id = ? AND voluntario_id = ?");
if ($stmt_delete === false) {
    die('Error en la consulta SQL para eliminar relación: ' . $conexion->error);
}

$stmt_delete->bind_param('ii', $id_evento, $id_voluntario);
if ($stmt_delete->execute()) {
    echo "Voluntario eliminado del evento correctamente.";
} else {
    echo "Error al eliminar voluntario del evento: " . $stmt_delete->error;
}

?>
