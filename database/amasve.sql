-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2024 a las 09:21:19
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
-- Estructura de tabla para la tabla `datos_bancarios`
--

CREATE TABLE `datos_bancarios` (
  `id` int(11) NOT NULL,
  `socio_numero` int(11) NOT NULL,
  `codigo_entidad` varchar(4) NOT NULL,
  `numero_sucursal` varchar(4) NOT NULL,
  `dc` varchar(2) NOT NULL,
  `numero_cuenta` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `socio_numero` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `dni_nie_nif_pasaporte` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `profesion_ocupacion` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telefono_fijo` varchar(20) DEFAULT NULL,
  `telefono_movil` varchar(20) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `localidad` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `recibir_informacion` tinyint(1) DEFAULT 0,
  `forma_pago` enum('mensual','trimestral','semestral','anual') NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'admin123', '$2y$10$hjV8eRvfdoXtRfExsIzlsecB/wSH344ND03EwiSQPBu9dfc7oteWK', 'administrador'),
(2, 'voluntario1', '$2y$12$orL9pZ8cTqOvLflHqv2Gt.Ogf2Y9QPFI0dxEHrKQPHPw1fTQbIIui', 'pro'),
(3, 'voluntario2', '$2y$12$MMSzKmJHDLvco/PHXp4u5.opcH.EpwSBxKQ/ajFJ0jUvUM1qZ3Qle', 'basic'),
(4, 'prueba', '$2y$12$orL9pZ8cTqOvLflHqv2Gt.Ogf2Y9QPFI0dxEHrKQPHPw1fTQbIIui', 'administrador');

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
(1, '12345678A', 'Carlos andres', 'Pérez', '600123456', 'carlos.perez@example.com', 'Benidorm'),
(2, '87654321B', 'Ana Maria D', 'García', '601234569', 'ana.garcia@example.com', 'Elche'),
(3, '12348765C', 'Luis', 'Martínez', '602345678', 'luis.martinez@example.com', 'Torrevieja'),
(4, '87651234D', 'María', 'Rodríguez', '603456789', 'maria.rodriguez@example.com', 'Orihuela'),
(5, '13579246E', 'Juan Jose', 'López', '604567890', 'juan.lopez@example.com', 'Alcoy'),
(6, '24681357F', 'Lucía', 'González', '605678901', 'lucia.gonzalez@example.com', 'Elda'),
(7, '97531864G', 'Jorge', 'Hernández', '606789012', 'jorge.hernandez@example.com', 'Villena'),
(8, '86429751H', 'Laura', 'Fernández', '607890123', 'laura.fernandez@example.com', 'San Vicente del Raspeig'),
(9, '75315982I', 'Pedro', 'Sánchez', '608901234', 'pedro.sanchez@example.com', 'Centro'),
(10, '95175328J', 'Elena', 'Torres Tovar', '609012345', 'elena.torres@example.com', 'San Gabriel'),
(16, 'Y4627759N', 'Roxana', 'Moreno Rondon', '654172308', 'morenor@gmail.com', 'centro');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_bancarios`
--
ALTER TABLE `datos_bancarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socio_numero` (`socio_numero`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`socio_numero`),
  ADD UNIQUE KEY `dni_nie_nif_pasaporte` (`dni_nie_nif_pasaporte`),
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
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_bancarios`
--
ALTER TABLE `datos_bancarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `socio_numero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `voluntarios`
--
ALTER TABLE `voluntarios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_bancarios`
--
ALTER TABLE `datos_bancarios`
  ADD CONSTRAINT `datos_bancarios_ibfk_1` FOREIGN KEY (`socio_numero`) REFERENCES `socios` (`socio_numero`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
