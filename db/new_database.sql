-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2022 a las 08:02:12
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `confesiones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `baneos`
--

CREATE TABLE `baneos` (
  `id` int(11) NOT NULL,
  `ip_ban` varchar(32) NOT NULL,
  `razon` varchar(32) NOT NULL,
  `fecha_inicio` varchar(32) NOT NULL,
  `fecha_fin` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(12) NOT NULL,
  `nameweb` text NOT NULL,
  `descripcion` text NOT NULL,
  `image_og` varchar(32) NOT NULL,
  `logo` varchar(32) NOT NULL,
  `mantenimiento` int(1) NOT NULL DEFAULT 0,
  `confesiones` int(1) NOT NULL DEFAULT 1,
  `msg_mtni` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `nameweb`, `descripcion`, `image_og`, `logo`, `mantenimiento`, `confesiones`, `msg_mtni`) VALUES
(1, 'Confesiones anonimas', 'Este sitio es un pequeño espacio en el que puedes liberarte confesando aquello que siempre has querido contar de manera totalmente anónima', './assets/images/og.jpg', './assets/images/logo-navbar.png', 0, 1, 'Lamentablemente en este momento estamos en mantenimiento, estaremos de vuelva dentro de 2 horas. Puedes seguirnos en twi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conf_respuestas`
--

CREATE TABLE `conf_respuestas` (
  `id` int(11) NOT NULL,
  `id_conf` int(12) NOT NULL,
  `edad` int(2) NOT NULL,
  `genero` varchar(16) NOT NULL,
  `confesion` varchar(420) NOT NULL,
  `date_conf` varchar(32) NOT NULL,
  `time_conf` varchar(32) NOT NULL,
  `pais` varchar(12) DEFAULT NULL,
  `ip_user` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(12) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT 1,
  `avatar` varchar(120) NOT NULL DEFAULT 'img/logo-anom.png',
  `logeado` varchar(2) NOT NULL DEFAULT '0',
  `ip` varchar(32) NOT NULL,
  `pais` varchar(32) NOT NULL,
  `fecha_registro` varchar(32) NOT NULL,
  `last_pais` varchar(32) NOT NULL,
  `last_ip` varchar(32) NOT NULL,
  `last_date` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `username`, `password`, `rank`, `avatar`, `logeado`, `ip`, `pais`, `fecha_registro`, `last_pais`, `last_ip`, `last_date`) VALUES
(1, 'admin', 'e9fd363bedc114628fe2cdce1493db15', 4, 'img/logo-anom.png', '0', '127.0.0.1', 'CO', '2022-08-26 01:00:28', 'CO', '127.0.0.1', '2022-08-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitacion`
--

CREATE TABLE `invitacion` (
  `id` int(2) NOT NULL,
  `codigo` varchar(32) NOT NULL,
  `usado` int(1) DEFAULT NULL,
  `fecha_creacion` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_conf`
--

CREATE TABLE `logs_conf` (
  `id` int(11) NOT NULL,
  `id_conf` int(32) NOT NULL,
  `accion` varchar(120) NOT NULL,
  `ip_user` varchar(32) NOT NULL,
  `fecha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_login`
--

CREATE TABLE `logs_login` (
  `id` int(11) NOT NULL,
  `user_login` varchar(32) NOT NULL,
  `accion` varchar(210) NOT NULL,
  `pais_login` varchar(32) NOT NULL,
  `ip_login` varchar(32) NOT NULL,
  `fecha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logs_login`
--

INSERT INTO `logs_login` (`id`, `user_login`, `accion`, `pais_login`, `ip_login`, `fecha`) VALUES
(1, 'Sorac', 'ha cerrado la sesión', '', '', '2022-08-26 01:00:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_moderacion`
--

CREATE TABLE `logs_moderacion` (
  `id` int(12) NOT NULL,
  `ip_mod` varchar(32) NOT NULL,
  `pais` varchar(32) NOT NULL,
  `usuario` varchar(32) NOT NULL,
  `accion` varchar(128) NOT NULL,
  `fecha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logs_moderacion`
--

INSERT INTO `logs_moderacion` (`id`, `ip_mod`, `pais`, `usuario`, `accion`, `fecha`) VALUES
(1, '', '', 'admin', 'se registro en el panel administrativo', '2022-08-26 01:00:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_reportes`
--

CREATE TABLE `logs_reportes` (
  `id` int(12) NOT NULL,
  `ip_denunciante` varchar(32) NOT NULL,
  `accion` varchar(120) NOT NULL,
  `fecha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_sanciones`
--

CREATE TABLE `logs_sanciones` (
  `id` int(11) NOT NULL,
  `usuario` varchar(32) NOT NULL,
  `accion` varchar(32) NOT NULL,
  `ip_baneada` varchar(32) NOT NULL,
  `razon` varchar(120) NOT NULL,
  `fecha_inicio` varchar(32) NOT NULL,
  `fecha_fin` varchar(52) NOT NULL,
  `fecha_log` varchar(52) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_sospechosos`
--

CREATE TABLE `logs_sospechosos` (
  `id` int(11) NOT NULL,
  `user_logeado` varchar(32) NOT NULL,
  `accion` varchar(210) NOT NULL,
  `pais` varchar(32) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `fecha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangos`
--

CREATE TABLE `rangos` (
  `id` int(11) NOT NULL,
  `rank` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rangos`
--

INSERT INTO `rangos` (`id`, `rank`) VALUES
(1, 'Invitado'),
(2, 'Moderador'),
(3, 'Supervisor'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(12) NOT NULL,
  `id_conf` int(32) NOT NULL,
  `ip_denunciante` varchar(32) NOT NULL,
  `ip_denunciado` varchar(32) NOT NULL,
  `fecha` varchar(32) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `baneos`
--
ALTER TABLE `baneos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conf_respuestas`
--
ALTER TABLE `conf_respuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invitacion`
--
ALTER TABLE `invitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_conf`
--
ALTER TABLE `logs_conf`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_login`
--
ALTER TABLE `logs_login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_moderacion`
--
ALTER TABLE `logs_moderacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_reportes`
--
ALTER TABLE `logs_reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_sanciones`
--
ALTER TABLE `logs_sanciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_sospechosos`
--
ALTER TABLE `logs_sospechosos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rangos`
--
ALTER TABLE `rangos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `baneos`
--
ALTER TABLE `baneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conf_respuestas`
--
ALTER TABLE `conf_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `invitacion`
--
ALTER TABLE `invitacion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs_conf`
--
ALTER TABLE `logs_conf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs_login`
--
ALTER TABLE `logs_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `logs_moderacion`
--
ALTER TABLE `logs_moderacion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `logs_reportes`
--
ALTER TABLE `logs_reportes`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs_sanciones`
--
ALTER TABLE `logs_sanciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs_sospechosos`
--
ALTER TABLE `logs_sospechosos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rangos`
--
ALTER TABLE `rangos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
