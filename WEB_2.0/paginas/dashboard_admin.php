<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'administrador') {
    header('Location: login.php');
    exit;
}
// Obtener el nombre del usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../recursos/css/style.css">
    <script src="../recursos/js/funciones.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../recursos/images/amasvesys1.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="loadContent('voluntarios.php')">Voluntarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="loadContent('socios.php')">Socios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="loadContent('beneficiarios.php')">Beneficiarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="loadContent('eventos.php')">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="loadContent('entregas.php')">Entregas</a>
                    </li>
                </ul>
                <p class="me-5"><?php echo 'Usuario activo: ' . htmlspecialchars($nombre_usuario); ?></p>
                <a class="btn btn-outline-danger ml-2" href="../lib/cerrar_sesion.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div id="content">
            <!-- Aquí se cargará el contenido dinámico -->
        </div>
    </div>
</body>

</html>