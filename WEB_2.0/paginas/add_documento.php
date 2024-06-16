<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_beneficiario = $_GET['id_beneficiario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['documento'])) {
    $tipo_documento = $_POST['tipo_documento'];
    $fecha_subida = date('Y-m-d');
    $ruta_documento = ''; // La ruta se asignará después de subir el archivo

    // Directorio donde se guardarán los documentos
    $upload_dir = '../documentos/';

    // Generar un nombre único para el archivo
    $nombre_archivo = uniqid() . '_' . basename($_FILES['documento']['name']);
    $ruta_documento = $upload_dir . $nombre_archivo;

    // Subir el archivo al directorio de documentos
    if (move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_documento)) {
        // Insertar datos en la tabla documentos
        $query = "INSERT INTO documentos (ruta_documento, tipo_documento, fecha_subida, beneficiario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssi', $ruta_documento, $tipo_documento, $fecha_subida, $id_beneficiario);

        if ($stmt->execute()) {
            $success_message = "Documento subido correctamente.";
        } else {
            $error_message = "Error al subir el documento: " . $stmt->error;
        }
    } else {
        $error_message = "Error al subir el archivo. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Documento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Agregar Documento para Beneficiario ID: <?php echo $id_beneficiario; ?></h2>

        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="add_documento.php?id_beneficiario=<?php echo $id_beneficiario; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento:</label>
                <input type="text" class="form-control" id="tipo_documento" name="tipo_documento" required>
            </div>
            <div class="form-group">
                <label for="documento">Seleccionar Archivo:</label>
                <input type="file" class="form-control-file" id="documento" name="documento" accept=".pdf,.doc,.docx" required>
            </div>
            <button type="submit" class="btn btn-primary">Subir Documento</button>
        </form>
    </div>
</body>
</html>
