<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Ajusta la ruta si es necesario

$errores = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
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
        $query = "UPDATE eventos SET nombre = ?, descripcion = ?, fecha = ?, lugar = ?, organizador_id = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssssi', $nombre, $descripcion, $fecha, $lugar, $organizador_id, $id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errores[] = 'Error al actualizar el evento. Inténtelo de nuevo.';
        }

        $stmt->close();
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM eventos WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $evento = $result->fetch_assoc();
            $stmt->close();
        } else {
            $stmt->close();
            $errores[] = 'Evento no encontrado.';
        }
    } else {
        $errores[] = 'ID de evento no proporcionado.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Editar Evento</h3>
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                Evento actualizado correctamente.
                <button class="btn btn-secondary" onclick="loadContent('eventos.php')">Volver</button>
            </div>
        <?php else: ?>
            <form id="editEventoForm" action="edit_evento.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $evento['id']; ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($evento['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($evento['descripcion']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($evento['fecha']); ?>" style="width: 300px;" required>
                </div>
                <div class="mb-3">
                    <label for="lugar" class="form-label">Lugar</label>
                    <input type="text" class="form-control" id="lugar" name="lugar" value="<?php echo htmlspecialchars($evento['lugar']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="organizador_id" class="form-label">Organizador</label>
                    <input type="text" class="form-control" id="organizador_id" name="organizador_id" value="<?php echo htmlspecialchars($evento['organizador_id']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
