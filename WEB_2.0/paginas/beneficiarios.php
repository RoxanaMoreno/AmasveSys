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

$query = "SELECT * FROM beneficiarios WHERE nombre LIKE ? OR apellidos LIKE ? ORDER BY nombre";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div>
        <h3>Gestión de Beneficiarios</h3>
        <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
            <form class="d-flex" id="searchBeneficiarioForm" action="beneficiarios.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Buscar beneficiario" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            <button class="btn btn-primary" onclick="loadContent('add_beneficiario.php')">Añadir Beneficiario</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Documento de Identidad</th>
                    <th>Grupo Familiar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($row['documento_identidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_miembros']); ?></td>

                        <td>
                            <button class="btn btn-warning btn-sm" onclick="loadContent('edit_beneficiario.php?id=<?php echo $row['id']; ?>')">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_beneficiario.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                            <button class="btn btn-primary btn-sm" onclick="loadContent('add_beneficiario_entrega.php?id_beneficiario=<?php echo $row['id']; ?>')">+ Entrega</button>
                            <button class="btn btn-secondary btn-sm" onclick="loadContent('historial_entregas.php?id_beneficiario=<?php echo $row['id']; ?>')">Ver Entregas</button>
                            <button class="btn btn-primary btn-sm" onclick="loadContent('add_documento.php?id_beneficiario=<?php echo $row['id']; ?>')">+ Documento</button>
                            <button class="btn btn-secondary btn-sm" onclick="loadContent('ver_documentos.php?id_beneficiario=<?php echo $row['id']; ?>')">Ver Documentos</button>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
