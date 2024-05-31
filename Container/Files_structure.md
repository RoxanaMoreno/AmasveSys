# Estructura de archivos para la contenerización del servicio Amasvesys

## Estructura de directorios:

```plaintext
amasvesys/
├── apache/
│   ├── Dockerfile
│   └── demo.apache.conf
├── config/
│   └── connectiondb.php # Archivo de configuración de la base de datos
├── docker-compose.yml
├── docs/ # Carpeta para almacenar los archivos PDF
├── pdfdata/ # Volumen para almacenar los archivos PDF (creado automáticamente por Docker Compose)
├── php/
│   └── Dockerfile
└── public_html/
    └── index.php
```

## Explicación:

- **amasvesys**: Directorio raíz del proyecto.
- **apache**: Carpeta para almacenar los archivos relacionados con el servidor web Apache.
  - **Dockerfile**: Define la configuración para construir la imagen del contenedor Apache.
  - **demo.apache.conf**: Archivo de configuración de ejemplo para Apache.
- **config**: Carpeta para almacenar archivos de conexión de la base de datos. Aquí se incluirá un usuario con permisos para consultar las tablas relativas a la autenticación de sesiones de usuarios y archivos específicos de conexión para los roles con determinados permisos
  - **connectiondb.php**: ejemplo de un archivo de conexion a la base de datos para determinado rol.
- **docker-compose.yml**: Archivo de configuración de Docker Compose que define los servicios y redes de tu aplicación.
- **docs**: Carpeta para almacenar los archivos PDF que se mostrarán en tu sitio web.
- **pdfdata**: Volumen de Docker Compose que almacena los archivos PDF de forma persistente.
- **php**: Carpeta para almacenar los archivos relacionados con PHP.
  - **Dockerfile**: Define la configuración para construir la imagen del contenedor PHP.
- **public_html**: Carpeta raíz de tu sitio web accesible desde el exterior.
  - **index.php**: Archivo principal de la app web.
