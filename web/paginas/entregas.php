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

$query = "SELECT * FROM entregas WHERE beneficiario_id LIKE ? OR fecha_entrega LIKE ? ORDER BY fecha_entrega";
$stmt = $conexion->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div>
        <h3>Gestion de Entregas</h3>
        <div class="d-flex justify-content-between mb-3" id="searchFormContainer">
            <form class="d-flex" id="searchForm">
                <input class="form-control me-2" type="search" placeholder="Buscar entrega" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            <button class="btn btn-primary" onclick="loadContent('add_entrega.php')">Añadir Entrega</button>
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
                        <td><?php echo htmlspecialchars($row['beneficiario_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_entrega']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="loadContent('edit_entrega.php?id=<?php echo $row['id']; ?>')">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_entrega.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // The same JavaScript functions as in voluntarios.php
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
        if (confirm('¿Estás seguro de que deseas eliminar esta entrega?')) {
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
                if (this.id === 'searchForm') {
                    url = 'entregas.php';
                } else if (this.id === 'addEntregaForm') {
                    url = 'add_entrega.php';
                } else {
                    url = 'edit_entrega.php';
                }
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('content').innerHTML = xhr.responseText;
                        attachFormSubmitEvent();
                    } else {
                        document.getElementById('content').innerHTML = '<p>Error al cargar el contenido.</p>';
                    }
                };
                xhr.send(formData);
            });
        });

        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'entregas.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('content').innerHTML = xhr.responseText;
                        attachFormSubmitEvent();
                    } else {
                        document.getElementById('content').innerHTML = '<p>Error al cargar el contenido.</p>';
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
