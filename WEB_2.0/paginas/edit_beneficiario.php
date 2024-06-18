<?php
session_start();

// Verificar que el usuario esté autenticado y tenga el rol de administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

// Obtener el ID del beneficiario a editar
$id_beneficiario = $_GET['id'] ?? null;

if ($id_beneficiario === null) {
    echo "ID de beneficiario no especificado.";
    exit;
}

// Si el formulario se ha enviado, procesar la actualización
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

    $query = "UPDATE beneficiarios 
              SET nombre = ?, apellidos = ?, documento_identidad = ?, direccion = ?, telefono = ?, email = ?, miembros_unidad_familiar_0_2 = ?, miembros_otras_edades = ?, miembros_con_discapacidad = ?, fecha_registro = ?, activo = ?
              WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssssssiiiisi', $nombre, $apellidos, $documento_identidad, $direccion, $telefono, $email, $miembros_unidad_familiar_0_2, $miembros_otras_edades, $miembros_con_discapacidad, $fecha_registro, $activo, $id_beneficiario);

    if ($stmt->execute()) {
        echo "Beneficiario actualizado correctamente.";
    } else {
        echo "Error al actualizar el beneficiario: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
    exit;
}

// Obtener los datos actuales del beneficiario para mostrarlos en el formulario
$query = "SELECT * FROM beneficiarios WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_beneficiario);
$stmt->execute();
$result = $stmt->get_result();
$beneficiario = $result->fetch_assoc();

if (!$beneficiario) {
    echo "Beneficiario no encontrado.";
    exit;
}

$stmt->close();
$conexion->close();
?>

<div class="container mt-4">
    <h3>Editar Beneficiario</h3>
    <form id="editBeneficiarioForm" action="edit_beneficiario.php?id=<?php echo $id_beneficiario; ?>" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($beneficiario['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="documento_identidad" class="form-label">Documento de Identidad</label>
            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" value="<?php echo htmlspecialchars($beneficiario['documento_identidad']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($beneficiario['direccion']); ?>">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($beneficiario['telefono']); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($beneficiario['email']); ?>">
        </div>
        <div class="mb-3">
            <label for="miembros_unidad_familiar_0_2" class="form-label">Miembros de la Unidad Familiar (0-2 años)</label>
            <input type="number" class="form-control" id="miembros_unidad_familiar_0_2" name="miembros_unidad_familiar_0_2" value="<?php echo htmlspecialchars($beneficiario['miembros_unidad_familiar_0_2']); ?>" min="0">
        </div>
        <div class="mb-3">
            <label for="miembros_otras_edades" class="form-label">Miembros de Otras Edades</label>
            <input type="number" class="form-control" id="miembros_otras_edades" name="miembros_otras_edades" value="<?php echo htmlspecialchars($beneficiario['miembros_otras_edades']); ?>" min="0">
        </div>
        <div class="mb-3">
            <label for="miembros_con_discapacidad" class="form-label">Miembros con Discapacidad</label>
            <input type="number" class="form-control" id="miembros_con_discapacidad" name="miembros_con_discapacidad" value="<?php echo htmlspecialchars($beneficiario['miembros_con_discapacidad']); ?>" min="0">
        </div>
        <div class="mb-3">
            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($beneficiario['fecha_registro']); ?>" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo $beneficiario['activo'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="activo">Activo</label>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Beneficiario</button>
    </form>
</div>
