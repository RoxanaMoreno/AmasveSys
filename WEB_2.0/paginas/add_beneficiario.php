<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $documento_identidad = $_POST['documento_identidad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $miembros_unidad_familiar_0_2 = $_POST['miembros_unidad_familiar_0_2'];
    $miembros_otras_edades = $_POST['miembros_otras_edades'];
    $miembros_con_discapacidad = $_POST['miembros_con_discapacidad'];
    $fecha_registro = $_POST['fecha_registro'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $query = "INSERT INTO beneficiarios (nombre, apellidos, documento_identidad, direccion, telefono, email, miembros_unidad_familiar_0_2, miembros_otras_edades, miembros_con_discapacidad, fecha_registro, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssssssiiiis', $nombre, $apellidos, $documento_identidad, $direccion, $telefono, $email, $miembros_unidad_familiar_0_2, $miembros_otras_edades, $miembros_con_discapacidad, $fecha_registro, $activo);
    if ($stmt->execute()) {
        echo "Beneficiario añadido correctamente.";
    } else {
        echo "Error al añadir el beneficiario: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
    exit;
}
?>

<div class="container mt-4">
    <h3>Añadir Beneficiario</h3>
    <form id="addBeneficiarioForm" action="add_beneficiario.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="mb-3">
            <label for="documento_identidad" class="form-label">Documento de Identidad</label>
            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="miembros_unidad_familiar_0_2" class="form-label">Miembros de la Unidad Familiar (0-2 años)</label>
            <input type="number" class="form-control" id="miembros_unidad_familiar_0_2" name="miembros_unidad_familiar_0_2" min="0">
        </div>
        <div class="mb-3">
            <label for="miembros_otras_edades" class="form-label">Miembros de Otras Edades</label>
            <input type="number" class="form-control" id="miembros_otras_edades" name="miembros_otras_edades" min="0">
        </div>
        <div class="mb-3">
            <label for="miembros_con_discapacidad" class="form-label">Miembros con Discapacidad</label>
            <input type="number" class="form-control" id="miembros_con_discapacidad" name="miembros_con_discapacidad" min="0">
        </div>
        <div class="mb-3">
            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="activo" name="activo">
            <label class="form-check-label" for="activo">Activo</label>
        </div>
        <button type="submit" class="btn btn-primary">Añadir Beneficiario</button>
    </form>
</div>
