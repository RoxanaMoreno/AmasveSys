<?php
session_start();

// Verificar sesión de administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$error_msg = '';
$socio = null;

// Verificar si se ha proporcionado un ID de socio válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $socio_numero = $_GET['id'];

    // Obtener los datos del socio para mostrar en el formulario de edición
    $query = "SELECT * FROM socios WHERE socio_numero = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $socio_numero);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $socio = $result->fetch_assoc();
    } else {
        $error_msg = "Socio no encontrado.";
    }

    $stmt->close();
} else {
    $error_msg = "ID de socio no válido.";
}

// Procesar el formulario de edición al recibir una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $socio) {
    $nombres = ucwords(strtolower($_POST['nombres'])); // Convertir primera letra de cada palabra a mayúsculas
    $apellidos = ucwords(strtolower($_POST['apellidos'])); // Convertir primera letra de cada palabra a mayúsculas
    $documento_identidad = $_POST['documento_identidad'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $recibir_informacion = isset($_POST['recibir_informacion']) ? 1 : 0;
    $iban = strtoupper($_POST['iban']); // Convertir IBAN a mayúsculas

    // Validar IBAN
    if (!preg_match('/^[A-Z]{2}([A-Z0-9]){10,33}$/', $iban)) {
        $error_msg = "El IBAN ingresado no es válido.";
    }

    // Validar teléfono (9 dígitos)
    if (!preg_match('/^\d{9}$/', $telefono)) {
        $error_msg = "El teléfono debe contener exactamente 9 dígitos.";
    }

    // Si no hay errores de validación, proceder con la actualización en la base de datos
    if (empty($error_msg)) {
        $query = "UPDATE socios SET nombres = ?, apellidos = ?, documento_identidad = ?, email = ?, telefono = ?, recibir_informacion = ?, iban = ? WHERE socio_numero = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssssisi', $nombres, $apellidos, $documento_identidad, $email, $telefono, $recibir_informacion, $iban, $socio_numero);

        if ($stmt->execute()) {
            // Éxito al actualizar
            header('Location: socios.php');
            exit;
        } else {
            // Error al actualizar
            $error_msg = "Error al actualizar los datos del socio.";
        }

        $stmt->close();
    }
}

$conexion->close();
?>

<div class="container mt-4">
    <h3>Editar Socio</h3>
    <?php if (!empty($error_msg)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>
    <?php if ($socio) : ?>
        <form action="edit_socio.php?id=<?php echo htmlspecialchars($socio_numero); ?>" method="POST">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($socio['nombres']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($socio['apellidos']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="documento_identidad" class="form-label">Doc. Identidad</label>
                <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" value="<?php echo htmlspecialchars($socio['documento_identidad']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($socio['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($socio['telefono']); ?>" pattern="\d{9}" title="Debe contener 9 dígitos" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="recibir_informacion" name="recibir_informacion" value="1" <?php echo $socio['recibir_informacion'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="recibir_informacion">Recibir Información</label>
            </div>
            <div class="mb-3">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban" value="<?php echo htmlspecialchars($socio['iban']); ?>" required>
                <small id="ibanHelp" class="form-text text-muted">Formato: Dos letras seguidas de dos dígitos y caracteres alfanuméricos.</small>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Socio</button>
        </form>
    <?php else : ?>
        <p class="text-danger">No se pudo encontrar el socio especificado.</p>
    <?php endif; ?>
</div>
