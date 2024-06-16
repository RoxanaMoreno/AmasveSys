<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

$nombre_usuario = $_SESSION['nombre_usuario'];

include '../lib/conexion_db.php';

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Consulta SQL para unir las tablas 'entregas' y 'beneficiarios' y permitir la búsqueda
$query = "
    SELECT e.id, e.fecha_entrega, e.descripcion, b.nombre, b.apellidos, b.documento_identidad
    FROM entregas e
    INNER JOIN beneficiarios b ON e.beneficiario_id = b.id
    WHERE b.nombre LIKE ? OR b.apellidos LIKE ? OR b.documento_identidad LIKE ? OR e.fecha_entrega LIKE ?
    ORDER BY e.fecha_entrega";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div>
        <h3>Gestión de Entregas</h3>
        <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
            <form class="d-flex" id="searchEntregasForm" action="entregas.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Buscar entrega" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Beneficiario</th>
                    <th>Fecha de Entrega</th>
                    <th>Productos Entregados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']); ?><br>
                            <small><?php echo htmlspecialchars($row['documento_identidad']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($row['fecha_entrega']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_entrega.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
