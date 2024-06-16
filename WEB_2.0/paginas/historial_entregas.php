<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_beneficiario = $_GET['id_beneficiario'];

// Consulta para obtener el historial de entregas del beneficiario
$query = "SELECT * FROM entregas WHERE beneficiario_id = ? ORDER BY fecha_entrega ASC";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_beneficiario);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h3>Historial de Entregas para Beneficiario ID: <?php echo $id_beneficiario; ?></h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Entrega</th>
                <th>Descripción</th>
        
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_entrega']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <!-- Agrega más columnas según los campos de tu tabla entregas -->
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button class="btn btn-secondary mt-3" onclick="loadContent('beneficiarios.php')">Volver a Beneficiarios</button>
</div>
