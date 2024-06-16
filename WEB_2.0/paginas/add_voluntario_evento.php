<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

// Obtener el ID del evento desde la URL
if (!isset($_GET['id_evento'])) {
    echo "ID de evento no proporcionado.";
    exit;
}

$id_evento = $_GET['id_evento'];

// Obtener información del evento
$stmt_evento = $conexion->prepare("SELECT nombre FROM eventos WHERE id = ?");
if ($stmt_evento === false) {
    die('Error en la consulta SQL para obtener evento: ' . $conexion->error);
}
$stmt_evento->bind_param('i', $id_evento);
$stmt_evento->execute();
$result_evento = $stmt_evento->get_result();
$evento = $result_evento->fetch_assoc();

if (!$evento) {
    echo "Evento no encontrado.";
    exit;
}

// Manejo del formulario de adición de voluntarios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voluntario_id = $_POST['voluntario_id'];

    // Validar si el voluntario ya está inscrito en el evento
    $stmt_check = $conexion->prepare("SELECT * FROM voluntarios_eventos WHERE evento_id = ? AND voluntario_id = ?");
    if ($stmt_check === false) {
        die('Error en la consulta SQL para verificar voluntario: ' . $conexion->error);
    }
    $stmt_check->bind_param('ii', $id_evento, $voluntario_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "El voluntario ya está inscrito en este evento.";
    } else {
        // Insertar el nuevo voluntario en el evento
        $stmt_insert = $conexion->prepare("INSERT INTO voluntarios_eventos (evento_id, voluntario_id) VALUES (?, ?)");
        if ($stmt_insert === false) {
            die('Error en la consulta SQL para insertar voluntario: ' . $conexion->error);
        }
        $stmt_insert->bind_param('ii', $id_evento, $voluntario_id);
        if ($stmt_insert->execute()) {
            $success_message = "Voluntario añadido con éxito.";
        } else {
            $error_message = "Error al añadir el voluntario: " . $stmt_insert->error;
        }
    }
}

// Obtener la lista de voluntarios disponibles con nombres, apellidos y número de identificación
$stmt_voluntarios = $conexion->prepare("SELECT id, nombres, apellidos, numero_identificacion FROM voluntarios ORDER BY nombres ASC");
if ($stmt_voluntarios === false) {
    die('Error en la consulta SQL para obtener voluntarios: ' . $conexion->error);
}
$stmt_voluntarios->execute();
$result_voluntarios = $stmt_voluntarios->get_result();
$voluntarios = $result_voluntarios->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Voluntarios al Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .voluntario-option {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Añadir Voluntarios al evento: <?php echo htmlspecialchars($evento['nombre']); ?></h3>

        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="add_voluntario_evento.php?id_evento=<?php echo $id_evento; ?>" method="POST">
            <div class="mb-3">
                <label for="voluntario_id" class="form-label">Seleccionar Voluntario:</label>
                <select class="form-control" id="voluntario_id" name="voluntario_id">
                    <?php foreach ($voluntarios as $voluntario) : ?>
                        <option value="<?php echo htmlspecialchars($voluntario['id']); ?>" class="voluntario-option">
                            <?php echo htmlspecialchars($voluntario['nombres'] . ' ' . $voluntario['apellidos'] . ' - ' . $voluntario['numero_identificacion']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Voluntario</button>
        </form>
        <button class="btn btn-secondary mt-3" onclick="loadContent('eventos.php')">Volver a Eventos</button>
    </div>
</body>
</html>
