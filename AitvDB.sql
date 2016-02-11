-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2015 a las 15:56:49
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `aitv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE IF NOT EXISTS `catalogo` (
  `Id_Cata` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `FechaUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_hojadevida`
--

CREATE TABLE IF NOT EXISTS `catalogo_hojadevida` (
  `Id` int(11) NOT NULL,
  `Id_Hojadevida` int(11) DEFAULT NULL,
  `Id_Catalogo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `Nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Apellidos` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha_Naci` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hojadevida`
--

CREATE TABLE IF NOT EXISTS `hojadevida` (
  `idHv` int(11) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Tel_Casa` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tel_Ce` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Telefono_Adic` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha_Nac` date NOT NULL,
  `Tipo_Documento` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `Nit` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Sexo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Lugar_Nacimiento` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ciudad` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dir_Casa` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email_Personal` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Estatura` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Piel` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ojos` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pelo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Peso` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Experiencia_TV` longtext COLLATE utf8_unicode_ci,
  `Deportes` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Habilidades` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Idiomas` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Maneja` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Entidad_Salud` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Categoria` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Talla_Camisa` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Talla_Chaqueta` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Talla_Pantalon` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Talla_Zapato` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DV` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estado` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `FechaUpdate` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image2` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` int(11) NOT NULL,
  `id_hojadevida` int(11) NOT NULL,
  `id_catalogo` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nit` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tarifa` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacion_general` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacion_detallada` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla`
--

CREATE TABLE IF NOT EXISTS `planilla` (
  `id` int(11) NOT NULL,
  `id_hojadevida` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `telCel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nit` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `asistencia` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `calificacion` int(11) NOT NULL,
  `observacion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE IF NOT EXISTS `solicitud` (
  `id_Solicitud` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Observaciones` text COLLATE utf8_unicode_ci,
  `Estado` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Fechainicio` datetime DEFAULT NULL,
  `Fechafin` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `File` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `FechaUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_catalogo`
--

CREATE TABLE IF NOT EXISTS `solicitud_catalogo` (
  `id` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Id_Solicitudes` int(11) DEFAULT NULL,
  `Id_Catalogos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_catalogo`
--

CREATE TABLE IF NOT EXISTS `usuario_catalogo` (
  `Id` int(11) NOT NULL,
  `Id_catalogo` int(11) DEFAULT NULL,
  `Id_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_solicitud`
--

CREATE TABLE IF NOT EXISTS `usuario_solicitud` (
  `Id` int(11) NOT NULL,
  `Id_Solicitud` int(11) DEFAULT NULL,
  `Id_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`Id_Cata`);

--
-- Indices de la tabla `catalogo_hojadevida`
--
ALTER TABLE `catalogo_hojadevida`
  ADD PRIMARY KEY (`Id`), ADD KEY `Id_Catalogo` (`Id_Catalogo`), ADD KEY `Id_Hojadevida` (`Id_Hojadevida`);

--
-- Indices de la tabla `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`), ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`);

--
-- Indices de la tabla `hojadevida`
--
ALTER TABLE `hojadevida`
  ADD PRIMARY KEY (`idHv`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planilla`
--
ALTER TABLE `planilla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_Solicitud`);

--
-- Indices de la tabla `solicitud_catalogo`
--
ALTER TABLE `solicitud_catalogo`
  ADD PRIMARY KEY (`id`), ADD KEY `Id_Solicitudes` (`Id_Solicitudes`), ADD KEY `Id_Catalogos` (`Id_Catalogos`);

--
-- Indices de la tabla `usuario_catalogo`
--
ALTER TABLE `usuario_catalogo`
  ADD PRIMARY KEY (`Id`), ADD KEY `Id_catalogo` (`Id_catalogo`), ADD KEY `Id_Usuario` (`Id_Usuario`);

--
-- Indices de la tabla `usuario_solicitud`
--
ALTER TABLE `usuario_solicitud`
  ADD PRIMARY KEY (`Id`), ADD KEY `Id_Solicitud` (`Id_Solicitud`), ADD KEY `Id_Usuario` (`Id_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `Id_Cata` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `catalogo_hojadevida`
--
ALTER TABLE `catalogo_hojadevida`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `hojadevida`
--
ALTER TABLE `hojadevida`
  MODIFY `idHv` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `planilla`
--
ALTER TABLE `planilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_Solicitud` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `solicitud_catalogo`
--
ALTER TABLE `solicitud_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario_catalogo`
--
ALTER TABLE `usuario_catalogo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario_solicitud`
--
ALTER TABLE `usuario_solicitud`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catalogo_hojadevida`
--
ALTER TABLE `catalogo_hojadevida`
ADD CONSTRAINT `FK_589D3B8467E214A4` FOREIGN KEY (`Id_Hojadevida`) REFERENCES `hojadevida` (`idHv`),
ADD CONSTRAINT `FK_589D3B84C89D6A51` FOREIGN KEY (`Id_Catalogo`) REFERENCES `catalogo` (`Id_Cata`);

--
-- Filtros para la tabla `solicitud_catalogo`
--
ALTER TABLE `solicitud_catalogo`
ADD CONSTRAINT `FK_7D374E8051FCEBE8` FOREIGN KEY (`Id_Solicitudes`) REFERENCES `solicitud` (`id_Solicitud`),
ADD CONSTRAINT `FK_7D374E807AA3303` FOREIGN KEY (`Id_Catalogos`) REFERENCES `catalogo` (`Id_Cata`);

--
-- Filtros para la tabla `usuario_catalogo`
--
ALTER TABLE `usuario_catalogo`
ADD CONSTRAINT `FK_F6D99DC31EB0807` FOREIGN KEY (`Id_catalogo`) REFERENCES `catalogo` (`Id_Cata`),
ADD CONSTRAINT `FK_F6D99DC7C182361` FOREIGN KEY (`Id_Usuario`) REFERENCES `fos_user` (`id`);

--
-- Filtros para la tabla `usuario_solicitud`
--
ALTER TABLE `usuario_solicitud`
ADD CONSTRAINT `FK_1FE996D27C182361` FOREIGN KEY (`Id_Usuario`) REFERENCES `fos_user` (`id`),
ADD CONSTRAINT `FK_1FE996D28C2799BC` FOREIGN KEY (`Id_Solicitud`) REFERENCES `solicitud` (`id_Solicitud`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
