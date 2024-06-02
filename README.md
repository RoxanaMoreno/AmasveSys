# AmasveSys

## Descripción

AmasveSys es un sistema desarrollado como parte del proyecto final de Roxana Moreno Rondon para su Título Técnico Superior en Administración de Sistemas Informáticos y Redes. Este proyecto tiene como objetivo demostrar competencias en la administración de sistemas y gestión de redes a través de una implementación práctica y funcional. AmasveSys ofrece una estructura sólida para la gestión y despliegue de aplicaciones utilizando contenedores Docker, facilitando la creación, mantenimiento y escalabilidad de entornos de desarrollo y producción.

## Características

- **Estructura de contenedores Docker**: Facilita la implementación y gestión de la aplicación.
- **Aplicación web**: Incluye todos los archivos necesarios para el funcionamiento del sistema.
- **Base de datos preliminar**: Proporciona una estructura inicial para pruebas y desarrollo.

## Contenido

El repositorio está organizado en varias carpetas y archivos clave:

- **[README.md](README.md)**: Descripción general del proyecto.
- **[Container](Container/)**: Contiene archivos relativos a la estructura de archivos y carpetas del dispositivo anfitrión.
  - **[docker-compose.yml](Container/docker-compose.yaml)**: Archivo que define los servicios y contenedores para la aplicación.
  - **[docker-compose-explanation.md](Container/docker_compose-parts.md)**: Documento que desglosa y explica cada una de las partes del archivo YAML.
- **[amasve](amasve/)**: Archivos de la aplicación web.
  - **[index.html](amasve/login.php)**: Página principal de la aplicación.
  - **[styles.css](amasve/css/style.css)**: Estilos de la aplicación web.
- **[database](database/)**: Contiene un archivo SQL [database](database/amasve.sql) para realizar pruebas sobre la base de datos y el Modelo Entidad Relación en [texto](database/MER_AMASVE.md) e [imagen](database/MER_AMASVE.svg).




## Contribuciones

¡Las contribuciones son bienvenidas! Para contribuir, sigue estos pasos:

1. Haz un fork del proyecto.
2. Crea una nueva rama para tu función (`git checkout -b feature/nueva-funcion`).
3. Realiza tus cambios y haz commit (`git commit -m 'Añadir nueva función'`).
4. Haz push a la rama (`git push origin feature/nueva-funcion`).
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

## Contacto

Roxana Moreno Rondon - [morenorandre@gmail.com]
