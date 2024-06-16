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

// Obtener la lista de beneficiarios para este evento
$stmt_beneficiarios = $conexion->prepare("SELECT b.id, b.nombre, b.apellidos, b.documento_identidad 
                                           FROM beneficiarios b
                                           INNER JOIN beneficiarios_eventos be ON b.id = be.beneficiario_id
                                           WHERE be.evento_id = ? ORDER BY nombre ASC");
if ($stmt_beneficiarios === false) {
    die('Error en la consulta SQL para obtener beneficiarios: ' . $conexion->error);
}
$stmt_beneficiarios->bind_param('i', $id_evento);
$stmt_beneficiarios->execute();
$result_beneficiarios = $stmt_beneficiarios->get_result();
$beneficiarios = $result_beneficiarios->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Beneficiarios del Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h3>Beneficiarios inscritos en el evento</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Número de Identificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beneficiarios as $beneficiario) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($beneficiario['id']); ?></td>
                        <td><?php echo htmlspecialchars($beneficiario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($beneficiario['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($beneficiario['documento_identidad']); ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-action" onclick="confirmDelete('delete_beneficiario_evento.php?id_evento=<?php echo $id_evento; ?>&beneficiario_id=<?php echo $beneficiario['id']; ?>')">Quitar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-secondary mt-3" onclick="loadContent('eventos.php')">Volver a Eventos</button>
    </div>
</body>
</html>
