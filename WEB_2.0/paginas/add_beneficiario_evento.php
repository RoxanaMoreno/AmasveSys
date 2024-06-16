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

// Manejo del formulario de adición de beneficiarios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $beneficiario_id = $_POST['beneficiario_id'];

    // Validar si el beneficiario ya está inscrito en el evento
    $stmt_check = $conexion->prepare("SELECT * FROM beneficiarios_eventos WHERE evento_id = ? AND beneficiario_id = ?");
    if ($stmt_check === false) {
        die('Error en la consulta SQL para verificar beneficiario: ' . $conexion->error);
    }
    $stmt_check->bind_param('ii', $id_evento, $beneficiario_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "El beneficiario ya está inscrito en este evento.";
    } else {
        // Insertar el nuevo beneficiario en el evento
        $stmt_insert = $conexion->prepare("INSERT INTO beneficiarios_eventos (evento_id, beneficiario_id) VALUES (?, ?)");
        if ($stmt_insert === false) {
            die('Error en la consulta SQL para insertar beneficiario: ' . $conexion->error);
        }
        $stmt_insert->bind_param('ii', $id_evento, $beneficiario_id);
        if ($stmt_insert->execute()) {
            $success_message = "Beneficiario añadido con éxito.";
        } else {
            $error_message = "Error al añadir el beneficiario: " . $stmt_insert->error;
        }
    }
}

// Obtener la lista de beneficiarios disponibles con nombres, apellidos y número de identificación
$stmt_beneficiarios = $conexion->prepare("SELECT id, nombre, apellidos, documento_identidad FROM beneficiarios ORDER BY nombre ASC");
if ($stmt_beneficiarios === false) {
    die('Error en la consulta SQL para obtener beneficiarios: ' . $conexion->error);
}
$stmt_beneficiarios->execute();
$result_beneficiarios = $stmt_beneficiarios->get_result();
$beneficiarios = $result_beneficiarios->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Beneficiarios al Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .beneficiario-option {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Añadir Beneficiarios al evento: <?php echo htmlspecialchars($evento['nombre']); ?></h3>

        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="add_beneficiario_evento.php?id_evento=<?php echo $id_evento; ?>" method="POST">
            <div class="mb-3">
                <label for="beneficiario_id" class="form-label">Seleccionar Beneficiario:</label>
                <select class="form-control" id="beneficiario_id" name="beneficiario_id">
                    <?php foreach ($beneficiarios as $beneficiario) : ?>
                        <option value="<?php echo htmlspecialchars($beneficiario['id']); ?>" class="beneficiario-option">
                            <?php echo htmlspecialchars($beneficiario['nombre'] . ' ' . $beneficiario['apellidos'] . ' - ' . $beneficiario['documento_identidad']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Beneficiario</button>
        </form>
        <button class="btn btn-secondary mt-3" onclick="loadContent('eventos.php')">Volver a Eventos</button>
    </div>
</body>
</html>
