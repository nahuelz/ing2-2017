-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2017 a las 15:26:08
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ing2017`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `habilitada` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `habilitada`) VALUES
(1, 'nombreCategoria1', 1),
(2, 'nombreCategoria2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idFavor` int(11) NOT NULL,
  `comentario` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreUsuario` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `idUsuario`, `idFavor`, `comentario`, `respuesta`, `nombreUsuario`, `fecha`) VALUES
(19, 2, 1, ' hola', 'chau', 'pepe', '2017-05-24 01:17:06'),
(20, 2, 1, ' asd', 'chau2', 'pepe', '2017-05-24 01:22:29'),
(21, 2, 1, ' asfaf', NULL, 'pepe', '2017-05-24 01:23:27'),
(22, 2, 1, ' asfaf', NULL, 'pepe', '2017-05-24 01:25:08'),
(23, 2, 1, ' asfaf', NULL, 'pepe', '2017-05-24 01:25:36'),
(24, 1, 4, ' Hola', NULL, 'Admin', '2017-05-24 02:08:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favor`
--

CREATE TABLE `favor` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` int(11) NOT NULL,
  `localidad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `cerrada` int(1) NOT NULL,
  `imagen` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `favor`
--

INSERT INTO `favor` (`id`, `usuario_id`, `titulo`, `descripcion`, `categoria`, `localidad`, `fecha_publicacion`, `cerrada`, `imagen`) VALUES
(1, 1, 'ggggggggggggggg', 'ggggggggggggggg', 1, 'Azul', '2017-05-12', 0, ''),
(2, 1, 'asd', 'asd', 1, 'Azul', '2017-05-12', 0, ''),
(3, 1, 'un titulo', 'lorem impsu', 2, 'Azul', '2017-05-24', 0, ''),
(4, 2, 'NUEVO', 'NUEVO', 1, 'Azul', '2017-05-24', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `id` int(11) NOT NULL,
  `idFavor` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `postulacion`
--

INSERT INTO `postulacion` (`id`, `idFavor`, `idUsuario`, `estado`) VALUES
(1, 1, 2, 'E'),
(2, 1, 1, 'E'),
(3, 3, 1, 'E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `creditos` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `esAdmin` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `creditos`, `esAdmin`, `habilitado`) VALUES
(1, 'Admin', 'Admin', 'admin@admin', 'admin', '123456789', '999', '1', 0),
(2, 'pepe', 'pepe', 'pepe@pepe', 'pepe', '123', '1', '0', 0),
(3, 'pepa', 'pepa', 'pepa@pepa', 'pepa', '123', '1', '0', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favor`
--
ALTER TABLE `favor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `favor`
--
ALTER TABLE `favor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
