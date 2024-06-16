<?php
session_start();

// Verificar sesión de administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de agregar socio
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

    // Validar otros campos si es necesario

    // Si no hay errores de validación, proceder con la inserción en la base de datos
    if (empty($error_msg)) {
        // Preparar y ejecutar la inserción en la base de datos
        $query = "INSERT INTO socios (nombres, apellidos, documento_identidad, email, telefono, recibir_informacion, iban, fecha_inscripcion) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp())";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssssds', $nombres, $apellidos, $documento_identidad, $email, $telefono, $recibir_informacion, $iban);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Éxito al insertar
            header('Location: socios.php');
            exit;
        } else {
            // Error al insertar
            $error_msg = "Error al agregar socio.";
        }
    }
}
?>

<div class="container mt-4">
    <h3>Añadir Socio</h3>
    <?php if (!empty($error_msg)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>
    <form action="add_socio.php" method="POST">
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="mb-3">
            <label for="documento_identidad" class="form-label">Doc. Identidad</label>
            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{9}" title="Debe contener 9 dígitos" required>            
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="recibir_informacion" name="recibir_informacion" value="1">
            <label class="form-check-label" for="recibir_informacion">Recibir Información</label>
        </div>
        <div class="mb-3">
            <label for="iban" class="form-label">IBAN</label>
            <input type="text" class="form-control" id="iban" name="iban" required>
            <small id="ibanHelp" class="form-text text-muted">Formato: Dos letras seguidas de dos dígitos y caracteres alfanuméricos.</small>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Socio</button>
    </form>
</div>
