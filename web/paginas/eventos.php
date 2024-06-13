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

$query = "SELECT * FROM eventos WHERE nombre LIKE ? OR descripcion LIKE ? ORDER BY fecha";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div>
    <h3>Gestión de Eventos</h3>
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" id="searchEventForm">
            <input class="form-control me-2" type="search" placeholder="Buscar evento" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
        <button class="btn btn-primary" onclick="loadContent('add_evento.php')">Añadir Evento</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th>Organizador ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($row['lugar']); ?></td>
                    <td><?php echo htmlspecialchars($row['organizador_id']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="loadContent('edit_evento.php?id=<?php echo $row['id']; ?>')">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_evento.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function loadContent(page) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', page, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('content').innerHTML = xhr.responseText;
                attachFormSubmitEvent();
            } else {
                document.getElementById('content').innerHTML = '<p>Error al cargar el contenido.</p>';
            }
        };
        xhr.send();
    }

    function confirmDelete(url) {
        if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
            loadContent(url);
        }
    }

    function attachFormSubmitEvent() {
        const forms = document.querySelectorAll('#content form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                let url = '';
                if (this.id === 'searchEventForm') {
                    url = 'eventos.php';
                } else if (this.id === 'addEventoForm') {
                    url = 'add_evento.php';
                } else {
                    url = 'edit_evento.php';
                }
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('content').innerHTML = xhr.responseText;
                        attachFormSubmitEvent();
                    } else {
                        document.getElementById('content').innerHTML = '<p>Error al enviar el formulario.</p>';
                    }
                };
                xhr.send(formData);
            });
        });

        const searchEventForm = document.getElementById('searchEventForm');
        if (searchEventForm) {
            searchEventForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'eventos.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('content').innerHTML = xhr.responseText;
                        attachFormSubmitEvent();
                    } else {
                        document.getElementById('content').innerHTML = '<p>Error al enviar el formulario.</p>';
                    }
                };
                xhr.send(formData);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        attachFormSubmitEvent();
    });
</script>

<?php
$conexion->close();
?>
