<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    // El usuario no está autenticado o no tiene el rol correcto
    header('Location: login.php');
    exit;
}

// Incluir archivo de conexión a la base de datos
include '../lib/conexion_db.php';

// Obtener el ID del beneficiario desde la URL
$id_beneficiario = $_GET['id'] ?? null;

if ($id_beneficiario) {
    // Preparar y ejecutar la consulta para eliminar el beneficiario
    $query = "DELETE FROM beneficiarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_beneficiario);
    $stmt->execute();
    $stmt->close();

    // Redirigir de vuelta a la página de beneficiarios
    header('Location: beneficiarios.php');
    exit;
}
?>

<!-- HTML para mostrar mensaje de éxito -->
<div class="container mt-4">
    <div>
        <p>Beneficiario eliminado correctamente.</p>
        <button class="btn btn-secondary" onclick="loadContent('beneficiarios.php')">Volver</button>
    </div>
</div>

<?php
$conexion->close(); // Cerrar la conexión a la base de datos al finalizar
?>
