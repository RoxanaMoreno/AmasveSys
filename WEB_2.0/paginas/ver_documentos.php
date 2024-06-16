<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}

include '../lib/conexion_db.php';

$id_beneficiario = $_GET['id_beneficiario'];

// Consulta para obtener los documentos del beneficiario
$query = "SELECT id, ruta_documento, tipo_documento, fecha_subida
          FROM documentos
          WHERE beneficiario_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_beneficiario);
$stmt->execute();
$result = $stmt->get_result();
?>


<body>
    <div class="container mt-4">
        <h2>Documentos de Beneficiario ID: <?php echo $id_beneficiario; ?></h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Documento</th>
                    <th>Ruta del Documento</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_documento']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['ruta_documento']); ?>" target="_blank"><?php echo htmlspecialchars(basename($row['ruta_documento'])); ?></a></td>
                        <td><?php echo htmlspecialchars($row['fecha_subida']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="loadContent('edit_documento.php?id=<?php echo $row['id']; ?>')">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('delete_documento.php?id=<?php echo $row['id']; ?>')">Borrar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
  
    </div>
</body>
</html>
