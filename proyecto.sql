-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2024 a las 21:27:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `responsable_dep` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `name`, `responsable_dep`) VALUES
(1, 'Tecnología', 'Administrador'),
(2, 'Departamento de bienes y almacén', 'Maria Vivas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `equipo` varchar(80) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `n_bien` varchar(8) NOT NULL,
  `disponible` tinyint(4) NOT NULL,
  `estatus` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `equipo`, `descripcion`, `n_bien`, `disponible`, `estatus`, `activo`) VALUES
(2, 'Dell Optiplex 7030', 'I5 3ra Gen, 4GB RAM, SSD 120G', '528532', 0, 1, 0),
(3, 'HP ProDesk', 'Intel Core I5 4ta Gen. 256 SDD y 500HDD, 12 GB RAM', '04262168', 0, 0, 0),
(4, 'Asus Aspiron 3000', 'AMD Athlon X2, 4GB RAM, 320GB HDD, Bolso, Cargador', '58115741', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id` int(11) NOT NULL,
  `equipo` int(11) NOT NULL,
  `fecha_mant` date NOT NULL,
  `usuario` int(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `mantenimientos`
--

INSERT INTO `mantenimientos` (`id`, `equipo`, `fecha_mant`, `usuario`, `observaciones`) VALUES
(1, 2, '2024-08-20', 10, 'Limpieza al equipo S/N'),
(4, 4, '2024-09-17', 14, 'Limpieza al equipo S/N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `equipo` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `funcionario` varchar(80) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `motivo` varchar(80) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `observaciones` varchar(255) NOT NULL,
  `n_control` varchar(50) DEFAULT NULL,
  `defeated` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `equipo`, `usuario`, `type`, `funcionario`, `cargo`, `motivo`, `date`, `observaciones`, `n_control`, `defeated`) VALUES
(2, 3, 10, 0, 'Diego', 'Coordinador', 'Auditoria', '2024-09-11 09:47:37', 'Se entrega en buenas condiciones', '66e19f7918bfe', 0),
(3, 2, 10, 0, 'Pepe', 'Coordinador', 'Auditoria', '2024-09-11 10:29:29', 'Sin observaciones', '66e1a94931984', 0),
(4, 3, 10, 1, 'Jorge', 'Coordinador', 'Auditoria', '2024-09-11 10:58:09', 'Se recibe en buenas condiciones', NULL, 1),
(5, 4, 10, 0, 'Omar Rivero', 'Abogado Auditor', 'Jornada de auditoría', '2024-09-12 19:46:59', 'Se entrega en excelentes condiciones', '66e37d7330e33', 0),
(6, 2, 10, 1, 'Pepe', 'Auditor', 'Auditoria', '2024-09-12 19:52:59', 'S/O', NULL, 1),
(7, 4, 14, 1, 'Omar Rivero', 'Auditor', 'Jornada de auditoría', '2024-09-17 11:13:41', 'Sin observaciones, entrega en buen estado', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `ci` varchar(8) NOT NULL,
  `n_carnet` varchar(7) NOT NULL,
  `departamento` int(11) NOT NULL,
  `rol` tinyint(4) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `ci`, `n_carnet`, `departamento`, `rol`, `estatus`, `username`, `password`) VALUES
(10, 'Derek', 'Ramos', '29751122', '8989898', 1, 0, 0, 'derek', '$2y$10$QfY8ncSkh4Lfm9rhOjNuT.PzR0O5lkcRe9EZHfOyE5AzNvysg/WAi'),
(11, 'prueba', 'deshabilitar', '79879779', '7987779', 1, 2, 1, 'editado', '$2y$10$gPXp.bkY9/7iVPI415/wp.1RVYNXg/gc53FP4sHFcTwNlXpeI8uKi'),
(12, 'Prueba', 'prueba', '89989789', '7899898', 1, 3, 1, 'prueba', '$2y$10$e90x14QL66UBDDpUbzpOT.1JBSidxEA..9Tn2dDwjRhju4SEniJQe'),
(13, 'José', 'Peña', '18000000', '123456', 1, 0, 0, 'peña', '$2y$10$cy7U9u5PjN993XtOjPq1Zeu0tRQLJ7timGC1a21pJFj7YVLo3vjjK'),
(14, 'Analista', 'Tecnologia', '56565656', '8989898', 1, 1, 0, 'analista', '$2y$10$1Ee6eSHOlHcVW8Wfq82U9ujC2spNIJ3IGwlsbqWMvFgSnpXMxhOwa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Equipo` (`equipo`),
  ADD KEY `FK_Usuario` (`usuario`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `n_control` (`n_control`),
  ADD KEY `equipo` (`equipo`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento` (`departamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `mantenimientos_ibfk_1` FOREIGN KEY (`equipo`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mantenimientos_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`equipo`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`departamento`) REFERENCES `departamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
