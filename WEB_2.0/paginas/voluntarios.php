<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

$nombre_usuario = $_SESSION['nombre_usuario']; // Obtener el nombre del usuario de la sesión

include '../lib/conexion_db.php'; // Archivo que contiene la conexión a la base de datos

// Manejo de la búsqueda
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$query = "SELECT * FROM voluntarios WHERE nombres LIKE ? OR apellidos LIKE ? ORDER BY nombres";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div>
        <h3>Gestion de Voluntarios</h3>
        <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
            <form class="d-flex" id="searchVoluntarioForm" action="voluntarios.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Buscar voluntario" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            <button class="btn btn-primary" onclick="loadContent('add_voluntario.php')">Añadir Voluntario</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número de Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Localidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['numero_identificacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['localidad']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="loadContent('edit_voluntario.php?id=<?php echo $row['id']; ?>')">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_voluntario.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
