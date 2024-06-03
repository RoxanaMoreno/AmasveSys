# Creación de usuarios y asignación de roles en la base de datos

Para efectos prácticos en las pruebas del proyecto se realizan todas las pruebas contra una base de datos local utilizando las credenciales del usuario root de phpmyadmin, sin embargo, a efectos funcionales y de seguridad se plantea crear diferentes archivos de conexión a base de datos que se corresponden con el rol del usuario activo de la siguiente manera.

## ROL Principal
Sirve para la conexión de inicio de sesión y tiene acceso únicamente a las tablas `usuarios` y `login_attempts` creado mediante las siguientes sentencias SQL.

```sql
CREATE USER 'logincontrol'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT SELECT ON amasve.usuarios TO 'logincontrol'@'localhost';
GRANT SELECT, INSERT, DELETE ON amasve.login_attempts TO 'logincontrol'@'localhost';
```

## ROL Administrador
Tiene permisos de SELECT, INSERT, UPDATE, DELETE de todas las tablas de la base de datos amasve.

```sql
CREATE USER 'admin_usuario'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT SELECT, INSERT, UPDATE, DELETE ON amasve.* TO 'admin_usuario'@'localhost';
```

## ROL Pro
Tiene permisos de SELECT e INSERT de todas las tablas de la base de datos amasve.

```sql
CREATE USER 'pro_usuario'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT SELECT, INSERT ON amasve.* TO 'pro_usuario'@'localhost';

```

## ROL Basic
Tiene permisos de SELECT de la tabla beneficiarios y SELECT e INSERT sobre la tabla entregas de la base de datos amasve.

```sql
CREATE USER 'basic_usuario'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT SELECT ON amasve.beneficiarios TO 'basic_usuario'@'localhost';
GRANT SELECT, INSERT ON amasve.entregas TO 'basic_usuario'@'localhost';

```

## Actualizar privilegios
Después de crear todos los usuarios y asignar los permisos, es conveniente ejecutar la siguiente sentencia para que los cambios tengan efecto:

```sql
FLUSH PRIVILEGES;
```
