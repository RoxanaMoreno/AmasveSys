<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./recursos/css/style.css">
  <script>
    $(document).ready(function() {
      $('form').submit(function(event) {
        event.preventDefault(); // Evitar envío del formulario por defecto

        // Obtener los datos del formulario
        var nombreUsuario = $('#nombre_usuario').val();
        var contrasena = $('#contrasena').val();

        // Enviar la petición AJAX al servidor
        $.ajax({
          url: './lib/procesar_login.php',
          method: 'POST',
          data: {
            nombre_usuario: nombreUsuario,
            contrasena: contrasena
          },
          success: function(respuesta) {
            if (respuesta.credencialesValidas) {
              // Redirigir al dashboard correspondiente basado en el rol
              switch (respuesta.rol) {
                case 'administrador':
                  window.location.href = './paginas/dashboard_admin.php';
                  break;
                case 'pro':
                  window.location.href = './paginas/dashboard_pro.php';
                  break;
                case 'basic':
                  window.location.href = './paginas/dashboard_basic.php';
                  break;
              }
            } else {
              // Mostrar mensaje de error
              var mensajeError = 'Usuario y/o contraseña incorrectos.';
              if (respuesta.error) {
                mensajeError = respuesta.error;
              }
              $('#mensajeError').text(mensajeError).show();
            }
          }
        });
      });
    });
  </script>

</head>

<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="./recursos/images/imagen1.jpg" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form action="#">

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Inicio</p>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control form-control-lg" required />
              <label class="form-label" for="nombre_usuario">Usuario</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-3">
              <input type="password" id="contrasena" name="contrasena" class="form-control form-control-lg" required />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">

              <input type="submit" value="Iniciar sesión" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
              <p class="small fw-bold mt-2 pt-1 mb-0">Acceso restingido solo a personal autorizado</p>
              <p id="mensajeError" style="display: none; color: red;">Usuario y/o contraseña incorrectos.</p>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
      <div class="text-white mb-3 mb-md-0">
        Desarrollado por Roxana Moreno Rondón / Copyright © 2024. All rights reserved.
      </div>
    </div>
  </section>
</body>

</html>