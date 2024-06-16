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
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = trim($_POST['fecha']);
    $lugar = trim($_POST['lugar']);
    $organizador_id = trim($_POST['organizador_id']);

    // Validaciones
    if (empty($nombre) || empty($descripcion) || empty($fecha) || empty($lugar) || empty($organizador_id)) {
        $errores[] = 'Todos los campos son obligatorios.';
    }

    if (empty($errores)) {
        $query = "INSERT INTO eventos (nombre, descripcion, fecha, lugar, organizador_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssss', $nombre, $descripcion, $fecha, $lugar, $organizador_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errores[] = 'Error al insertar el evento. Inténtelo de nuevo.';
        }

        $stmt->close();
    }
}
?>

<div>
    <h3>Añadir Evento</h3>
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
            Evento añadido correctamente.
            <button class="btn btn-primary" onclick="loadContent('add_evento.php')">Añadir más</button>
            <button class="btn btn-secondary" onclick="loadContent('eventos.php')">Volver</button>
        </div>
    <?php else : ?>
        <form id="addEventoForm" action="add_evento.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" style="width: 300px;" required>
            </div>
            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar</label>
                <input type="text" class="form-control" id="lugar" name="lugar" required>
            </div>
            <div class="mb-3">
                <label for="organizador_id" class="form-label">Organizador ID</label>
                <input type="text" class="form-control" id="organizador_id" name="organizador_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
    <?php endif; ?>
</div>

<?php
$conexion->close();
?>