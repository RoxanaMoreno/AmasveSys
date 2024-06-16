<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

$id_entrega = $_GET['id'] ?? null;

if ($id_entrega) {
    // Query para eliminar la entrega
    $query = "DELETE FROM entregas WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_entrega);

    if ($stmt->execute()) {
        // Eliminación exitosa, mostrar mensaje y opción para volver
        $mensaje = "Entrega eliminada correctamente.";
    } else {
        // Error al eliminar la entrega
        $mensaje = "Error al eliminar la entrega: " . $stmt->error;
    }

    $stmt->close();
} else {
    // ID de entrega no proporcionado, manejar el caso
    $mensaje = "ID de entrega no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Entrega</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Eliminar Entrega</h2>

        <div class="alert alert-info"><?php echo $mensaje; ?></div>

        <button class="btn btn-secondary" onclick="loadContent('entregas.php')">Volver a la Lista de Entregas</button>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
