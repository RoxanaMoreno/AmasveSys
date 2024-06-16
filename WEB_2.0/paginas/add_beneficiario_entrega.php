<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_beneficiario = $_GET['id_beneficiario'];
$id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario para agregar entrega
    $fecha_entrega = $_POST['fecha_entrega'];
    $descripcion = $_POST['descripcion'];

    // Validación básica (puedes agregar más validaciones según tus requerimientos)
    if (empty($fecha_entrega) || empty($descripcion)) {
        $error_message = "Todos los campos son obligatorios.";
    } else {
        // Insertar la entrega en la base de datos
        $query = "INSERT INTO entregas (fecha_entrega, descripcion, usuario_id, beneficiario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssii', $fecha_entrega, $descripcion, $id_usuario, $id_beneficiario);

        if ($stmt->execute()) {
            $success_message = "Entrega agregada correctamente.";
        } else {
            $error_message = "Error al agregar la entrega: " . $stmt->error;
        }
    }
}

// Obtener la fecha actual
$fecha_actual = date('Y-m-d'); // Formato esperado por el campo input type="date"
?>

<div class="container mt-4">
    <h3>Agregar Entrega para Beneficiario ID: <?php echo $id_beneficiario; ?></h3>

    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if (isset($success_message)) : ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="add_beneficiario_entrega.php?id_beneficiario=<?php echo $id_beneficiario; ?>" method="POST">
        <div class="mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" value="<?php echo $fecha_actual; ?>" style="width: 300px;" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción de la Entrega</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <input type="hidden" name="usuario_id" value="<?php echo $id_usuario; ?>">
        <input type="hidden" name="beneficiario_id" value="<?php echo $id_beneficiario; ?>">
        <button type="submit" class="btn btn-primary">Agregar Entrega</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('beneficiarios.php')">Cancelar</button>
    </form>
</div>
