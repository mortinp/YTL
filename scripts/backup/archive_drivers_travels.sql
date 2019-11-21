-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2019 a las 15:38:46
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yotellevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archive_drivers_travels`
--

CREATE TABLE `archive_drivers_travels` (
  `id` char(36) COLLATE latin1_bin NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `travel_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` char(1) COLLATE latin1_bin NOT NULL DEFAULT 'A' COMMENT 'Indicates how the driver was notified: automatically when the request was created, manually by an admin, or any other way',
  `last_driver_email` varchar(250) COLLATE latin1_bin NOT NULL,
  `message_count` int(11) NOT NULL DEFAULT '0',
  `notified_by` varchar(250) COLLATE latin1_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archive_drivers_travels`
--
ALTER TABLE `archive_drivers_travels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arch_dri_tra_driver_fk` (`driver_id`),
  ADD KEY `arch_dri_tra_travel_fk` (`travel_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archive_drivers_travels`
--
ALTER TABLE `archive_drivers_travels`
  ADD CONSTRAINT `arch_dri_tra_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `arch_dri_tra_ibfk_2` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
