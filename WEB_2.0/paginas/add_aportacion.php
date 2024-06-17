<?php
include '../lib/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $socio_numero = $_POST['socio_numero'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Inserta la aportación en la tabla `aportaciones`
    $query = "INSERT INTO aportaciones (monto, fecha, descripcion, socio_numero) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('dssi', $monto, $fecha, $descripcion, $socio_numero);
    $stmt->execute();

    header('Location: socios.php'); // Redirige de vuelta a la página de socios
    exit;
}
?>


<body>
    <div class="container mt-4">
        <h2>Añadir Aportación para el Socio <?php echo htmlspecialchars($_GET['socio_numero']); ?></h2>

        <form action="add_aportacion.php" method="POST">
            <input type="hidden" name="socio_numero" value="<?php echo htmlspecialchars($_GET['socio_numero']); ?>">

            <div class="mb-3">
                <label for="monto">Monto:</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" style="width: 300px;" required>
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" style="width: 300px;" required>
            </div>

            <div class="mb-3">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
    </div>

</body>

</html>
