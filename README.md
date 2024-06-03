# AmasveSys

## Descripción

AmasveSys es un sistema integral de gestión desarrollado específicamente para la Asociación AMASVE como parte del proyecto final en el marco de la Formación Profesional Superior en Administración de Sistemas Informáticos en Red. El objetivo principal de este proyecto es digitalizar y optimizar los procesos administrativos, mejorando así la eficiencia operativa y el uso eficiente de los recursos disponibles.

El sistema se ha construido utilizando tecnologías como MySQL y PHP, lo que permite ofrecer una interfaz web modular, escalable y fácil de usar. Al migrar de procesos manuales a digitales, AmasveSys reduce significativamente el uso de recursos físicos y el tiempo dedicado a la gestión de datos. Además, garantiza un acceso preciso y en tiempo real a la información, lo que respalda la misión de AMASVE de asistir a grupos vulnerables.

En términos de competencias en administración de sistemas y gestión de redes, AmasveSys demuestra una implementación práctica y funcional. Su estructura sólida facilita la gestión y el despliegue de aplicaciones mediante contenedores Docker, lo que simplifica la creación, el mantenimiento y la escalabilidad de entornos tanto de desarrollo como de producción.


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
- **[web](web/)**: Archivos de la aplicación web, en la que destacan:
  - **[index.html](web/index.php)**: Página principal de la aplicación.
  - **[styles.css](web/recursos/css/style.css)**: Estilos de la aplicación web.
- **[database](database/)**: Contiene un archivo SQL [database](database/amasve.sql) para realizar pruebas sobre la base de datos y el Modelo Entidad Relación en [texto](database/MER_AMASVE.md) e [imagen](https://www.mermaidchart.com/raw/9821516f-03fe-487c-a817-609c16071892?theme=light&version=v0.1&format=svg).




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
