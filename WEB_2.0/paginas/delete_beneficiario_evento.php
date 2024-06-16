<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

// Obtener los IDs desde la URL
if (!isset($_GET['id_evento']) || !isset($_GET['beneficiario_id'])) {
    echo "ID de evento o de beneficiario no proporcionado.";
    exit;
}

$id_evento = $_GET['id_evento'];
$beneficiario_id = $_GET['beneficiario_id'];

// Eliminar la relación del beneficiario con el evento
$stmt = $conexion->prepare("DELETE FROM beneficiarios_eventos WHERE evento_id = ? AND beneficiario_id = ?");
if ($stmt === false) {
    die('Error en la consulta SQL para eliminar beneficiario del evento: ' . $conexion->error);
}
$stmt->bind_param('ii', $id_evento, $beneficiario_id);
if ($stmt->execute()) {
    echo "Beneficiario eliminado del evento con éxito.";
} else {
    echo "Error al eliminar el beneficiario del evento: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Beneficiario del Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h3>Beneficiario eliminado del evento</h3>
        <button class="btn btn-secondary mt-3" onclick="loadContent('eventos.php')">Volver a Eventos</button>
    </div>
</body>
</html>
