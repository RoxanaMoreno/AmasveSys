<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

if (!isset($_GET['id_evento'])) {
    echo "ID de evento no proporcionado.";
    exit;
}

$id_evento = $_GET['id_evento'];

// Consulta para obtener los voluntarios del evento con sus nombres completos y números de identificación
$stmt_voluntarios = $conexion->prepare("SELECT v.id, CONCAT(v.nombres, ' ', v.apellidos) AS nombre_completo, v.numero_identificacion
                                        FROM voluntarios v
                                        LEFT JOIN voluntarios_eventos ve ON v.id = ve.voluntario_id
                                        WHERE ve.evento_id = ? ORDER BY nombres ASC");
if ($stmt_voluntarios === false) {
    die('Error en la consulta SQL: ' . $conexion->error);
}

$stmt_voluntarios->bind_param('i', $id_evento);
$stmt_voluntarios->execute();
$result_voluntarios = $stmt_voluntarios->get_result();
$voluntarios = $result_voluntarios->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Voluntarios en el Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h3>Voluntarios en el evento</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Número de Identificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voluntarios as $voluntario) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voluntario['id']); ?></td>
                        <td><?php echo htmlspecialchars($voluntario['nombre_completo']); ?></td>
                        <td><?php echo htmlspecialchars($voluntario['numero_identificacion']); ?></td>
                        <td>
                            <!-- Puedes agregar acciones aquí, por ejemplo, eliminar voluntario del evento -->
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_voluntario_evento.php?id_voluntario=<?php echo $voluntario['id']; ?>&id_evento=<?php echo $id_evento; ?>')">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-secondary mt-3" onclick="loadContent('eventos.php')">Volver a Eventos</button>
    </div>
</body>
</html>
