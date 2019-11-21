-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2019 a las 15:39:42
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
-- Estructura de tabla para la tabla `archive_travels_conversations_meta`
--

CREATE TABLE `archive_travels_conversations_meta` (
  `conversation_id` char(36) NOT NULL,
  `following` tinyint(1) NOT NULL DEFAULT '0',
  `flag_type` char(1) DEFAULT NULL,
  `flag_comment` text,
  `state` char(1) NOT NULL DEFAULT 'N',
  `read_entry_count` int(11) NOT NULL DEFAULT '0',
  `income` decimal(10,2) DEFAULT NULL,
  `income_saving` decimal(10,2) DEFAULT NULL,
  `comments` text,
  `arrangement` text COMMENT 'Para los viajes prearreglados por los admin',
  `asked_confirmation` tinyint(1) NOT NULL DEFAULT '0',
  `received_confirmation_type` char(1) DEFAULT NULL COMMENT 'Y: yes, the travel was done; N: no, it was not done',
  `received_confirmation_details` text,
  `archived` tinyint(1) DEFAULT '0',
  `testimonial_requested` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archive_travels_conversations_meta`
--
ALTER TABLE `archive_travels_conversations_meta`
  ADD KEY `conversation_id` (`conversation_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
