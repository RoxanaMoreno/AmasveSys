<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

$errores = [];
$success = false;
$voluntario = null; // Inicializar variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $numero_identificacion = trim($_POST['numero_identificacion']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $localidad = trim($_POST['localidad']);

    // Validaciones
    if (empty($numero_identificacion) || empty($nombres) || empty($apellidos) || empty($telefono) || empty($email) || empty($localidad)) {
        $errores[] = 'Todos los campos son obligatorios.';
    }
    $numero_identificacion = strtoupper($numero_identificacion); // Letra DNI/NIE a mayúsculas
    $nombres = ucwords(strtolower($nombres));
    $apellidos = ucwords(strtolower($apellidos));

    if (!preg_match('/^\d{9}$/', $telefono)) {
        $errores[] = 'El teléfono debe tener 9 dígitos.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no tiene un formato válido.';
    }

    if (empty($errores)) {
        $query = "UPDATE voluntarios SET numero_identificacion=?, nombres=?, apellidos=?, telefono=?, email=?, localidad=? WHERE id=?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssssssi', $numero_identificacion, $nombres, $apellidos, $telefono, $email, $localidad, $id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errores[] = 'Error al actualizar el voluntario. Inténtelo de nuevo.';
        }

        $stmt->close();
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM voluntarios WHERE id=?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $voluntario = $result->fetch_assoc();
            $stmt->close();
        } else {
            $stmt->close();
            $errores[] = 'Voluntario no encontrado.';
        }
    } else {
        $errores[] = 'ID de voluntario no proporcionado.';
    }
}
?>

<div class="container mt-4">
    <h3>Editar Voluntario</h3>
    <?php if (!empty($errores)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($success) : ?>
        <div class="alert alert-success">
            Voluntario actualizado correctamente.
            <button class="btn btn-secondary" onclick="loadContent('voluntarios.php')">Volver</button>
        </div>
    <?php else : ?>
        <form id="editVoluntarioForm">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($voluntario['id'] ?? ''); ?>">
            <div class="mb-3">
                <label for="numero_identificacion" class="form-label">Número de Identificación</label>
                <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" value="<?php echo htmlspecialchars($voluntario['numero_identificacion'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($voluntario['nombres'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($voluntario['apellidos'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($voluntario['telefono'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($voluntario['email'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="localidad" class="form-label">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo htmlspecialchars($voluntario['localidad'] ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    <?php endif; ?>
</div>

<script>
    document.getElementById('editVoluntarioForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_voluntario.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('content').innerHTML = xhr.responseText;
                attachFormSubmitEvent(); // Reatachar event listeners
            } else {
                document.getElementById('content').innerHTML = '<p>Error al actualizar el voluntario.</p>';
            }
        };
        xhr.send(formData);
    });
</script>
