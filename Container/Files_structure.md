# Estructura de archivos para la contenerización del servicio Amasvesys

## Estructura de directorios:

```plaintext
📁 amasvesys/
├── 📁 apache/
│   └── 📄 Dockerfile
├── 📁 db/
│   └── 📄 database.sql
├── 📁 src/
│   ├── 📁 documentos/
│   ├── 📁 lib/
│   ├── 📁 paginas/
│   └── 📁 recursos/
│       ├── 📁 css/
│       ├── 📁 fonts/
│       ├── 📁 images/
│       └── 📁 js/
└── 📄 docker-compose.yaml
```

## Explicación:

- **amasvesys**: Directorio raíz del proyecto.
- **apache**: Archivo dockerfile relacionado con el servidor web Apache.
  - **Dockerfile**: Define la configuración para construir la imagen del contenedor Apache.
- **db**: Contiene el archivo sql con la base de datos.
  - **database.sql**: base de datos de la aplicacion. 
- **src**: Carpeta con los archivos de la aplicación web.
  - **index.html**
  - **Otras carpetas y archivos de la app**
- **docker-compose.yml**: Archivo de configuración de Docker Compose que define los servicios y redes de la aplicación.
