<?php
include '../lib/conexion_db.php';

// Obtener el ID del recibo desde la URL
$id_recibo = $_GET['id_recibo'];

// Consulta para obtener los detalles del recibo y los datos del socio
$query = "SELECT r.id, r.monto, r.fecha, r.detalles, s.nombres, s.apellidos, s.documento_identidad
          FROM recibos r
          INNER JOIN aportaciones a ON r.id = a.id_recibo
          INNER JOIN socios s ON a.socio_numero = s.socio_numero
          WHERE r.id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_recibo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Manejo de caso cuando no se encuentra el recibo
    echo "Recibo no encontrado.";
    exit;
}

$recibo = $result->fetch_assoc();
?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Aportación Socio AMASVE</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recibo ID: <?php echo htmlspecialchars($recibo['id']); ?></h5>
                <p class="card-text"><strong>Fecha:</strong> <?php echo htmlspecialchars($recibo['fecha']); ?></p>
                <p class="card-text"><strong>Socio:</strong> <?php echo htmlspecialchars($recibo['nombres'] . ' ' . $recibo['apellidos']); ?></p>
                <p class="card-text"><strong>Documento de Identidad:</strong> <?php echo htmlspecialchars($recibo['documento_identidad']); ?></p>
                <p class="card-text"><strong>Monto:</strong> <?php echo number_format($recibo['monto'], 2); ?> €</p>
                <p class="card-text"><strong>Detalles:</strong> <?php echo htmlspecialchars($recibo['detalles']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
