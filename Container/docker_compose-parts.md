# Explicación de las partes del archivo docker-compose.yaml del servicio amasvesys

- **Versión**
  `version: "3.9"`: Define la versión de Docker Compose que se está utilizando.

- **Servicios**
  Los servicios son contenedores que se ejecutan como parte de la aplicación Docker Compose. En este archivo hay tres servicios: `apache`, `mysql` y `phpmyadmin`.

- **Servicio apache**
  - `build`: Define cómo construir la imagen Docker para este servicio.
    - `./apache`: Especifica el directorio donde se encuentra el archivo Dockerfile para este servicio.
  - `ports`: Mapea el puerto 80 del contenedor al puerto 80 del host.
  - `volumes`: Monta el directorio local `src` en `/var/www/html` del contenedor.
  - `container_name`: Nombre del contenedor.

- **Servicio mysql**
  - `image`: Utiliza la imagen oficial de MySQL versión 8.0.
  - `ports`: Mapea el puerto 3306 del contenedor al puerto 3306 del host.
  - `volumes`: Monta un volumen para almacenar los datos de la base de datos de manera persistente.
  - `environment`: Define variables de entorno para la configuración de MySQL, como la contraseña de root y el nombre de la base de datos.
  - `container_name`: Nombre del contenedor.

- **Servicio phpmyadmin**
  - `image`: Utiliza la imagen oficial de phpMyAdmin versión 5.
  - `ports`: Mapea el puerto 8080 del contenedor al puerto 8080 del host.
  - `environment`: Define la variable de entorno `PMA_HOST` para especificar el host de la base de datos.
  - `depends_on`: Define que este servicio depende del servicio `mysql`.
  - `container_name`: Nombre del contenedor.

- **Volúmenes**
  - `mysql_data`: Define un volumen para almacenar los datos de la base de datos de manera persistente.

Esta configuración define los servicios necesarios para ejecutar la aplicación Amasvesys utilizando Docker Compose. Cada servicio tiene su propia configuración, que incluye la construcción de imágenes, mapeo de puertos, montaje de volúmenes y definición de variables de entorno. Esto proporciona un entorno completo y autónomo para ejecutar la aplicación en cualquier sistema que admita Docker.
