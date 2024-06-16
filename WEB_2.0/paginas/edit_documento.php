<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_documento = $_GET['id'];

// Manejar la actualización del tipo de documento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_documento = $_POST['tipo_documento'];

    // Actualizar el tipo de documento en la base de datos
    $query = "UPDATE documentos SET tipo_documento = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('si', $tipo_documento, $id_documento);

    if ($stmt->execute()) {
        $success_message = "Tipo de documento actualizado correctamente.";
    } else {
        $error_message = "Error al actualizar el tipo de documento: " . $stmt->error;
    }

    // Manejar la actualización del archivo adjunto (si es necesario)
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        $documento = $_FILES['documento'];

        // Verificar y mover el archivo subido
        $nombre_archivo = $documento['name'];
        $tipo_archivo = $documento['type'];
        $tamano_archivo = $documento['size'];
        $archivo_temporal = $documento['tmp_name'];

        $ruta_destino = '../documentos/';
        $ruta_archivo = $ruta_destino . uniqid() . '_' . basename($nombre_archivo);

        if (!file_exists($ruta_destino)) {
            mkdir($ruta_destino, 0777, true); // Crear el directorio si no existe
        }

        if (move_uploaded_file($archivo_temporal, $ruta_archivo)) {
            // Actualizar la ruta del documento en la base de datos
            $query_update_archivo = "UPDATE documentos SET ruta_documento = ? WHERE id = ?";
            $stmt_update_archivo = $conexion->prepare($query_update_archivo);
            $stmt_update_archivo->bind_param('si', $ruta_archivo, $id_documento);

            if ($stmt_update_archivo->execute()) {
                $success_message .= " Archivo actualizado correctamente.";
            } else {
                $error_message = "Error al actualizar el archivo: " . $stmt_update_archivo->error;
            }
        } else {
            $error_message = "Error al subir el archivo.";
        }
    }
}

// Obtener los datos actuales del documento
$query_documento = "SELECT id, ruta_documento, tipo_documento, fecha_subida, beneficiario_id FROM documentos WHERE id = ?";
$stmt_documento = $conexion->prepare($query_documento);
$stmt_documento->bind_param('i', $id_documento);
$stmt_documento->execute();
$result_documento = $stmt_documento->get_result();

if ($result_documento->num_rows === 0) {
    echo "Documento no encontrado.";
    exit;
}

$documento = $result_documento->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Documento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Documento ID: <?php echo $id_documento; ?></h2>

        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="edit_documento.php?id=<?php echo $id_documento; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento:</label>
                <input type="text" class="form-control" id="tipo_documento" name="tipo_documento" value="<?php echo htmlspecialchars($documento['tipo_documento']); ?>" required>
            </div>
            <div class="form-group">
                <label for="documento">Seleccionar Nuevo Archivo:</label>
                <input type="file" class="form-control-file" id="documento" name="documento">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Documento</button>
        </form>
    </div>
</body>
</html>
