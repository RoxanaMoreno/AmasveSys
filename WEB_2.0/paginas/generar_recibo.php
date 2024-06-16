<?php
include '../lib/conexion_db.php';

// Obtener el ID de la aportación desde la URL
$id_aportacion = $_GET['id_aportacion'];

// Obtener los datos de la aportación para el recibo
$query_aportacion = "SELECT monto, fecha, descripcion FROM aportaciones WHERE id = ?";
$stmt_aportacion = $conexion->prepare($query_aportacion);
$stmt_aportacion->bind_param('i', $id_aportacion);
$stmt_aportacion->execute();
$result_aportacion = $stmt_aportacion->get_result();

if ($result_aportacion->num_rows === 0) {
    // Manejo de caso cuando no se encuentra la aportación
    echo "Aportación no encontrada.";
    exit;
}

$aportacion = $result_aportacion->fetch_assoc();

// Insertar el nuevo recibo en la base de datos
$query_insert_recibo = "INSERT INTO recibos (fecha, monto, detalles) VALUES (?, ?, ?)";
$stmt_insert_recibo = $conexion->prepare($query_insert_recibo);
$stmt_insert_recibo->bind_param('sds', $aportacion['fecha'], $aportacion['monto'], $aportacion['descripcion']);
$stmt_insert_recibo->execute();

if ($stmt_insert_recibo->affected_rows === 1) {
    // Obtener el ID del recibo generado
    $id_recibo = $stmt_insert_recibo->insert_id;

    // Actualizar la aportación con el ID del recibo generado
    $query_update_aportacion = "UPDATE aportaciones SET id_recibo = ? WHERE id = ?";
    $stmt_update_aportacion = $conexion->prepare($query_update_aportacion);
    $stmt_update_aportacion->bind_param('ii', $id_recibo, $id_aportacion);
    $stmt_update_aportacion->execute();

    header('Location: ver_recibo.php?id_recibo=' . $id_recibo);
    exit;
} else {
    echo "Error al generar el recibo.";
    exit;
}
?>
