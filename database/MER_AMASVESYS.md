# Modelo Entidad-Relación Base de Datos AMASVE

## 1. Entidades y Atributos

### ASOCIACION
- id (INT)
- nombre (VARCHAR)
- cif (VARCHAR)
- telefono (VARCHAR)
- localidad (VARCHAR)
- representante (VARCHAR)

### VOLUNTARIO
- id (INT)
- nombres (VARCHAR)
- apellidos (VARCHAR)
- numero_identificacion (VARCHAR)
- telefono (VARCHAR)
- email (VARCHAR)
- localidad (VARCHAR)

### SOCIO
- socio_numero (INT)
- nombres (VARCHAR)
- apellidos (VARCHAR)
- dni_nie_nif_pasaporte (VARCHAR)
- profesion_ocupacion (VARCHAR)
- email (VARCHAR)
- telefono_movil (VARCHAR)
- localidad (VARCHAR)
- cp (VARCHAR)
- nacionalidad (VARCHAR)
- recibir_informacion (BOOLEAN)
- iban (VARCHAR)
- fecha_inscripcion (TIMESTAMP)

### BENEFICIARIO
- id (INT)
- nombre (VARCHAR)
- apellidos (VARCHAR)
- documento_identidad (VARCHAR)
- direccion (VARCHAR)
- telefono (VARCHAR)
- email (VARCHAR)
- miembros_unidad_familiar_0_2 (INT)
- miembros_otras_edades (INT)
- miembros_con_discapacidad (INT)
- total_miembros (INT)
- fecha_registro (DATE)
- activo (BOOLEAN)

### EVENTO
- id (INT)
- nombre (VARCHAR)
- descripcion (TEXT)
- fecha (DATE)
- lugar (VARCHAR)
- organizador_id (INT)

### ENTREGA
- id (INT)
- fecha_entrega (DATE)
- descripcion (TEXT)
- usuario_id (INT)
- beneficiario_id (INT)

### DOCUMENTO
- id (INT)
- ruta_documento (VARCHAR)
- tipo_documento (VARCHAR)
- fecha_subida (DATE)
- beneficiario_id (INT)

### USUARIO
- id (INT)
- nombre (VARCHAR)
- apellidos (VARCHAR)
- email (VARCHAR)
- password (VARCHAR)

### APORTACION
- id (INT)
- socio_numero (INT)
- monto (DECIMAL)
- fecha (DATE)
- recibo_id (INT)

### RECIBO
- id (INT)
- fecha (DATE)
- monto (DECIMAL)
- socio_numero (INT)

## 2. Relaciones

- VOLUNTARIO puede_ser SOCIO
- VOLUNTARIO puede_ser BENEFICIARIO
- ASOCIACION tiene USUARIO
- VOLUNTARIO participa en uno o más EVENTO
- EVENTO incluye uno o más VOLUNTARIO
- BENEFICIARIO participa en uno o más EVENTO
- EVENTO incluye uno o más BENEFICIARIO
- SOCIO realiza una APORTACION
- APORTACION genera un RECIBO
- USUARIO realiza una ENTREGA
- BENEFICIARIO recibe una ENTREGA
- BENEFICIARIO tiene uno o más DOCUMENTO
- USUARIO organiza uno o más EVENTO
- ASOCIACION tiene uno o más VOLUNTARIO
- ASOCIACION tiene uno o más SOCIO
- ASOCIACION tiene uno o más BENEFICIARIO
