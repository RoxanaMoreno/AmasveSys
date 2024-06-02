# Explicación de las partes del archivo docker_compose.yaml del servicio amasvesys

- **Versión**
version: "3.9" Especifica la versión de Docker Compose que se está utilizando. 

- **Servicios**
Los servicios son contenedores que se ejecutan como parte de la aplicación Docker Compose. En este archivo hay tres servicios: web, apache, y db.

- **Servicio web**
build: Define cómo construir la imagen Docker para este servicio.
  - context: Directorio en el que Docker buscará el Dockerfile (./amasvesys).
  - args: Argumentos de construcción que se pasan al Dockerfile. Aquí se está utilizando una variable de entorno PHP_VERSION.
networks: Define a qué redes pertenece este contenedor. En este caso, la red backend.
volumes: Monta directorios locales en el contenedor.
  - ./amasvesys:/var/www/html: Monta el directorio local amasvesys en /var/www/html del contenedor.
  - pdfdata:/var/www/docs: Monta el volumen Docker pdfdata en /var/www/docs del contenedor.
container_name: Nombre del contenedor.

- **Servicio apache**
build: Similar al servicio web, pero con context apuntando al directorio actual (./) y utilizando APACHE_VERSION como argumento de construcción.
depends_on: Define dependencias. Este contenedor se iniciará después de amasvesys-web y db.
networks: Pertenece a las redes frontend y backend.
ports: Mapea el puerto 80 del contenedor al puerto 8080 del host.
volumes: Monta los mismos volúmenes que el servicio web.
container_name: Nombre del contenedor.

- **Servicio db**
image: Utiliza la imagen oficial de MySQL versión 5.7.
restart: Siempre reinicia el contenedor si falla (always).
ports: Mapea el puerto 3306 del contenedor al puerto 3306 del host.
volumes: Monta el volumen dbdata en /var/lib/mysql del contenedor para almacenamiento persistente.
networks: Pertenece a la red backend.
environment: Define variables de entorno para la configuración de MySQL, como la contraseña del root, el nombre de la base de datos y las credenciales de usuario.
container_name: Nombre del contenedor.

- **Redes**
frontend y backend: Define las redes a las que pertenecen los servicios.

- **Volúmenes**
pdfdata y dbdata: Define volúmenes para el almacenamiento persistente de datos.

- **Posibles Ajustes**
version: Si se necesita usar una característica específica de una versión diferente de Docker Compose, se puede ajustar la versión.
build.context: Se puede cambiar el contexto de construcción si el Dockerfile se encuentra en otro lugar.
build.args: Los valores de PHP_VERSION y APACHE_VERSION pueden ser ajustados según las versiones deseadas.
networks: Se pueden agregar, eliminar o renombrar redes según sea necesario.
volumes: Los volúmenes pueden ser cambiados para montar diferentes directorios o añadir nuevos volúmenes para otros propósitos.
ports: Los puertos pueden ser ajustados para evitar conflictos con otros servicios en el host.
environment: Las variables de entorno pueden ser ajustadas para cambiar la configuración de la base de datos.
Estos ajustes permiten personalizar el entorno de Docker Compose para satisfacer necesidades específicas y optimizar el funcionamiento del servicio.
