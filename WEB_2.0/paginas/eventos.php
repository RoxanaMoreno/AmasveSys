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

$query = "SELECT e.id, e.nombre, e.descripcion, e.fecha, e.lugar, v.nombres AS organizador_nombre 
          FROM eventos e
          LEFT JOIN voluntarios v ON e.organizador_id = v.id
          WHERE e.nombre LIKE ? OR e.descripcion LIKE ?
          ORDER BY e.fecha";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Obtener lista de eventos para mostrar
$eventos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador - Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../recursos/css/style.css"> <!-- Tu hoja de estilos personalizada -->
</head>

<body>
    <div class="container mt-4">
        <div>
            <h3>Gestión de Eventos</h3>
            <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
                <form class="d-flex" id="searchEventoForm" action="eventos.php" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Buscar evento" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <button class="btn btn-primary" onclick="loadContent('add_evento.php')">Añadir Evento</button>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 3%;">ID</th>
                        <th style="width: 15%;">Nombre</th>
                        <th style="width: 22%;">Descripción</th>
                        <th style="width: 10%;">Fecha</th>
                        <th style="width: 15%;">Lugar</th>
                        <th style="width: 10%;">Organizador Nombre</th>
                        <th style="width: 25%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventos as $evento) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($evento['id']); ?></td>
                            <td><?php echo htmlspecialchars($evento['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($evento['lugar']); ?></td>
                            <td><?php echo htmlspecialchars($evento['organizador_nombre']); ?></td>
                            <td>
                                <div>
                                    <button class="btn btn-warning btn-sm btn-action" onclick="loadContent('edit_evento.php?id=<?php echo $evento['id']; ?>')">Editar</button>
                                    <button class="btn btn-danger btn-sm btn-action" onclick="confirmDelete('delete_evento.php?id=<?php echo $evento['id']; ?>')">Borrar</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm btn-action" onclick="loadVoluntarios(<?php echo $evento['id']; ?>)">Ver Voluntarios</button>
                                    <button class="btn btn-secondary btn-sm btn-action" onclick="addVoluntarios(<?php echo $evento['id']; ?>)">+ Voluntarios</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm btn-action" onclick="loadBeneficiarios(<?php echo $evento['id']; ?>)">Ver Beneficiarios</button>
                                    <button class="btn btn-secondary btn-sm btn-action" onclick="addBeneficiarios(<?php echo $evento['id']; ?>)">+ Beneficiarios</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="container mt-4">
            <div id="content">
                <!-- Aquí se cargará el contenido dinámico -->
            </div>
        </div>
    </div>
</body>

</html>
