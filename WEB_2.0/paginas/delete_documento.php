<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_documento = $_GET['id'];

// Obtener el ID del beneficiario para redirigir después de eliminar el documento
$query_beneficiario_id = "SELECT beneficiario_id FROM documentos WHERE id = ?";
$stmt_beneficiario_id = $conexion->prepare($query_beneficiario_id);
$stmt_beneficiario_id->bind_param('i', $id_documento);
$stmt_beneficiario_id->execute();
$result_beneficiario_id = $stmt_beneficiario_id->get_result();

if ($result_beneficiario_id->num_rows === 0) {
    echo "Documento no encontrado.";
    exit;
}

$beneficiario_id = $result_beneficiario_id->fetch_assoc()['beneficiario_id'];

// Eliminar el documento de la base de datos
$query_delete = "DELETE FROM documentos WHERE id = ?";
$stmt_delete = $conexion->prepare($query_delete);
$stmt_delete->bind_param('i', $id_documento);

if ($stmt_delete->execute()) {
    $success_message = "Documento eliminado correctamente.";
} else {
    $error_message = "Error al eliminar el documento: " . $stmt_delete->error;
}

header("Location: ver_documentos.php?id_beneficiario=$beneficiario_id");
exit;
?>
