<?php
include '../lib/conexion_db.php';

$socio_numero = $_GET['socio_numero'];

// Consulta para obtener las aportaciones del socio
$query = "SELECT id, monto, fecha, descripcion, id_recibo
          FROM aportaciones
          WHERE socio_numero = ?
          ORDER BY fecha DESC";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $socio_numero);
$stmt->execute();
$result = $stmt->get_result();

// Consulta para sumar las aportaciones del año en curso
$current_year = date('Y');
$query_sum = "SELECT SUM(monto) as total_anual
              FROM aportaciones
              WHERE socio_numero = ? AND YEAR(fecha) = ?";
$stmt_sum = $conexion->prepare($query_sum);
$stmt_sum->bind_param('ii', $socio_numero, $current_year);
$stmt_sum->execute();
$result_sum = $stmt_sum->get_result();
$total_anual = $result_sum->fetch_assoc()['total_anual'];
?>


<body>
    <div class="container mt-4">
        <h2>Aportaciones del Socio <?php echo htmlspecialchars($socio_numero); ?></h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Acciones</th> <!-- Nuevo encabezado para las acciones -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['monto']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td>
                            <?php if ($row['id_recibo']) : ?>
                                <!-- Si ya tiene recibo asociado, mostrar el botón de ver recibo -->
                                <a href="ver_recibo.php?id_recibo=<?php echo $row['id_recibo']; ?>" class="btn btn-info btn-sm" target="_blank">Ver Recibo</a>
                            <?php else : ?>
                                <!-- Si no tiene recibo asociado, mostrar el botón para generar recibo -->
                                <a href="generar_recibo.php?id_aportacion=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Generar Recibo</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Mostrar la suma de las aportaciones del año en curso -->
        <div class="alert alert-info">
            <strong>Total de Aportaciones en <?php echo $current_year; ?>:</strong>
            <?php echo $total_anual ? number_format($total_anual, 2) : '0.00'; ?> €
        </div>
    </div>

</body>
</html>
