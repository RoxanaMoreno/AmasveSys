<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

// Obtener el nombre del usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

$errores = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    // Formatear nombres y apellidos // Pasa todo a minúsculas y luego a mayúsculas la inicial
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
        $query = "INSERT INTO voluntarios (numero_identificacion, nombres, apellidos, telefono, email, localidad) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssssss', $numero_identificacion, $nombres, $apellidos, $telefono, $email, $localidad);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errores[] = 'Error al insertar el voluntario. Inténtelo de nuevo.';
        }

        $stmt->close();
    }
}
?>

<div>
    <h3>Añadir Voluntario</h3>
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
            Voluntario añadido correctamente.
            <button class="btn btn-primary" onclick="loadContent('add_voluntario.php')">Añadir más</button>
            <button class="btn btn-secondary" onclick="loadContent('voluntarios.php')">Volver</button>
        </div>
    <?php else : ?>
        <form id="addVoluntarioForm" action="add_voluntario.php" method="POST">
            <div class="mb-3">
                <label for="numero_identificacion" class="form-label">Número de Identificación</label>
                <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" required>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{9}" title="Debe contener 9 dígitos" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="localidad" class="form-label">Localidad</label>
                <input type="text" class="form-control" id="localidad" name="localidad" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Voluntario</button>
        </form>
    <?php endif; ?>
</div>

<?php
$conexion->close();
?>