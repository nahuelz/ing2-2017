-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2017 a las 11:26:15
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
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id` int(11) NOT NULL,
  `comentario` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idFavor` int(11) NOT NULL,
  `calificacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
  `fecha` datetime NOT NULL,
  `fechaRespuesta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `precioUnitario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`id`, `usuarioId`, `precioUnitario`, `cantidad`, `fecha`) VALUES
(1, 2, 20, 10, '2017-05-25'),
(2, 2, 20, 20, '2017-05-25'),
(3, 2, 20, 20, '2017-05-25'),
(4, 2, 20, 20, '2017-05-25'),
(5, 2, 20, 20, '2017-05-25'),
(6, 2, 20, 20, '2017-05-25'),
(7, 2, 20, 20, '2017-05-25'),
(8, 2, 20, 20, '2017-05-25'),
(9, 2, 20, 20, '2017-05-25'),
(10, 1, 20, 1241, '2017-05-28'),
(11, 1, 20, 1, '2017-05-28'),
(12, 1, 20, 1, '2017-05-28'),
(13, 1, 20, 1, '2017-05-28'),
(14, 1, 20, -3000, '2017-05-30'),
(15, 1, 20, 1, '2017-05-30'),
(16, 1, 20, 760, '2017-05-30'),
(17, 1, 20, 1, '2017-05-30'),
(18, 1, 20, 10, '2017-06-06'),
(19, 1, 20, 10, '2017-06-17');

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
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUsuarioAceptado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `favor`
--

INSERT INTO `favor` (`id`, `usuario_id`, `titulo`, `descripcion`, `categoria`, `localidad`, `fecha_publicacion`, `estado`, `imagen`, `idUsuarioAceptado`) VALUES
(29, 1, 'ASDSADSAD', '  ASDASFASFAFAF', 1, 'Laprida', '2017-06-17', 'A', '', NULL),
(30, 1, '222222', '  22222', 2, 'Olavarria', '2017-06-17', 'A', '', NULL),
(31, 1, 'FAFAFA', '      GGGGGGGGGG    ', 2, 'Bolivar', '2017-06-17', 'A', '', NULL),
(32, 1, 'AAAA', '          sdgsdgsdg        ', 1, 'Azul', '2017-06-17', 'A', 'mudanza.jpg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `id` int(11) NOT NULL,
  `idFavor` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `comentario` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE `precio` (
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `precio`
--

INSERT INTO `precio` (`precio`) VALUES
(20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reputacion`
--

CREATE TABLE `reputacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `inicio` int(11) NOT NULL,
  `fin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reputacion`
--

INSERT INTO `reputacion` (`id`, `nombre`, `inicio`, `fin`) VALUES
(44, 'Muy Baja', -1000, -501),
(45, 'Baja', -500, -1),
(46, 'Alta', 0, 499),
(47, 'Muy Alta', 500, 999);

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
  `localidad` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `creditos` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `puntos` int(11) NOT NULL,
  `esAdmin` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `localidad`, `creditos`, `puntos`, `esAdmin`, `habilitado`) VALUES
(1, 'Admin', 'Admin', 'admin@admin', 'admin', '123456789', 'Bolivar', '38', 2, '1', 0),
(2, 'pepe', 'pepe', 'pepe@pepe', 'pepe', '123', 'Bolivar', '140', 0, '0', 0),
(3, 'pepa', 'pepa', 'pepa@pepa', 'pepa', '123456', 'Bolivar', '1', 0, '0', 1),
(4, '1234', '1233', 'hola@hola', '1234', '123', '', '1', 0, '0', 1),
(5, 'asdf', 'asdf', 'asd@asd', 'asdf', '1', '', '1', 0, '0', 1),
(6, 'pipi', 'pipi', 'pipi@pipi', 'pipi', '03034567', 'Olavarria', '1', 0, '0', 1),
(7, 'popo', 'popo', 'popo@popo', 'popo', '0303456', 'Azul', '1', 0, '0', 1),
(8, 'asdf', 'asdf', 'asdf@asdf', 'asdf', '1234567', 'Tandil', '1', 0, '0', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
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
-- Indices de la tabla `reputacion`
--
ALTER TABLE `reputacion`
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
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `favor`
--
ALTER TABLE `favor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reputacion`
--
ALTER TABLE `reputacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
