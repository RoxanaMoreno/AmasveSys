-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2024 a las 23:26:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `amasve`
--
CREATE DATABASE IF NOT EXISTS `amasve` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `amasve`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aportaciones`
--

CREATE TABLE `aportaciones` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `socio_numero` int(11) NOT NULL,
  `id_recibo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aportaciones`
--

INSERT INTO `aportaciones` (`id`, `monto`, `fecha`, `descripcion`, `socio_numero`, `id_recibo`) VALUES
(1, 50.00, '2024-06-14', 'cuota junio 2024', 4567, 2),
(2, 50.00, '2024-06-14', 'cuota enero', 4567, 3),
(3, 50.00, '2024-06-14', 'cuota febrero', 4567, 4),
(4, 500.00, '2024-06-26', 'cuota marzo', 4567, 1),
(5, 50.00, '2024-06-14', 'cuota abril', 4567, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `documento_identidad` varchar(50) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `miembros_unidad_familiar_0_2` int(11) DEFAULT 0,
  `miembros_otras_edades` int(11) DEFAULT 0,
  `miembros_con_discapacidad` int(11) DEFAULT 0,
  `total_miembros` int(11) GENERATED ALWAYS AS (`miembros_unidad_familiar_0_2` + `miembros_otras_edades` + `miembros_con_discapacidad`) STORED,
  `fecha_registro` date NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT INTO `beneficiarios` (`id`, `nombre`, `apellidos`, `documento_identidad`, `direccion`, `telefono`, `email`, `miembros_unidad_familiar_0_2`, `miembros_otras_edades`, `miembros_con_discapacidad`, `fecha_registro`, `activo`) VALUES
(1023, 'Sofía', 'Ramírez', 'G0123456J', 'Calle de la Esperanza 606, Orihuela', '612345679', 'sofia.ramirez@example.com', 1, 3, 1, '2022-10-30', 1),
(1234, 'Juan', 'García', 'X1234567A', 'Calle Falsa 123, Alicante', '612345678', 'juan.garcia@example.com', 1, 3, 1, '2022-01-15', 1),
(2345, 'María', 'López', 'Y2345678B', 'Avenida Siempre Viva 742, Elche', '622345678', 'maria.lopez@example.com', 2, 2, 0, '2023-02-20', 1),
(3456, 'Pedro', 'Martínez', 'Z3456789C', 'Calle de la Luna 456, Torrevieja', '632345678', 'pedro.martinez@example.com', 0, 4, 1, '2021-03-10', 1),
(4567, 'Ana', 'Sánchez', 'A4567890D', 'Calle del Sol 789, Orihuela', '642345678', 'ana.sanchez@example.com', 1, 3, 0, '2020-04-18', 1),
(5678, 'Luis', 'Fernández', 'B5678901E', 'Calle de la Estrella 101, Benidorm', '652345678', 'luis.fernandez@example.com', 2, 1, 1, '2019-05-25', 1),
(6789, 'Carmen', 'Gómez', 'C6789012F', 'Calle de la Nube 202, Elda', '662345678', 'carmen.gomez@example.com', 0, 5, 0, '2018-06-30', 1),
(7890, 'José', 'Hernández', 'D7890123G', 'Avenida de la Paz 303, Alicante', '672345678', 'jose.hernandez@example.com', 1, 2, 1, '2017-07-15', 1),
(8901, 'Laura', 'Díaz', 'E8901234H', 'Calle de la Alegría 404, Elche', '682345678', 'laura.diaz@example.com', 2, 3, 0, '2016-08-20', 1),
(9012, 'Manuel', 'Ruiz', 'F9012345I', 'Avenida de la Amistad 505, Torrevieja', '692345678', 'manuel.ruiz@example.com', 0, 4, 1, '2015-09-25', 1);

--
-- Disparadores `beneficiarios`
--
DELIMITER $$
CREATE TRIGGER `ActualizarTotalMiembros` BEFORE INSERT ON `beneficiarios` FOR EACH ROW BEGIN
    SET NEW.total_miembros = NEW.miembros_unidad_familiar_0_2 + NEW.miembros_otras_edades + NEW.miembros_con_discapacidad;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios_eventos`
--

CREATE TABLE `beneficiarios_eventos` (
  `beneficiario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `beneficiarios_eventos`
--

INSERT INTO `beneficiarios_eventos` (`beneficiario_id`, `evento_id`) VALUES
(2345, 6),
(3456, 6),
(7890, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `ruta_documento` varchar(255) NOT NULL,
  `tipo_documento` varchar(50) DEFAULT NULL,
  `fecha_subida` date NOT NULL,
  `beneficiario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `ruta_documento`, `tipo_documento`, `fecha_subida`, `beneficiario_id`) VALUES
(1, '../documentos/666f551e5fc86_nie-nuevo.jpg', 'nie', '2024-06-16', 4567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `beneficiario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `fecha_entrega`, `descripcion`, `usuario_id`, `beneficiario_id`) VALUES
(13, '2024-06-16', 'Alimentos frescos y no perecederos junio', 1, 4567),
(14, '2024-06-16', 'alimentos frescos junio', 1, 7890),
(16, '2024-06-16', 'Ropa bebe y pañales', 1, 6789);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `organizador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nombre`, `descripcion`, `fecha`, `lugar`, `organizador_id`) VALUES
(1, 'Concierto de Rock', 'Un concierto de rock con bandas locales.', '2024-07-15', 'Multiespacio Rabasa', 77),
(2, 'Feria de la Ciencia', 'Una feria para mostrar proyectos científicos de estudiantes.', '2024-08-20', 'Centro de Convenciones', 64),
(4, 'Festival de Comida', 'Festival con comidas típicas de la región.', '2024-10-05', 'Plaza Séneca', 77),
(6, 'Galería', 'Exposición  fotos', '2024-06-13', 'Cigarrreras', 64),
(7, 'Feria Artesana', 'Artesanía hispanoamericana', '2024-07-07', 'Centro cultural AMASVE', 64),
(11, 'Desfile', 'Desfile Internacional de Hogueras', '2024-06-23', 'Alfonso el Sabio', 64),
(15, 'Cine', 'Proyección de documentales', '2024-07-01', 'Centro cultural calle Sargento Vaillo', 78);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `fecha`, `monto`, `detalles`) VALUES
(1, '2024-06-26', 500.00, 'cuota marzo'),
(2, '2024-06-14', 50.00, 'cuota junio 2024'),
(3, '2024-06-14', 50.00, 'cuota enero'),
(4, '2024-06-14', 50.00, 'cuota febrero'),
(5, '2024-06-14', 50.00, 'cuota abril');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `socio_numero` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `documento_identidad` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `recibir_informacion` tinyint(1) DEFAULT 0,
  `iban` varchar(50) DEFAULT NULL,
  `fecha_inscripcion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`socio_numero`, `nombres`, `apellidos`, `documento_identidad`, `email`, `telefono`, `recibir_informacion`, `iban`, `fecha_inscripcion`) VALUES
(1234, 'Juan', 'García', 'X1234567A', 'juan.garcia@example.com', '612345678', 1, 'ES9121000418450200051332', '2022-01-15'),
(2345, 'María', 'López', 'Y2345678B', 'maria.lopez@example.com', '622345678', 0, 'ES4512345678901234567890', '2023-02-20'),
(3456, 'Pedro', 'Martínez', 'Z3456789C', 'pedro.martinez@example.com', '632345678', 1, 'ES5501820432041234567890', '2021-03-10'),
(4567, 'Ana Mercedes ', 'Sánchez Rodríguez ', 'A4567890D', 'ana.sanchez@example.com', '642345678', 0, 'ES21007512309876543210984', '2020-04-18'),
(5678, 'Luis', 'Fernández', 'B5678901E', 'luis.fernandez@example.com', '652345678', 1, 'ES1200987654321098765432', '2019-05-25'),
(6789, 'Carmen', 'Gómez', 'C6789012F', 'carmen.gomez@example.com', '662345678', 0, 'ES2309876543210987654321', '2018-06-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('administrador','pro','basic') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `contrasena`, `rol`) VALUES
(1, 'admin', '$2y$10$hjV8eRvfdoXtRfExsIzlsecB/wSH344ND03EwiSQPBu9dfc7oteWK', 'administrador'),
(2, 'pro', '$2y$12$orL9pZ8cTqOvLflHqv2Gt.Ogf2Y9QPFI0dxEHrKQPHPw1fTQbIIui', 'pro'),
(3, 'basic', '$2y$12$MMSzKmJHDLvco/PHXp4u5.opcH.EpwSBxKQ/ajFJ0jUvUM1qZ3Qle', 'basic'),
(4, 'prueba', '$2y$12$orL9pZ8cTqOvLflHqv2Gt.Ogf2Y9QPFI0dxEHrKQPHPw1fTQbIIui', 'administrador');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistabeneficiarioseventos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistabeneficiarioseventos` (
`beneficiario_id` int(11)
,`nombre` varchar(100)
,`apellidos` varchar(100)
,`evento_id` int(11)
,`nombre_evento` varchar(100)
,`fecha` date
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistaentregasusuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistaentregasusuarios` (
`entrega_id` int(11)
,`fecha_entrega` date
,`descripcion` text
,`usuario_id` int(11)
,`usuario_nombre` varchar(50)
,`beneficiario_id` int(11)
,`beneficiario_nombre` varchar(100)
,`beneficiario_apellidos` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistavoluntarioseventos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistavoluntarioseventos` (
`voluntario_id` int(5)
,`nombres` varchar(100)
,`apellidos` varchar(100)
,`evento_id` int(11)
,`nombre_evento` varchar(100)
,`fecha` date
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios`
--

CREATE TABLE `voluntarios` (
  `id` int(5) NOT NULL,
  `numero_identificacion` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `voluntarios`
--

INSERT INTO `voluntarios` (`id`, `numero_identificacion`, `nombres`, `apellidos`, `telefono`, `email`, `localidad`) VALUES
(64, '12345678A', 'Roxana', 'Moreno Rondón', '612345678', 'roxana.moreno@example.com', 'Alicante centro'),
(65, '23456789B', 'Juan Carlos', 'López García', '622345679', 'juan.carlos@example.com', 'Elche'),
(66, '34567890C', 'María', 'Fernández Martínez', '632345680', 'maria.fernandez@example.com', 'Benidorm'),
(69, '67890123F', 'José A', 'Martínez López', '662345683', 'jose.martinez@example.com', 'Alcoy'),
(70, '78901234G', 'Laura', 'Hernández González', '672345684', 'laura.hernandez@example.com', 'Novelda'),
(71, '89012345H', 'Carmen', 'López García', '682345685', 'carmen.lopez@example.com', 'San Vicente'),
(73, '01234567J', 'Lucía', 'Pérez Fernández', '702345687', 'lucia.perez@example.com', 'Denia'),
(74, '11234568K', 'Miguel', 'García Rodríguez', '712345688', 'miguel.garcia@example.com', 'Petrer'),
(75, '21234569L', 'Elena Beatriz', 'Martínez Sánchez', '722345689', 'elena.martinez@example.com', 'Santa Pola'),
(77, '41234571N', 'Raúl', 'García López', '742345691', 'raul.garcia@example.com', 'Crevillente'),
(78, '51234572O', 'Sofía', 'Rodríguez González', '752345692', 'sofia.rodriguez@example.com', 'Benissa'),
(79, '87693608T', 'Prueba', 'Mayúsculas', '654372819', 'prueba@g.com', 'Alicante'),
(110, 'Y4627759N', 'Roxana Andreina', 'Moreno Rondon', '654172308', 'moren@gmail.com', 'Alicante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios_eventos`
--

CREATE TABLE `voluntarios_eventos` (
  `voluntario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `voluntarios_eventos`
--

INSERT INTO `voluntarios_eventos` (`voluntario_id`, `evento_id`) VALUES
(69, 6),
(70, 6),
(73, 6),
(78, 6),
(110, 6);

-- --------------------------------------------------------

--
-- Estructura para la vista `vistabeneficiarioseventos`
--
DROP TABLE IF EXISTS `vistabeneficiarioseventos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistabeneficiarioseventos`  AS SELECT `b`.`id` AS `beneficiario_id`, `b`.`nombre` AS `nombre`, `b`.`apellidos` AS `apellidos`, `e`.`id` AS `evento_id`, `e`.`nombre` AS `nombre_evento`, `e`.`fecha` AS `fecha` FROM ((`beneficiarios` `b` join `beneficiarios_eventos` `be` on(`b`.`id` = `be`.`beneficiario_id`)) join `eventos` `e` on(`be`.`evento_id` = `e`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistaentregasusuarios`
--
DROP TABLE IF EXISTS `vistaentregasusuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistaentregasusuarios`  AS SELECT `e`.`id` AS `entrega_id`, `e`.`fecha_entrega` AS `fecha_entrega`, `e`.`descripcion` AS `descripcion`, `u`.`id_usuario` AS `usuario_id`, `u`.`nombre_usuario` AS `usuario_nombre`, `b`.`id` AS `beneficiario_id`, `b`.`nombre` AS `beneficiario_nombre`, `b`.`apellidos` AS `beneficiario_apellidos` FROM ((`entregas` `e` join `usuarios` `u` on(`e`.`usuario_id` = `u`.`id_usuario`)) join `beneficiarios` `b` on(`e`.`beneficiario_id` = `b`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistavoluntarioseventos`
--
DROP TABLE IF EXISTS `vistavoluntarioseventos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistavoluntarioseventos`  AS SELECT `v`.`id` AS `voluntario_id`, `v`.`nombres` AS `nombres`, `v`.`apellidos` AS `apellidos`, `e`.`id` AS `evento_id`, `e`.`nombre` AS `nombre_evento`, `e`.`fecha` AS `fecha` FROM ((`voluntarios` `v` join `voluntarios_eventos` `ve` on(`v`.`id` = `ve`.`voluntario_id`)) join `eventos` `e` on(`ve`.`evento_id` = `e`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socio_numero` (`socio_numero`),
  ADD KEY `fk_aportaciones_recibos` (`id_recibo`);

--
-- Indices de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `beneficiarios_eventos`
--
ALTER TABLE `beneficiarios_eventos`
  ADD PRIMARY KEY (`beneficiario_id`,`evento_id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiario_id` (`beneficiario_id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiario_id` (`beneficiario_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_organizador_id` (`organizador_id`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`socio_numero`),
  ADD UNIQUE KEY `dni_nie_nif_pasaporte` (`documento_identidad`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `voluntarios`
--
ALTER TABLE `voluntarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`) USING BTREE;

--
-- Indices de la tabla `voluntarios_eventos`
--
ALTER TABLE `voluntarios_eventos`
  ADD PRIMARY KEY (`voluntario_id`,`evento_id`),
  ADD KEY `FK_evento_id` (`evento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9014;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `socio_numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6797;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `voluntarios`
--
ALTER TABLE `voluntarios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  ADD CONSTRAINT `aportaciones_ibfk_1` FOREIGN KEY (`socio_numero`) REFERENCES `socios` (`socio_numero`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_aportaciones_recibos` FOREIGN KEY (`id_recibo`) REFERENCES `recibos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `beneficiarios_eventos`
--
ALTER TABLE `beneficiarios_eventos`
  ADD CONSTRAINT `beneficiarios_eventos_ibfk_1` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id`),
  ADD CONSTRAINT `beneficiarios_eventos_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id`);

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_2` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id`),
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_organizador_id` FOREIGN KEY (`organizador_id`) REFERENCES `voluntarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `voluntarios_eventos`
--
ALTER TABLE `voluntarios_eventos`
  ADD CONSTRAINT `FK_evento_id` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`),
  ADD CONSTRAINT `FK_voluntario_id` FOREIGN KEY (`voluntario_id`) REFERENCES `voluntarios` (`id`),
  ADD CONSTRAINT `voluntarios_eventos_ibfk_1` FOREIGN KEY (`voluntario_id`) REFERENCES `voluntarios` (`id`),
  ADD CONSTRAINT `voluntarios_eventos_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
