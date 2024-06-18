# Estructura de archivos para la contenerización del servicio Amasvesys

## Estructura de directorios:

```plaintext
📁 amasvesys/
├── 📁 apache/
│   └── 📄 Dockerfile
├── 📁 db/
│   └── 📄 database.sql
└── 📁 src/
    ├── 📁 documentos/
    ├── 📁 lib/
    ├── 📁 paginas/
    └── 📁 recursos/
        ├── 📁 css/
        ├── 📁 fonts/
        ├── 📁 images/
        └── 📁 js/
```

## Explicación:

- **amasvesys**: Directorio raíz del proyecto.
- **apache**: Contiene el archivo Dockerfile para la configuración del servidor web Apache.
  - **Dockerfile**: Define la configuración para construir la imagen del contenedor Apache.
- **db**: Contiene el archivo `database.sql` que define la base de datos de la aplicación.
  - **database.sql**: Script para la inicialización de la base de datos.
- **src**: Carpeta con los archivos de la aplicación web.
  - **Documentos, librerías, páginas y recursos**: Directorios y archivos que componen la aplicación web.
- **docker-compose.yaml**: Archivo de configuración de Docker Compose que define los servicios y redes de la aplicación.
