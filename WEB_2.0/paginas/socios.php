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

$query = "SELECT * FROM socios WHERE nombres LIKE ? OR apellidos LIKE ? ORDER BY nombres";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div>
        <h3>Gestion de Socios</h3>
        <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
            <form class="d-flex" id="searchSociosForm" action="socios.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Buscar socio" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            <button class="btn btn-primary" onclick="loadContent('add_socio.php')">Añadir Socio</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 3%;">Nº</th>
                    <th style="width: 12%;">Nombre</th>
                    <th style="width: 12%;">Apellidos</th>
                    <th style="width: 8%;">Doc. Identidad</th>
                    <th style="width: 8%;">Teléfono</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 2%;">Info</th>
                    <th style="width: 10%;">Fecha Registro</th>
                    <th style="width: 30%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['socio_numero']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($row['documento_identidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['recibir_informacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_inscripcion']); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="loadContent('edit_socio.php?id=<?php echo $row['socio_numero']; ?>')">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_socio.php?id=<?php echo $row['socio_numero']; ?>')">Borrar</button>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm" onclick="loadContent('add_aportacion.php?socio_numero=<?php echo $row['socio_numero']; ?>')">+ Aportación</button>
                                <button class="btn btn-secondary btn-sm" onclick="loadContent('ver_aportaciones.php?socio_numero=<?php echo $row['socio_numero']; ?>')">Ver Aportaciones</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>