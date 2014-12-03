-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-10-2014 a las 20:12:24
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `yotellevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'driver',
  `max_people_count` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `has_modern_car` tinyint(1) NOT NULL,
  `has_air_conditioner` tinyint(1) NOT NULL,
  `description` varchar(250) NOT NULL,
  `travel_count` bigint(20) NOT NULL,
  `travel_by_email_count` bigint(20) NOT NULL,
  `last_notification_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `drivers`
--

INSERT INTO `drivers` (`id`, `username`, `password`, `role`, `max_people_count`, `active`, `has_modern_car`, `has_air_conditioner`, `description`, `travel_count`, `travel_by_email_count`, `last_notification_date`) VALUES
(7, 'eduartd@nauta.cu', 'b074e2f38af8d33d8026b4facf2a6bfc03e4f77f', 'driver', 4, 0, 0, 0, 'Ernesto (Moskovich)', 1, 0, '0000-00-00 00:00:00'),
(8, 'wary@dps.grm.sld.cu', 'f1ed9dc220787b7570dd4bf76f0b29205e55562a', 'driver', 4, 1, 1, 1, 'Wary (VW Polo)', 2, 0, '2014-09-08 02:00:46'),
(9, 'rricardo@grm.desoft.cu', '2773b7ee46895cf2b2f38fcb80f1403c1f136ec0', 'driver', 4, 0, 0, 0, 'Nello (Lada)', 0, 0, '0000-00-00 00:00:00'),
(11, 'mproenza@grm.desoft.cu', '60dd56fce363a2e493ae60bfdc64a9dffb0b227b', 'driver_tester', 4, 1, 1, 1, 'Martín (testing)', 22, 1, '2014-09-08 16:17:51'),
(12, 'yoelt@nauta.cu', 'afbffb5f53e46c239e221925ba7871773fd67c9f', 'driver', 4, 1, 1, 1, 'Yoel Toledano (El pollo), Citroen C5 2008', 2, 0, '2014-09-08 02:00:46'),
(13, 'cl8ff@frcuba.co.cu', '6c4279ec98f5799eacc782d98f86b739ab1b7b06', 'driver', 4, 0, 0, 0, 'Paqui (Moskovich Aleco)', 0, 0, '0000-00-00 00:00:00'),
(14, 'Kevin.pellicer@nauta.cu', '4ff9d19ef18919fdf95eb1eca65467093de8bd70', 'driver', 4, 1, 0, 0, 'Alberto Pellicer Rodríguez (43-1536, 52569900), Lada', 2, 0, '2014-09-08 02:00:46'),
(16, 'sanchez@granma.copextel.com.cu', 'a21149656d0c0d11fcc75aedada815879b445a1d', 'driver', 4, 1, 1, 1, 'José A. Sánchez (El médico) (Renault SM3)', 2, 0, '0000-00-00 00:00:00'),
(17, 'carlosrm111@gmail.com', 'baffc19e71f28ab6ac86d54b8603f1f9db3d3d1b', 'driver', 6, 1, 1, 1, 'Peugeot 405', 3, 1, '2014-09-02 15:25:01'),
(18, 'zacarias85@nauta.cu', 'ccbddb8cc88e4fb27414082e97605639a902d44a', 'driver', 4, 1, 0, 0, 'Moskovich', 1, 0, '0000-00-00 00:00:00'),
(19, 'jbjorgeton227@gmail.com', '2bd25c88a68fffd36308d79d3f4b6c567055b556', 'driver', 4, 1, 0, 0, 'Lada', 2, 0, '2014-09-03 08:32:27'),
(20, 'ronald.caballero@nauta.cu', '94777760361e1f5c78b97537374b23839fcc1331', 'driver', 6, 1, 0, 0, 'Pontiac Clásico, viajes por el Oriente nada más', 2, 0, '2014-09-03 08:32:27'),
(21, 'eduardotorres@nauta.cu', '742270a2a3bf58888dad85e806c611a141474b71', 'driver', 4, 1, 1, 1, 'Citroen ZX', 1, 1, '0000-00-00 00:00:00'),
(24, 'nelsonperezga@gmail.com', '83393f2e63ac9c4dce02facf16080978b7137fdb', 'driver', 4, 1, 1, 1, 'Nelson Pérez Gámez, Hyundai Accent 2009', 2, 0, '0000-00-00 00:00:00'),
(28, 'ymachin@radioangulo.icrt.cu', 'a0bd0d260eaa09a39b8418cbefde829af49513d3', 'driver', 4, 1, 0, 0, 'Ezequiel Borges Avila (Lada 1600), 58154841, (462550->Santos Cid, dueño del carro)', 0, 0, '0000-00-00 00:00:00'),
(29, 'radapi@nauta.cu', '2a8b7a5082f5a35cacec8d87c3a5b8e94a9bc0ce', 'driver', 4, 1, 1, 1, 'Hyundai Atos', 2, 1, '0000-00-00 00:00:00'),
(30, 'alejandro.lazo@nauta.cu', '063019bdf57996265b7ad131c2428679202741c9', 'driver', 4, 1, 1, 1, 'Peugeot 405', 2, 0, '2014-09-03 08:32:27'),
(32, 'cubamitaxi@gmail.com', '698609283b19a41cfcf4dd38c4b78f015f89d467', 'driver', 14, 1, 1, 1, 'Autos para 3 pasajeros Autos para 4 pasajeros Autos de Lujo para 4 pasajeros Autos VAN para 7 pasajeros Autos VAN para 10 pasajeros Autos VAN para 14 pasajeros', 27, 1, '2014-09-19 23:10:10'),
(33, 'yproenza003@gmail.com', '11d73e76166b34c786ff3227813b3a467818c264', 'driver_tester', 4, 1, 1, 1, 'Yuni (mi hermano)', 1, 1, '2014-09-08 16:17:51'),
(34, 'loisidal14@gmail.com', '6e6877c7fd0c7fd9d48a58f3bbe1972598a53865', 'driver', 4, 1, 1, 1, 'Lois (Camioneta moderna con aire acondicionado, para 4 pasajeros y capacidad de carga hasta 1 ton y hasta 1, 5 mts de largo por igual alto e igual ancho, es decir tiene doble uso de ser necesario)', 7, 0, '2014-09-19 23:10:10'),
(35, 'arochar@nauta.cu', 'd2b1985b620963c1f0b83427dc82acf97e262fce', 'driver', 4, 1, 1, 1, 'Arnol Rosales Charles, Peugeot 405, telef: 200546, 52903397', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drivers_localities`
--

DROP TABLE IF EXISTS `drivers_localities`;
CREATE TABLE IF NOT EXISTS `drivers_localities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned NOT NULL,
  `locality_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `driver_localities_driver_fk` (`driver_id`),
  KEY `driver_localities_locality_fk` (`locality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=257 ;

--
-- Volcado de datos para la tabla `drivers_localities`
--

INSERT INTO `drivers_localities` (`id`, `driver_id`, `locality_id`) VALUES
(32, 12, 1),
(33, 12, 2),
(41, 16, 1),
(42, 16, 2),
(59, 14, 1),
(60, 14, 2),
(74, 24, 9),
(122, 21, 5),
(123, 21, 6),
(124, 21, 7),
(125, 20, 5),
(126, 20, 6),
(127, 20, 7),
(128, 19, 5),
(129, 19, 6),
(130, 19, 7),
(131, 18, 5),
(132, 18, 6),
(133, 18, 7),
(134, 17, 5),
(135, 17, 6),
(136, 17, 7),
(143, 28, 9),
(144, 11, 1),
(145, 11, 2),
(146, 11, 5),
(147, 11, 6),
(148, 11, 7),
(149, 11, 9),
(154, 8, 1),
(155, 8, 2),
(156, 29, 5),
(157, 29, 6),
(158, 29, 7),
(159, 30, 5),
(160, 30, 6),
(161, 30, 7),
(201, 32, 10),
(202, 32, 11),
(203, 32, 12),
(204, 32, 13),
(205, 32, 15),
(206, 32, 16),
(207, 32, 14),
(208, 9, 1),
(209, 9, 2),
(210, 13, 1),
(211, 13, 2),
(246, 33, 1),
(247, 7, 1),
(248, 7, 2),
(249, 34, 10),
(250, 34, 11),
(251, 34, 12),
(252, 34, 13),
(253, 34, 15),
(254, 34, 16),
(255, 34, 14),
(256, 35, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drivers_travels`
--

DROP TABLE IF EXISTS `drivers_travels`;
CREATE TABLE IF NOT EXISTS `drivers_travels` (
  `id` char(36) COLLATE latin1_bin NOT NULL,
  `driver_id` bigint(20) unsigned NOT NULL,
  `travel_id` bigint(20) unsigned NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `last_driver_email` varchar(250) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `drivers_travels_driver_fk` (`driver_id`),
  KEY `drivers_travels_travel_fk` (`travel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `drivers_travels`
--

INSERT INTO `drivers_travels` (`id`, `driver_id`, `travel_id`, `sent`, `last_driver_email`) VALUES
('16', 16, 59, 0, 'sanchez@granma.copextel.com.cu'),
('17', 14, 59, 0, 'Kevin.pellicer@nauta.cu'),
('18', 7, 59, 0, 'eduartd@nauta.cu'),
('19', 32, 61, 0, 'cubamitaxi@gmail.com'),
('20', 32, 62, 0, 'cubamitaxi@gmail.com'),
('21', 17, 63, 0, 'carlosrm111@gmail.com'),
('22', 29, 63, 0, 'radapi@nauta.cu'),
('23', 21, 63, 0, 'eduardotorres@nauta.cu'),
('24', 32, 64, 0, 'cubamitaxi@gmail.com'),
('25', 30, 65, 0, 'alejandro.lazo@nauta.cu'),
('26', 20, 65, 0, 'ronald.caballero@nauta.cu'),
('27', 19, 65, 0, 'jbjorgeton227@gmail.com'),
('28', 32, 66, 0, 'cubamitaxi@gmail.com'),
('29', 18, 67, 0, 'zacarias85@nauta.cu'),
('3', 24, 48, 0, 'nelsonperezga@gmail.com'),
('30', 17, 67, 0, 'carlosrm111@gmail.com'),
('31', 29, 67, 0, 'radapi@nauta.cu'),
('32', 12, 68, 0, 'yoelt@nauta.cu'),
('33', 8, 68, 0, 'wary@dps.grm.sld.cu'),
('34', 16, 68, 0, 'sanchez@granma.copextel.com.cu'),
('35', 32, 69, 0, 'cubamitaxi@gmail.com'),
('36', 32, 70, 0, 'cubamitaxi@gmail.com'),
('37', 32, 71, 0, 'cubamitaxi@gmail.com'),
('38', 32, 72, 0, 'cubamitaxi@gmail.com'),
('39', 32, 73, 0, 'cubamitaxi@gmail.com'),
('40', 32, 74, 0, 'cubamitaxi@gmail.com'),
('41', 32, 75, 0, 'cubamitaxi@gmail.com'),
('42', 32, 76, 0, 'cubamitaxi@gmail.com'),
('53f4cf07-e598-4a2c-a12c-639a5bc25abe', 32, 79, 0, 'cubamitaxi@gmail.com'),
('53fa224d-1840-421b-a78a-79de5bc25abe', 32, 81, 0, ''),
('53fef581-6684-4fc7-a5e7-09e65bc25abe', 32, 85, 0, ''),
('5405e14d-ecb0-42e5-8156-3c8f5bc25abe', 17, 91, 0, 'radapi@nauta.cu'),
('5406d21b-1458-4b13-8ac9-4d4e5bc25abe', 30, 95, 0, ''),
('5406d21b-7ee4-4bf2-af30-4d4e5bc25abe', 20, 95, 0, ''),
('5406d21b-831c-4c8e-9ff5-4d4e5bc25abe', 19, 95, 0, ''),
('540809a0-1838-4315-a920-4d4e5bc25abe', 32, 96, 0, 'cubamitaxi@gmail.com'),
('54084a25-f11c-4485-b13f-0bf15bc25abe', 32, 97, 0, 'cubamitaxi@gmail.com'),
('540877a9-bde8-4834-bce8-5b385bc25abe', 32, 98, 0, ''),
('5409e271-1054-4fde-ab15-10c15bc25abe', 32, 99, 0, 'cubamitaxi@gmail.com'),
('5409e271-8e2c-440d-96b3-10c15bc25abe', 34, 99, 0, 'loisidal14@gmail.com'),
('540b428f-4068-44c3-87e7-5e225bc25abe', 32, 100, 0, 'cubamitaxi@gmail.com'),
('540b52fc-5034-44bd-b46b-33aa5bc25abe', 32, 101, 0, 'cubamitaxi@gmail.com'),
('540b52fc-e53c-4020-b642-33aa5bc25abe', 34, 101, 0, 'loisidal14@gmail.com'),
('540cc0e4-302c-44c1-9d0a-2df45bc25abe', 34, 102, 0, 'loisidal14@gmail.com'),
('540cc0e4-d73c-4c3f-9d84-2df45bc25abe', 32, 102, 0, 'cubamitaxi@gmail.com'),
('540d0dce-9e24-4202-98f2-35845bc25abe', 8, 103, 0, ''),
('540d0dce-badc-42d0-952e-35845bc25abe', 14, 103, 0, 'Kevin.pellicer@nauta.cu'),
('540d0dce-c62c-472e-9b03-35845bc25abe', 12, 103, 0, ''),
('540d5d66-54ec-4b8d-9a7a-4ba15bc25abe', 32, 104, 0, 'cubamitaxi@gmail.com'),
('540d5d66-e738-44b0-a962-4ba15bc25abe', 34, 104, 0, 'loisidal14@gmail.com'),
('540f3dfe-1838-4f2f-a9cf-0a255bc25abe', 32, 105, 0, 'cubamitaxi@gmail.com'),
('540f3dfe-f824-464b-b849-0a255bc25abe', 34, 105, 0, 'loisidal14@gmail.com'),
('54197699-0764-49ea-9d94-61d45bc25abe', 34, 106, 0, 'loisidal14@gmail.com'),
('54197699-0d3c-480c-ab58-61d45bc25abe', 32, 106, 0, 'cubamitaxi@gmail.com'),
('541b41db-c37c-4170-a26b-2eee5bc25abe', 32, 107, 0, 'cubamitaxi@gmail.com'),
('541cb7d2-1c7c-4c09-9231-2d4a5bc25abe', 32, 108, 0, ''),
('541cb7d2-f6f0-4a2b-adda-2d4a5bc25abe', 34, 108, 0, 'loisidal14@gmail.com'),
('6', 24, 50, 0, 'nelsonperezga@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drivers_travels_by_email`
--

DROP TABLE IF EXISTS `drivers_travels_by_email`;
CREATE TABLE IF NOT EXISTS `drivers_travels_by_email` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned NOT NULL,
  `travel_id` bigint(20) unsigned NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `drivers_travels_by_email_driver_fk` (`driver_id`),
  KEY `drivers_travels_by_email_travel_fk` (`travel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `drivers_travels_by_email`
--

INSERT INTO `drivers_travels_by_email` (`id`, `driver_id`, `travel_id`, `sent`) VALUES
(1, 17, 35, 0),
(2, 21, 35, 0),
(3, 29, 35, 0),
(6, 32, 37, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `driver_traveler_conversations`
--

DROP TABLE IF EXISTS `driver_traveler_conversations`;
CREATE TABLE IF NOT EXISTS `driver_traveler_conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) NOT NULL,
  `response_by` varchar(20) NOT NULL,
  `response_text` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Volcado de datos para la tabla `driver_traveler_conversations`
--

INSERT INTO `driver_traveler_conversations` (`id`, `conversation_id`, `response_by`, `response_text`, `created`) VALUES
(78, '5405e14d-ecb0-42e5-8156-3c8f5bc25abe', 'driver', '<span style="font-size:10pt;"><span style="font-size:10pt;"><span style="font-size:10pt;"><alexeirivera87@gmail.com>Hola soy uno de los choferes de la aplicacion yotellevo, le escribo para informarle sobre el viaje que quieren hacer, puede ser en 2 carros con &nbsp;todas las comodidades ahora espero respuesta de ustedes para entonces definir todo. Saludos.</span></span></span>', '2014-09-04 11:26:49'),
(79, '54084a25-f11c-4485-b13f-0bf15bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D., Mi Cayito y ARTISAL. Es un placer atenderle.\n\nNuestro grupo puede satisfacer su solitud de realizar una ruta de 5\ndías por el interior del país; para ello le ofrecemos los distintos\ntipos de autos y sus precios.\nAuto con cap. 3 pasaj. y poco\nequipaje...............................100cuc diarios\nAuto con cap. 4 pasaj. y equipaje normal...........................\n120cuc diarios\nAuto de lujo con cap. 4 pasaj. y equipaje normal............... 140cuc diarios\n\nEn los precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer cuando se pernocte fuera de la\nHabana. Si nos facilita los lugares que desea visitar podemos hacer un\ncálculo de la distancia a recorrer y darle un presupuesto mas exacto.\n\nTodos nuestros servicios son personalizados, con chofer y aire acondicionado.\n\nEsperamos su confirmación y la selección del tipo de auto.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-04 7:20 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#97) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Recorrido por la isla\n> 3 personas\n>\n> Día del viaje: 23 Diciembre, 2014 (Martes)\n>\n> Detalles del viaje: Me gustaría hacer una ruta de 5 días por el interior de\n> Cuba\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-04 22:35:10'),
(80, '540809a0-1838-4315-a920-4d4e5bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D., Mi Cayito y ARTISAL. Es un placer atenderle.\n\nNuestro grupo puede satisfacer su solitud de transfer desde el\naeropuerto Jose Martí hasta la Habana del Este y el precio es de\n30cuc.\nSolo necesitamos los datos para localizarlo en el aeropuerto (nombre y\napellido, Línea Aérea, número del vuelo y hora estimada de arribo a la\nHabana) y proceder con la reservación.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-04 2:45 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#96) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> Aeropuerto José Martí | La Habana - La Habana\n> 2 personas\n>\n> Día del viaje: 7 Septiembre, 2014 (Domingo)\n>\n> Detalles del viaje: Seria para ir a Habana del este\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-04 23:07:52'),
(81, '5409e271-8e2c-440d-96b3-10c15bc25abe', 'driver', 'Hola\nGracias por preferir a  YoTeLlevo\nPuedo efectuar el viaje, el precio es 60 cuc diario mas los gastos de\ncombustible, alimentacion y alojamiento\nSaludos\nLois\n\nEl 5/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#99) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - 8 DIAS POR LA ISLA, VIÑALES TRINIDAD ETC\n> 2 personas\n>\n> Día del viaje: 1 Octubre, 2014 (Miércoles)\n>\n> Detalles del viaje: buenas tardes, somo un matrimonio español, queremos\n> hacer una ruta de unos 8 dias por la isla saliendo desde La habana, viendo\n> lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo\n> aficionado) ,ir a algun calas , es es nuestra idea. Muchas gracias\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-05 14:57:09'),
(82, '5409e271-8e2c-440d-96b3-10c15bc25abe', 'traveler', 'Buenas tardes,\nMuchas gracias ,  lo pensaremos\nUn saludo\n\nFrom: chofer@yotellevo.ahiteva.net\nTo: JUHANAL06@HOTMAIL.COM\nDate: Fri, 5 Sep 2014 15:00:01 -0400\nSubject: Re: Nuevo Anuncio de Viaje [[5409e271-8e2c-440d-96b3-10c15bc25abe]]\n\n\n\n    \n        Emails/html\n    \n    \n        \n    Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo, notificado con los datos de tu viaje La Habana - 8 DIAS POR LA ISLA, VI?ALES TRINIDAD ETC. Para enviar tu respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n\n\nEl chofer dice:\n\n\nHola\nGracias por preferir a  YoTeLlevo\nPuedo efectuar el viaje, el precio es 60 cuc diario mas los gastos de\ncombustible, alimentacion y alojamiento\nSaludos\nLois\n\nEl 5/9/14, YoTeLlevo | Viajero  escribi?:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#99) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - 8 DIAS POR LA ISLA, VI?ALES TRINIDAD ETC\n> 2 personas\n>\n> D?a del viaje: 1 Octubre, 2014 (Mi?rcoles)\n>\n> Detalles del viaje: buenas tardes, somo un matrimonio espa?ol, queremos\n> hacer una ruta de unos 8 dias por la isla saliendo desde La habana, viendo\n> lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo\n> aficionado) ,ir a algun calas , es es nuestra idea. Muchas gracias\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n>\n--------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ?Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibi? este correo porque est? registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n\n-------------\n        \n            Atentamente, el equipo de YoTeLlevo\n\n         		 	   		  \n\n', '2014-09-05 15:43:09'),
(83, '5409e271-1054-4fde-ab15-10c15bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno con aire acondicionado para su gira por Cuba. No\nentendemos una parte de su mensaje donde dice “...ir a algún calas,\n...” .\n\n           (1€=1.29cuc aprox).\nPara la gira que UD. propone el precio es de...........115cuc diarios\nEn este precio están incluidos los gastos de combustible para 1500km,\nimpuestos, salario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podrán encontrar fotos de las mejores\ncasas particulares en cada provincia y podrán hacer su reservación “on\nline”, o si desean nos dicen las casas que prefieren y les hacemos la\nreservación directamente con los propietarios.\n\nEsperamos su confirmación para ultimar los detalles del viaje y\nproceder con la reservación.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-05 12:20 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#99) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - 8 DIAS POR LA ISLA, VIÑALES TRINIDAD ETC\n> 2 personas\n>\n> Día del viaje: 1 Octubre, 2014 (Miércoles)\n>\n> Detalles del viaje: buenas tardes, somo un matrimonio español, queremos\n> hacer una ruta de unos 8 dias por la isla saliendo desde La habana, viendo\n> lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo\n> aficionado) ,ir a algun calas , es es nuestra idea. Muchas gracias\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-06 09:21:57'),
(84, '540b52fc-e53c-4020-b642-33aa5bc25abe', 'driver', 'Hola\nPrecio 70 cuc diario mas los gastos de combustible, alimentacion y hospedaje\nNota la Aimentacion y el hospedaje es en lugares economicos.\nSaludos\nLois\n\n\nEl 6/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#101) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - varios\n> 4 personas\n>\n> Día del viaje: 15 Octubre, 2014 (Miércoles)\n>\n> Detalles del viaje: ?Miércoles 15 LA HABANA/PINAR DEL RÍO ?Jueves 16 PINAR\n> DEL RÍO/VIÑALES ?Viernes 17 VIÑALES (VISITAR LA ZONA) ?Sábado 18 VIÑALES A\n> PALMA RUBIA ?Domingo 19 VIÑALES A CIENFUEGOS ?lunes 20 CIENFUEGOS A TRINIDAD\n> ?Martes 21 Playa Ancón ?Jueves 23 TRINIDAD A SANTA CLARA ?Viernes 24 SANTA\n> CLARA A VARADERO Este seria mas o menos el recorrido. Queremos saber el\n> precio con todo incluido\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-06 16:28:01'),
(85, '5409e271-1054-4fde-ab15-10c15bc25abe', 'traveler', 'BUenas noches\nDispones de algo que sea mas barato de losd 115 cuc?  aunque el coche no sea moderno\nsi, a lo que me refiero es a ir a algunos cayos bonitos\nUn saludo\n\nFrom: chofer@yotellevo.ahiteva.net\nTo: JUHANAL06@HOTMAIL.COM\nDate: Sat, 6 Sep 2014 09:25:01 -0400\nSubject: Re: Nuevo Anuncio de Viaje [[5409e271-1054-4fde-ab15-10c15bc25abe]]\n\n\n\n    \n        Emails/html\n    \n    \n        \n    Hola viajero. Este correo contiene la respuesta del chofer #32 de YoTeLlevo, notificado con los datos de tu viaje La Habana - 8 DIAS POR LA ISLA, VI?ALES TRINIDAD ETC. Para enviar tu respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n\n\nEl chofer dice:\n\n\nHola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportaci?n en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno con aire acondicionado para su gira por Cuba. No\nentendemos una parte de su mensaje donde dice ?...ir a alg?n calas,\n...? .\n\n           (1?=1.29cuc aprox).\nPara la gira que UD. propone el precio es de...........115cuc diarios\nEn este precio est?n incluidos los gastos de combustible para 1500km,\nimpuestos, salario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podr?n encontrar fotos de las mejores\ncasas particulares en cada provincia y podr?n hacer su reservaci?n\n?on\nline?, o si desean nos dicen las casas que prefieren y les hacemos la\nreservaci?n directamente con los propietarios.\n\nEsperamos su confirmaci?n para ultimar los detalles del viaje y\nproceder con la reservaci?n.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nM?vil: +5352426026\n\n\n2014-09-05 12:20 GMT-04:00, YoTeLlevo | Viajero :\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#99) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - 8 DIAS POR LA ISLA, VI?ALES TRINIDAD ETC\n> 2 personas\n>\n> D?a del viaje: 1 Octubre, 2014 (Mi?rcoles)\n>\n> Detalles del viaje: buenas tardes, somo un matrimonio espa?ol, queremos\n> hacer una ruta\nde unos 8 dias por la isla saliendo desde La habana, viendo\n> lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo\n> aficionado) ,ir a algun calas , es es nuestra idea. Muchas gracias\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ?Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibi? este correo porque est? registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n\n-------------\n        \n            Atentamente, el equipo de YoTeLlevo\n\n         		 	   		  \n\n', '2014-09-06 19:18:04'),
(86, '540b52fc-5034-44bd-b46b-33aa5bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno tipo todo terreno 4x4, con aire acondicionado para su\ngira por Cuba.\n\nDe acuerdo a la distancia que refiere por los lugares que desean\nvisitar (1900km) el precio de la transportación sería de 145cuc\ndiario.\n\nEn el precio están incluidos los gastos de combustible para 1900km,\nimpuestos, salario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podrán encontrar fotos de las mejores\ncasas particulares en cada provincia y podrán hacer su reservación “on\nline”, o si desean nos dicen las casas que prefieren y les hacemos la\nreservación directamente con los propietarios. Los precios de las\ncasas pueden oscilar entre 25 y 30cuc/habit./noche con habitación\nclimatizada y baño independiente.\n\nEsperamos su confirmación para proceder con las reservaciones.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n', '2014-09-07 17:23:33'),
(87, '540b428f-4068-44c3-87e7-5e225bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPuede contactar con nosotros por los teléfonos que aparecen en el pie de firma.\n\nPara satisfacer su solicitud podemos reservarle un auto con capacidad para\n7 pasajeros y los precios son los siguientes:\nHABANA-VARADERO             IDA          IDA/REG.\nVan de 7 pasajeros...................  110cuc          200cuc\nVan de 10 pasajeros.................  125cuc          225cuc\n\nEsperamos su llamada para la confirmación y proceder con la reservación.\nGracias por preferirnos.\nSaludos cordiales.\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-06 13:25 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#100) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Varadero\n> 6 personas\n>\n> Día del viaje: 20 Septiembre, 2014 (Sábado)\n>\n> Detalles del viaje: Somos 6 personas y tambien quisieramos nos recojan el\n> dia 26. Somos cubanossss, jaja. Pueden llamarme al 052635881 Saludos\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-07 17:32:27'),
(88, '540cc0e4-302c-44c1-9d0a-2df45bc25abe', 'driver', 'Hola\nGracias por contactarme, estoy disponible para efectuar el viaje\nturistico a Trinidad, el precio es de 130 cuc\nDeme los detalles para hacer las precisiones\nSaludos\nLois\n\nEl 7/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#102) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Trinidad\n> 2 personas\n>\n> Día del viaje: 11 Septiembre, 2014 (Jueves)\n>\n> Detalles del viaje: turistico\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-07 20:46:13'),
(89, '5409e271-1054-4fde-ab15-10c15bc25abe', 'driver', 'Hola, Buenas tardes\nPodemos reservarle el auto más barato, con capacidad para 3 pasajeros\npero con poca capacidad para equipaje y que tiene un precio de 105cuc\ndiarios para recorrer una distancia total de 1500km. Con esta\ndistancia puede hacer el recorrido que UD nos propone y visitar Cayo\nSanta María; si quisiera visitar Cayo Coco y Cayo Guillermo serían\nunos 2900km totales y el precio aumenta a 110cuc diarios.\n\nRecuerde que en estos precios entran los gastos de combustible,\nimpuestos, salario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podrán encontrar fotos de las mejores\ncasas particulares en cada provincia y podrán hacer su reservación “on\nline”, o si desean nos dicen las casas que prefieren y les hacemos la\nreservación directamente con los propietarios.\n\nEspero su confirmación para proceder con la reservación del auto.\nSaludos\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-06 19:20 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola chofer. Este correo contiene la respuesta del viajero para el viaje #99\n> (La Habana - 8 DIAS POR LA ISLA, VIÑALES TRINIDAD ETC). Para enviar tu\n> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n>\n> El viajero dice:\n>\n> BUenas noches\n> Dispones de algo que sea mas barato de losd 115 cuc? aunque el coche no sea\n> moderno\n> si, a lo que me refiero es a ir a algunos cayos bonitos\n> Un saludo\n>\n> From: chofer@yotellevo.ahiteva.net\n> To: JUHANAL06@HOTMAIL.COM\n> Date: Sat, 6 Sep 2014 09:25:01 -0400\n> Subject: Re: Nuevo Anuncio de Viaje [[5409e271-1054-4fde-ab15-10c15bc25abe]]\n>\n>\n>\n>\n> Emails/html\n>\n>\n>\n> Hola viajero. Este correo contiene la respuesta del chofer #32 de YoTeLlevo,\n> notificado con los datos de tu viaje La Habana - 8 DIAS POR LA ISLA, VIÑALES\n> TRINIDAD ETC. Para enviar tu respuesta, responde este correo SIN MODIFICAR\n> EL ASUNTO.\n>\n>\n> El chofer dice:\n>\n>\n> Hola\n> Hemos recibido copia de su solicitud a YoTeLlevo.\n> Soy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\n> transportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\n> L.T.D. y ARTISAL. Es un placer atenderle.\n>\n> Podemos satisfacer su solicitud, para lo cual podemos reservarle un\n> auto moderno con aire acondicionado para su gira por Cuba. No\n> entendemos una parte de su mensaje donde dice ?...ir a algún calas,\n> ...? .\n>\n> (1?=1.29cuc aprox).\n> Para la gira que UD. propone el precio es de...........115cuc diarios\n> En este precio están incluidos los gastos de combustible para 1500km,\n> impuestos, salario y alojamiento del chofer.\n>\n> Si desean alojamiento en casas particulares, pueden visitar nuestra web:\n> www.bookinghavana.com , donde podrán encontrar fotos de las mejores\n> casas particulares en cada provincia y podrán hacer su reservación\n> ?on\n> line?, o si desean nos dicen las casas que prefieren y les hacemos la\n> reservación directamente con los propietarios.\n>\n> Esperamos su confirmación para ultimar los detalles del viaje y\n> proceder con la reservación.\n> Gracias por confiar en YoTeLlevo y en MITAXI.\n> Saludos cordiales.\n> Ovidio\n> MITAXI\n> BOOKING HAVANA\n> cubamitaxi@gmail.com\n> Telef.: +5378320872\n> Móvil: +5352426026\n>\n>\n> 2014-09-05 12:20 GMT-04:00, YoTeLlevo | Viajero :\n>> Hola Chofer,\n>>\n>> Un nuevo anuncio de viaje (#99) ha sido registrado recientemente con los\n>> siguientes datos:\n>>\n>> --------------------\n>>\n>> La Habana - 8 DIAS POR LA ISLA, VIÑALES TRINIDAD ETC\n>> 2 personas\n>>\n>> Día del viaje: 1 Octubre, 2014 (Miércoles)\n>>\n>> Detalles del viaje: buenas tardes, somo un matrimonio español, queremos\n>> hacer una ruta\n> de unos 8 dias por la isla saliendo desde La habana, viendo\n>> lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo\n>> aficionado) ,ir a algun calas , es es nuestra idea. Muchas gracias\n>>\n>> Preferencias: Carro Moderno, Aire Acondicionado\n>>\n>> --------------------\n>>\n>> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL\n>> ASUNTO\n>> [Nota: Puedes responder desde otro correo, copiando el asunto de este\n>> correo\n>> en el que vayas a enviar]\n>> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>>\n>> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n>> que atiende viajes desde/hasta La Habana.\n>>\n>> Atentamente, el equipo de YoTeLlevo\n>\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n>\n>\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 00:15:07'),
(90, '540d5d66-e738-44b0-a962-4ba15bc25abe', 'driver', 'Hola\nEstoy disponible para realizar el viaje, el precio es 70 cuc mas los\ngastos de combustible\nSaludos\nLois\n\nEl 8/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Viñales\n> 4 personas\n>\n> Día del viaje: 3 Noviembre, 2014 (Lunes)\n>\n> Detalles del viaje: Saldriamos de La Habana a Viñales pasando el dia por Las\n> Terrazas y Soroa. Un saludo,\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 08:48:38'),
(91, '540cc0e4-d73c-4c3f-9d84-2df45bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nNuestro grupo tiene programada varias excursiones, que pueden hacerse\nen varios tipos de autos de acuerdo a su capacidad y nivel de confort,\nlos cuales le relacionamos a continuación:\nTIPOS DE AUTOS\nTIPO I.-  Autos con capacidad para 3 pasajeros.\nTIPO II.- Autos con capacidad para 4 pasajeros.\nTIPO III.-Autos de lujo con capacidad para 4 pasajeros.\n\nLas excursiones que tenemos programadas a Trinidad son las siguientes:\nTRINIDAD (2 días y 1 noche)\n1er. día\nRecogida en su domicilio (7:00 am) y salida hacia Trinidad. Parada en\nla cafetería de Aguada de los Pasajeros para estirar las piernas.\nTiempo para almorzar en Sancti-Spiritus (1:00 hora). Continuación\nhacia Trinidad. Llegada a la ciudad de Trinidad y tiempo de estancia\npara visita a lugares de interés y centros de venta de artesanías y\nregalos. Alojamiento en casas particulares y tiempo libre toda la\nnoche\n2do. Día\nVisita a la Playa Ancón y tiempo para disfrutar del baño de mar. A las\n3:00 pm salida hacia la Habana por el circuito sur, parada en Aguada\nde Pasajeros para estirar las piernas. Regreso a la Habana hasta su\ndomicilio.\n\nI.-......................................................300cuc**\nII.-................................................... 375cuc**\nIII.-.................................................. 465cuc**\n\n** Los precios NO incluyen alojamiento y comida.\n\nCIENFUEGOS – TRINIDAD – STA. CLARA (3 días y 2 noches)\n1er. día.\nRecogida en su domicilio (7:00am) y salida hacia Cienfuegos. Parada en\nla cafetería de Jagüey Grande para estirar las piernas. Continuación\nhasta el centro turístico de Guamá y tiempo para tomar fotos y ver el\ncriadero de cocodrilos. Salida rumbo a Playa Larga, tiempo para ver\nlas instalaciones turísticas y continuación hacia Playa Girón; tiempo\npara tomar fotos y ver las instalaciones. Salida con rumbo a\nCienfuegos; Llegada a la ciudad y tiempo para visitas a lugares de\ninterés y centros de venta de artesanía y regalos. Alojamiento en\ncasas particulares y tiempo libre toda la noche.\n2do. día\nSalida hacia Trinidad por el circuito sur próximo a la costa. En el\ntrayecto pasaremos por las Playas de Cabagán, Río Hondo, Yaguanabo y\nel Inglés. Llegada a la ciudad de Trinidad y tiempo de estancia para\nvisita a lugares de interés y centros de venta de artesanías y\nregalos. Alojamiento en casas particulares y tiempo libre toda la\nnoche.\n3er. día\nSalida hacia Sta. Clara. En el trayecto pasaremos por el Mirador del\nValle de los Ingenios, la torre de Iznaga y la ciudad de\nSancti-Spiritus donde almorzaremos en el Ranchón el Tenis. Al llegar a\nla ciudad de Sta. Clara visitaremos el mausoleo del Ché y\nposteriormente continuaremos hacia la Habana con parada en la\ncafetería de Aguada de los Pasajeros para refrescar y estirar las\npiernas.\n\nI.-.................................... 350cuc**\nII.-.................................  445cuc**\nIII.-................................  540cuc**\n\n** Los precios NO incluyen alojamiento y comida.\n\nEn estos precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podrán encontrar fotos de las mejores\ncasas particulares en cada provincia y podrán hacer su reservación “on\nline”, o si desean nos dicen las casas que prefieren y les hacemos la\nreservación directamente con los propietarios.\n\nEspero su confirmación para proceder con la reservación del auto.\nSaludos\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-07 16:35 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#102) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Trinidad\n> 2 personas\n>\n> Día del viaje: 11 Septiembre, 2014 (Jueves)\n>\n> Detalles del viaje: turistico\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 11:44:24'),
(92, '540b52fc-5034-44bd-b46b-33aa5bc25abe', 'traveler', 'Gracias por su respuesta Ovidio.\n\nMe surgen algunas dudas.\n- Calculando los km con googlemaps me salen sobre 1055, en los que sólo he puesto las ciudades principales que queremos visitar, una vez allí queremos hacer pequeñas excursiones para visitar más lugares. Tampoco he incluido los regresos (como el día que queremos ir a playa Ancón). Entiendo que en la propuesta de km que me adjuntas están incluidos estos pequeños trayectos y  el regreso del chofer a La Habana desde Varadero.\n- Me comentas que están incluidos los gastos de combustible, impuestos, salario y alojamiento del chofer. ¿Las comidas del mismo corren de su cuenta?\n- También me gustaría saber cual es el sistema de pago.\n\nMuchas gracias. \n\n\n________________________________\n De: YoTeLlevo | Chofer <chofer@yotellevo.ahiteva.net>\nPara: patsl33@yahoo.es \nEnviado: Domingo 7 de septiembre de 2014 23:25\nAsunto: Nuevo Anuncio de Viaje [[540b52fc-5034-44bd-b46b-33aa5bc25abe]]\n \n\n\nEmails/html \nHola viajero. Este correo contiene la respuesta del chofer #32 de YoTeLlevo, notificado con los datos de tu viaje La Habana - varios. Para enviar tu respuesta, responde este correo SIN MODIFICAR EL ASUNTO. \nEl chofer dice:\nHola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno tipo todo terreno 4x4, con aire acondicionado para su\ngira por Cuba.\n\nDe acuerdo a la distancia que refiere por los lugares que desean\nvisitar (1900km) el precio de la transportación sería de 145cuc\ndiario.\n\nEn el precio están incluidos los gastos de combustible para 1900km,\nimpuestos, salario y alojamiento del chofer.\n\nSi desean alojamiento en casas particulares, pueden visitar nuestra web:\nwww.bookinghavana.com , donde podrán encontrar fotos de las mejores\ncasas particulares en cada provincia y podrán hacer su reservación “on\nline”, o si\ndesean nos dicen las casas que prefieren y les hacemos la\nreservación directamente con los propietarios. Los precios de las\ncasas pueden oscilar entre 25 y 30cuc/habit./noche con habitación\nclimatizada y baño independiente.\n\nEsperamos su confirmación para proceder con las reservaciones.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\nOvidio\nMITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n-------------\nAtentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 12:02:29'),
(93, '7', 'driver', 'Probando:\n\n? ? ? ? ?\n\n\n-----Mensaje original-----\nDe: YoTeLlevo | Viajero [mailto:viajero@yotellevo.ahiteva.net]\nEnviado el: lun 08/09/2014 12:20\nPara: Mart?n Eduardo Proenza Arias\nAsunto: Nuevo Anuncio de Viaje [[7]]\n \nHola Chofer,\n\nUn nuevo anuncio de viaje ha sido registrado recientemente con los siguientes datos: \n\n-------------------- \n\nBayamo - Pinar del R?o  \n\nDetalles del viaje: Probando viajes por correo... parece que esta gente tumbaron la app, pero quiero probar si los correos a?n funcionan... \n\nCorreo de contacto: mproenza@grm.desoft.cu\n\n-------------------- \n\n?Ponte en contacto con el viajero y haz que tu oferta sea la mejor! \n\nUsted recibi? este correo porque est? registrado en YoTeLlevo como chofer que atiende viajes desde/hasta Bayamo. \n\nAtentamente, el equipo de YoTeLlevo <http://localhost/pages/home> \n\n\n\n\n\n', '2014-09-08 12:22:27'),
(94, '540d5d66-54ec-4b8d-9a7a-4ba15bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno con aire acondicionado para su excursión a Viñales. Debo\ncomentarle que el recorrido que UD. plantea es demasiado tiempo, por\nlo que se llegará muy tarde a Viñales para hacer el recorrido habitual\nde las cuevas, etc. y regresar a la Habana. Lo preferible sería\nreservar alojamiento una noche en Viñales y al otro día hacer el\nrecorrido del Mirador del Valle, El Valle “Dos Hermanas” con el mural\nde la prehistoria, la fábrica de tabaco, el poblado de Viñales, las\ncuevas del indio y el regreso a la Habana.\n\nLas Terrazas son muy acogedoras y son para pasarse el día y bañarse en\nel río; Soroa es un lugar para paseo, ver paisajes muy bonitos,\nvisitar el orquidiario (que a mi consideración a perdido calidad) y\ncaminar por el entorno ecológico para ver las ruinas de los cafetales\nde la época cuando eramos colonia española.\n\nLos precios del recorrido son:\n\nLas Terrazas – Soroa - Viñales (una noche en Viñales) y al día\nsiguiente hacer el tour y regreso a la Habana:\nAuto con capacidad para 4 pasajeros..................230cuc\nAuto de lujo con capacidad para 4 pasajeros......280cuc\nAuto 4x4 con capacidad para 6 pasajeros...........290cuc\n\nViñales (ida y regreso el mismo día):\nAuto con capacidad para 4 pasajeros..................180cuc\nAuto de lujo con capacidad para 4 pasajeros......230cuc\nAuto 4x4 con capacidad para 6 pasajeros...........240cuc\n\nEn estos precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer; No se incluyen los gastos de\nalojamiento de los clientes.\n\nEspero sus consideraciones y la confirmación de la excursión que\nprefieren hacer.\n\nSi necesitan alojamiento en casas particulares en Viñales pueden\nvisitar nuestra página web: www.bookinghavana.com y podrán ver un\ncatálogo de fotos de las mejores casas de Viñales y podrán hacer la\nreservación “on line” o si prefieren nos dicen la casa que les\ngustaría y le haremos la reservación directamente con los\npropietarios.\n\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-08 3:45 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Viñales\n> 4 personas\n>\n> Día del viaje: 3 Noviembre, 2014 (Lunes)\n>\n> Detalles del viaje: Saldriamos de La Habana a Viñales pasando el dia por Las\n> Terrazas y Soroa. Un saludo,\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 18:52:58'),
(95, '540b52fc-5034-44bd-b46b-33aa5bc25abe', 'driver', 'Hola\nPor desgracia no tenemos acceso a googlemaps; las distancias las\ntomamos de las guías de carretera editadas para el turismo y de la\nexperiencia de esos recorrido durante 5 cinco años, más un 10%, porque\ncasi siempre el que viene de turismo quiere ver algo en el camino o\nhacer algún pequeño desvío para tirar fotos, etc. El recorrido de\nregreso de Varadero a la Habana no se incluye en esa distancia.\n\nEn los precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer los días que se pernocte fuera de la\nHabana; la comida del chofer corre a su cargo de acuerdo a su salario.\n\nLa forma de pago será:\nLa transportación.- Todos los pagos se harán directamente al chofer y\nse pagará en CUC y en efectivo. El 50% del Total al inicio del viaje y\nel 50% restante al finalizar.\n\nEl alojamiento en casas particulares.- Se pagará directamente a los\npropietarios de las casas el primer día de alojamiento, excepto en las\ncasas con piscina donde se exige para la confirmación de la\nreservación el pago de la primera noche adelantado.\n\nEspero haber aclarado sus dudas y nos mantenemos en contacto para\ncualquier aclaración.\n\nEsperamos su respuesta.\nSaludos\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-08 12:05 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola chofer. Este correo contiene la respuesta del viajero para el viaje\n> #101 (La Habana - varios). Para enviar tu respuesta, responde este correo\n> SIN MODIFICAR EL ASUNTO.\n>\n> El viajero dice:\n>\n> Gracias por su respuesta Ovidio.\n>\n> Me surgen algunas dudas.\n> - Calculando los km con googlemaps me salen sobre 1055, en los que sólo he\n> puesto las ciudades principales que queremos visitar, una vez allí queremos\n> hacer pequeñas excursiones para visitar más lugares. Tampoco he incluido los\n> regresos (como el día que queremos ir a playa Ancón). Entiendo que en la\n> propuesta de km que me adjuntas están incluidos estos pequeños trayectos y\n> el regreso del chofer a La Habana desde Varadero.\n> - Me comentas que están incluidos los gastos de combustible, impuestos,\n> salario y alojamiento del chofer. ¿Las comidas del mismo corren de su\n> cuenta?\n> - También me gustaría saber cual es el sistema de pago.\n>\n> Muchas gracias.\n>\n>\n> ________________________________\n> De: YoTeLlevo | Chofer\n> Para: patsl33@yahoo.es\n> Enviado: Domingo 7 de septiembre de 2014 23:25\n> Asunto: Nuevo Anuncio de Viaje [[540b52fc-5034-44bd-b46b-33aa5bc25abe]]\n>\n>\n>\n> Emails/html\n> Hola viajero. Este correo contiene la respuesta del chofer #32 de YoTeLlevo,\n> notificado con los datos de tu viaje La Habana - varios. Para enviar tu\n> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n> El chofer dice:\n> Hola\n> Hemos recibido copia de su solicitud a YoTeLlevo.\n> Soy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\n> transportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\n> L.T.D. y ARTISAL. Es un placer atenderle.\n>\n> Podemos satisfacer su solicitud, para lo cual podemos reservarle un\n> auto moderno tipo todo terreno 4x4, con aire acondicionado para su\n> gira por Cuba.\n>\n> De acuerdo a la distancia que refiere por los lugares que desean\n> visitar (1900km) el precio de la transportación sería de 145cuc\n> diario.\n>\n> En el precio están incluidos los gastos de combustible para 1900km,\n> impuestos, salario y alojamiento del chofer.\n>\n> Si desean alojamiento en casas particulares, pueden visitar nuestra web:\n> www.bookinghavana.com , donde podrán encontrar fotos de las mejores\n> casas particulares en cada provincia y podrán hacer su reservación “on\n> line”, o si\n> desean nos dicen las casas que prefieren y les hacemos la\n> reservación directamente con los propietarios. Los precios de las\n> casas pueden oscilar entre 25 y 30cuc/habit./noche con habitación\n> climatizada y baño independiente.\n>\n> Esperamos su confirmación para proceder con las reservaciones.\n> Gracias por confiar en YoTeLlevo y en MITAXI.\n> Saludos cordiales.\n> Ovidio\n> MITAXI\n> BOOKING HAVANA\n> cubamitaxi@gmail.com\n> Telef.: +5378320872\n> Móvil: +5352426026\n>\n>\n> -------------\n> Atentamente, el equipo de YoTeLlevo\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-08 19:34:58'),
(96, '540d5d66-e738-44b0-a962-4ba15bc25abe', 'traveler', 'Hola Lois,\nY cu?l ser?a el gasto de gasolina estimado para ese viaje.Otra pregunta, el gasto de alojamiento de usted correria por nuestra cuenta o no.\nGracias\n\nFrom: chofer@yotellevo.ahiteva.net\nTo: labeyo@hotmail.com\nDate: Mon, 8 Sep 2014 08:50:01 -0400\nSubject: Re: Nuevo Anuncio de Viaje [[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n\n\n\n    \n        Emails/html\n    \n    \n        \n    Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo, notificado con los datos de tu viaje La Habana - Vi?ales. Para enviar tu respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n\n\nEl chofer dice:\n\n\nHola\nEstoy disponible para realizar el viaje, el precio es 70 cuc mas los\ngastos de combustible\nSaludos\nLois\n\nEl 8/9/14, YoTeLlevo | Viajero  escribi?:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Vi?ales\n> 4 personas\n>\n> D?a del viaje: 3 Noviembre, 2014 (Lunes)\n>\n> Detalles del viaje: Saldriamos de La Habana a Vi?ales pasando el dia por Las\n> Terrazas y Soroa. Un saludo,\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ?Ponte en contacto y haz que tu oferta sea la mejor!\n>\n\n> Usted recibi? este correo porque est? registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n\n-------------\n        \n            Atentamente, el equipo de YoTeLlevo\n\n         		 	   		  \n\n', '2014-09-09 02:46:20'),
(97, '540d5d66-e738-44b0-a962-4ba15bc25abe', 'driver', 'Hola muchas gracias por su respuesta\nEl gasto de combustible, depende de los recorridos adicionales a lo\nprevisto, oscila alrededor de los 60, 70 cuc, si pasamos la noche en\nalgun lugar el hospedaje corre por ud pero en un lugar economico cuyo\nprecio es entre  5 o 10 cuc.\nSaludos\nLois\n\nEl 9/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola chofer. Este correo contiene la respuesta del viajero para el viaje\n> #104 (La Habana - Viñales). Para enviar tu respuesta, responde este correo\n> SIN MODIFICAR EL ASUNTO.\n>\n> El viajero dice:\n>\n> Hola Lois,\n> Y cuál sería el gasto de gasolina estimado para ese viaje.Otra pregunta, el\n> gasto de alojamiento de usted correria por nuestra cuenta o no.\n> Gracias\n>\n> From: chofer@yotellevo.ahiteva.net\n> To: labeyo@hotmail.com\n> Date: Mon, 8 Sep 2014 08:50:01 -0400\n> Subject: Re: Nuevo Anuncio de Viaje [[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n>\n>\n>\n>\n> Emails/html\n>\n>\n>\n> Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo,\n> notificado con los datos de tu viaje La Habana - Viñales. Para enviar tu\n> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n>\n>\n> El chofer dice:\n>\n>\n> Hola\n> Estoy disponible para realizar el viaje, el precio es 70 cuc mas los\n> gastos de combustible\n> Saludos\n> Lois\n>\n> El 8/9/14, YoTeLlevo | Viajero escribió:\n>> Hola Chofer,\n>>\n>> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n>> siguientes datos:\n>>\n>> --------------------\n>>\n>> La Habana - Viñales\n>> 4 personas\n>>\n>> Día del viaje: 3 Noviembre, 2014 (Lunes)\n>>\n>> Detalles del viaje: Saldriamos de La Habana a Viñales pasando el dia por\n>> Las\n>> Terrazas y Soroa. Un saludo,\n>>\n>> Preferencias: Carro Moderno, Aire Acondicionado\n>>\n>> --------------------\n>>\n>> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL\n>> ASUNTO\n>> [Nota: Puedes responder desde otro correo, copiando el asunto de este\n>> correo\n>> en el que vayas a enviar]\n>> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>>\n>\n>> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n>> que atiende viajes desde/hasta La Habana.\n>>\n>> Atentamente, el equipo de YoTeLlevo\n>\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n>\n>\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-09 12:04:04'),
(98, '540f3dfe-f824-464b-b849-0a255bc25abe', 'driver', 'Hola Muchas gracias por contactarnos\nEstoy disponible para llevarlo hasta el hotel en varadero el precio de\neste vieja es de 75 cuc llevarlo e igual precio por la recogida, no\nobstante si ud hace el viaje de ida y regreso conmigo pues le cobro 70\ncuc y 70 por el regreso, es decir le descuento 5 cuc por cada viaje,\nluego para su salida del hotel para conocer, lo acordamos puntualmente\nsegun lo que ud desee hacer.\nSaludos\nLois\n\nEl 9/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#105) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Varadero\n> 2 personas\n>\n> Día del viaje: 21 Octubre, 2014 (Martes)\n>\n> Detalles del viaje: Hola, somos 2 personas, estaremos 2 días en la Habana y\n> luego nos vamos a Varadero, no quiero quedarme en varadero todo el día en el\n> hotel, quiero tratar de conocer lo que mas pueda.\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-09 19:24:24');
INSERT INTO `driver_traveler_conversations` (`id`, `conversation_id`, `response_by`, `response_text`, `created`) VALUES
(99, '540d5d66-e738-44b0-a962-4ba15bc25abe', 'traveler', 'Hola Lois,Lo que queremos hacer es un recorrido por varias ciudades, movernos libremente, pararnos d?nde nos apetezca, no llevar nada cerrado al 100 % a?n as? el itinerario que ten?amos pensado es el siguiente;1 DIA.  31 OctubreLLEGADA A LA HABANA  19.50H2 DIA. 01 NoviembreHABANA 3 DIA. 02 NoviembreHABANA4 DIA. 03 Noviembre (apartir de este dia es cu?ndo cogeriamos chofer)Vi?ales , Las Terrazas 5 DIA. 04 NoviembreVI?ALES, plantaciones, etc 6 DIA. 05 NoviembreCIEMFUEGOS  7, 8, 9 DIA. 06 - 07 - 08 NoviembreTRINIDAD 10 DIA. 09 NoviembreCAYO SANTA MARIA o CAYO GUILLERMO/ COCO (No lo tengo claro) Pero si pasar dos noches11 DIA. 10 NoviembreCAYO 12 DIA. 11 Noviembre (aqui ya dejariamos de usar el servicio chofer)CAYO A HABANA 13 DIA. 12 NoviembreVUELTA A MADRID 21.45 HDime si en base a esto puedes ofrecerme algo y ajustarme el precio.Gracias de nuevo, saludos.\nFrom: chofer@yotellevo.ahiteva.net\nTo: labeyo@hotmail.com\nDate: Tue, 9 Sep 2014 12:05:01 -0400\nSubject: Re: Nuevo Anuncio de Viaje [[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n\n\n\n    \n        Emails/html\n    \n    \n        \n    Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo, notificado con los datos de tu viaje La Habana - Vi?ales. Para enviar tu respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n\n\nEl chofer dice:\n\n\nHola muchas gracias por su respuesta\nEl gasto de combustible, depende de los recorridos adicionales a lo\nprevisto, oscila alrededor de los 60, 70 cuc, si pasamos la noche en\nalgun lugar el hospedaje corre por ud pero en un lugar economico cuyo\nprecio es entre  5 o 10 cuc.\nSaludos\nLois\n\nEl 9/9/14, YoTeLlevo | Viajero  escribi?:\n> Hola chofer. Este correo contiene la respuesta del viajero para el viaje\n> #104 (La Habana - Vi?ales). Para enviar tu respuesta, responde este correo\n> SIN MODIFICAR EL ASUNTO.\n>\n> El viajero dice:\n>\n> Hola Lois,\n> Y cu?l ser?a el gasto de gasolina estimado para ese viaje.Otra pregunta, el\n> gasto de alojamiento de usted correria por nuestra cuenta o no.\n> Gracias\n>\n> From: chofer@yotellevo.ahiteva.net\n> To: labeyo@hotmail.com\n> Date: Mon, 8 Sep 2014 08:50:01 -0400\n> Subject: Re: Nuevo Anuncio de Viaje\n[[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n>\n>\n>\n>\n> Emails/html\n>\n>\n>\n> Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo,\n> notificado con los datos de tu viaje La Habana - Vi?ales. Para enviar tu\n> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n>\n>\n> El chofer dice:\n>\n>\n> Hola\n> Estoy disponible para realizar el viaje, el precio es 70 cuc mas los\n> gastos de combustible\n> Saludos\n> Lois\n>\n> El 8/9/14, YoTeLlevo | Viajero escribi?:\n>> Hola Chofer,\n>>\n>> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n>> siguientes datos:\n>>\n>> --------------------\n>>\n>> La Habana - Vi?ales\n>> 4 personas\n>>\n>> D?a del viaje: 3 Noviembre, 2014 (Lunes)\n>>\n>> Detalles del viaje: Saldriamos de La Habana a Vi?ales pasando el dia por\n>> Las\n>> Terrazas y Soroa.\nUn saludo,\n>>\n>> Preferencias: Carro Moderno, Aire Acondicionado\n\n\n         		 	   		  \n\n', '2014-09-10 03:23:15'),
(100, '540f3dfe-1838-4f2f-a9cf-0a255bc25abe', 'driver', 'Hola\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPodemos satisfacer su solicitud, para lo cual podemos reservarle un\nauto moderno con aire acondicionado.\nSolo tiene que decirnos que lugares desea visitar y las fechas, y le\npodemos organizar un recorrido de forma tal que pueda aprovechar el\ntiempo lo más posible.\nEl precio del auto depende de la distancia a recorrer y la cantidad de\nnoches fuera de la Habana.\n\nEsperamos su confirmación con los lugares que desea visitar y poderle\nenviar un presupuesto.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales\n     Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-09 13:55 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#105) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Varadero\n> 2 personas\n>\n> Día del viaje: 21 Octubre, 2014 (Martes)\n>\n> Detalles del viaje: Hola, somos 2 personas, estaremos 2 días en la Habana y\n> luego nos vamos a Varadero, no quiero quedarme en varadero todo el día en el\n> hotel, quiero tratar de conocer lo que mas pueda.\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-10 14:56:40'),
(101, '540d5d66-e738-44b0-a962-4ba15bc25abe', 'driver', 'Hola Amigo\nMuchas gracias por mantener la comunicación, su viaje es extenso, pero\nmuy bello y confortable por los lugares donde desea visitar,  la\ndistancia a recorrer si incluir el Cayo es superior a los 1000 km voy\na ofertárselo por partes:\nDía 31 recogida en aeropuerto hasta su hospedaje 20 cuc sin gastos de\ncombustible para Ud., igual precio para el retorno al aeropuerto desde\nsu hospedaje en la Habana.\nDías en la Habana: 20 cuc por viajes hacia o desde algún destino ó 25\ncuc por día de hasta 5 horas diarias más 5 cuc por hora adicional sin\ngastos de combustible ni alimentación para Ud.\nDías fuera de la Habana hasta Trinidad (6 días) 70 cuc diario más\nalimentación y hospedaje (los cuales no serán entre ambos superiores\n10 cuc diarios pues me ajustaré a ello), más el combustible lo cual es\naproximadamente 150 cuc en total.\nSi Ud. esta de acuerdo con esta oferta, solo defíname a cual Cayo para\nhacerle la oferta de este viaje.\nSaludos\nLois\n\n\nEl 10/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola chofer. Este correo contiene la respuesta del viajero para el viaje\n> #104 (La Habana - Viñales). Para enviar tu respuesta, responde este correo\n> SIN MODIFICAR EL ASUNTO.\n>\n> El viajero dice:\n>\n> Hola Lois,Lo que queremos hacer es un recorrido por varias ciudades,\n> movernos libremente, pararnos dónde nos apetezca, no llevar nada cerrado al\n> 100 % aún así el itinerario que teníamos pensado es el siguiente;1 DIA. 31\n> OctubreLLEGADA A LA HABANA 19.50H2 DIA. 01 NoviembreHABANA 3 DIA. 02\n> NoviembreHABANA4 DIA. 03 Noviembre (apartir de este dia es cuándo cogeriamos\n> chofer)Viñales , Las Terrazas 5 DIA. 04 NoviembreVIÑALES, plantaciones, etc\n> 6 DIA. 05 NoviembreCIEMFUEGOS 7, 8, 9 DIA. 06 - 07 - 08 NoviembreTRINIDAD 10\n> DIA. 09 NoviembreCAYO SANTA MARIA o CAYO GUILLERMO/ COCO (No lo tengo claro)\n> Pero si pasar dos noches11 DIA. 10 NoviembreCAYO 12 DIA. 11 Noviembre (aqui\n> ya dejariamos de usar el servicio chofer)CAYO A HABANA 13 DIA. 12\n> NoviembreVUELTA A MADRID 21.45 HDime si en base a esto puedes ofrecerme algo\n> y ajustarme el precio.Gracias de nuevo, saludos.\n> From: chofer@yotellevo.ahiteva.net\n> To: labeyo@hotmail.com\n> Date: Tue, 9 Sep 2014 12:05:01 -0400\n> Subject: Re: Nuevo Anuncio de Viaje [[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n>\n>\n>\n>\n> Emails/html\n>\n>\n>\n> Hola viajero. Este correo contiene la respuesta del chofer #34 de YoTeLlevo,\n> notificado con los datos de tu viaje La Habana - Viñales. Para enviar tu\n> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n>\n>\n> El chofer dice:\n>\n>\n> Hola muchas gracias por su respuesta\n> El gasto de combustible, depende de los recorridos adicionales a lo\n> previsto, oscila alrededor de los 60, 70 cuc, si pasamos la noche en\n> algun lugar el hospedaje corre por ud pero en un lugar economico cuyo\n> precio es entre 5 o 10 cuc.\n> Saludos\n> Lois\n>\n> El 9/9/14, YoTeLlevo | Viajero escribió:\n>> Hola chofer. Este correo contiene la respuesta del viajero para el viaje\n>> #104 (La Habana - Viñales). Para enviar tu respuesta, responde este correo\n>> SIN MODIFICAR EL ASUNTO.\n>>\n>> El viajero dice:\n>>\n>> Hola Lois,\n>> Y cuál sería el gasto de gasolina estimado para ese viaje.Otra pregunta,\n>> el\n>> gasto de alojamiento de usted correria por nuestra cuenta o no.\n>> Gracias\n>>\n>> From: chofer@yotellevo.ahiteva.net\n>> To: labeyo@hotmail.com\n>> Date: Mon, 8 Sep 2014 08:50:01 -0400\n>> Subject: Re: Nuevo Anuncio de Viaje\n> [[540d5d66-e738-44b0-a962-4ba15bc25abe]]\n>>\n>>\n>>\n>>\n>> Emails/html\n>>\n>>\n>>\n>> Hola viajero. Este correo contiene la respuesta del chofer #34 de\n>> YoTeLlevo,\n>> notificado con los datos de tu viaje La Habana - Viñales. Para enviar tu\n>> respuesta, responde este correo SIN MODIFICAR EL ASUNTO.\n>>\n>>\n>> El chofer dice:\n>>\n>>\n>> Hola\n>> Estoy disponible para realizar el viaje, el precio es 70 cuc mas los\n>> gastos de combustible\n>> Saludos\n>> Lois\n>>\n>> El 8/9/14, YoTeLlevo | Viajero escribió:\n>>> Hola Chofer,\n>>>\n>>> Un nuevo anuncio de viaje (#104) ha sido registrado recientemente con los\n>>> siguientes datos:\n>>>\n>>> --------------------\n>>>\n>>> La Habana - Viñales\n>>> 4 personas\n>>>\n>>> Día del viaje: 3 Noviembre, 2014 (Lunes)\n>>>\n>>> Detalles del viaje: Saldriamos de La Habana a Viñales pasando el dia por\n>>> Las\n>>> Terrazas y Soroa.\n> Un saludo,\n>>>\n>>> Preferencias: Carro Moderno, Aire Acondicionado\n>\n>\n>\n>\n> -------------\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-11 00:43:28'),
(102, '540d0dce-badc-42d0-952e-35845bc25abe', 'driver', 'El viajé sale en 130fue saludo<br><br><br>YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> wrote:<br><br>><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">\n><html>\n>    <head>\n>        <title>Emails/html</title>\n>    </head>\n>    <body>\n>        <p>Hola Chofer,</p>\n><div>\n>    <p>\n>        Un nuevo anuncio de viaje (<b>#103</b>) ha sido registrado recientemente con los siguientes datos:\n>    </p>\n>    --------------------\n>    <p> \n>        \n>\n><legend>\n>   \n>    <small><i title="Confirmado" class="glyphicon glyphicon-flag" style="margin-left:-20px;color:#0088cc;display: inline-block"></i></small>\n>    <big>\n>        <b><span id=''travel-locality-label''>Manzanillo</span></b> \n>        - \n>        <b><span id=''travel-where-label''>Holgu&iacute;n</span></b>\n>    </big>\n>    <div style="display:inline-block"><small class="text-muted"><span id=''travel-prettypeoplecount-label''>2 personas</span></small></div>\n></legend>\n>    \n><p><b>Día del viaje:</b> <span id=''travel-date-label''>2 Enero, 2015 (Viernes)</span></p>\n>\n><p><b>Detalles del viaje:</b> <span id=''travel-details-label''>Hola! la idea ser&iacute;a viajar de Manzanillo a playa las coloradas; visitar parque nacional sierra maestra; parque desemabrco de Granma; Bayamo; llegar a Holgu&iacute;n. Lo pensamos en 4 o 5 d&iacute;as. &iquest;cu&aacute;nto nos saldr&iacute;a por d&iacute;a? &iquest;es posible hacerlo?\n>Gracias!\n>Marcelo.</span></p>\n>\n>\n><div id="preferences-place">\n></div>\n>\n>    </p>\n>    --------------------\n>    <p> \n>                \n>                Para comunicarte con el viajero <b>responde este correo SIN MODIFICAR EL ASUNTO</b>\n>        [<small><b>Nota:</b> Puedes responder desde otro correo, copiando el asunto de este correo en el que vayas a enviar</small>]\n>                        <div>¡Ponte en contacto  y haz que tu oferta sea la mejor!</div>\n>            </p>\n></div>\n>\n>\n>    <p>\n>        <small>\n>        Usted recibió este correo porque está registrado en <em>YoTeLlevo</em> \n>        como chofer que atiende viajes desde/hasta Manzanillo.\n>        </small>\n>    </p>\n>        <div>\n>            <p>Atentamente, el equipo de <a href="http://localhost/pages/home"><em>YoTeLlevo</em></a></p>\n>        </div>\n>    </body>\n></html>\n>\n>\n>\n', '2014-09-12 14:32:08'),
(103, '54197699-0764-49ea-9d94-61d45bc25abe', 'driver', 'Hola Rebeca\nMuchas gracias por incluirme en su opcion, el precio es de 200 CUC\npara el viaje de 2 dias a Viñales, aqui estan includo todos los\ngastos, para la segunda noche en la habana le tengo hospedaje, tambien\nle puedo gestinar hospedaje en otros lugares de Cuba a los que desee\nhacer visita.\nSaludos\nLois\n\nEl 17/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#106) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Viñales\n> 2 personas\n>\n> Día del viaje: 1 Diciembre, 2014 (Lunes)\n>\n> Detalles del viaje: Buenos días, Somos una pareja y tenemos intención de ir\n> de La Habana a Viñales el 1 de diciembre. La idea es pasar dos noches en esa\n> zona y seguir nuestro recorrido por la isla. Querría saber el coste de un\n> chófer para esos dos días en Viñales (no tendríamos problema de pasar la\n> segunda noche en Habana). Quisiera conocer disponibilidad, opciones de\n> visitas y precio. Un saludo, Rebeca\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-17 12:19:53'),
(104, '54197699-0d3c-480c-ab58-61d45bc25abe', 'driver', 'Hola Rebeca\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nPara satisfacer su solicitud podemos reservarle un auto con capacidad para\n3 pasajeros y los precios son los siguientes:\nVIÑALES\n1er. día\nRecogida en su domicilio. Salida hacia Viñales ? En dirección a\nViñales, breve descanso en el parador de carretera, para estirar las\npiernas ? Visita al mirador del Hotel Los Jazmines en el valle de\nViñales con tiempo para fotos ? Visita al valle Dos Hermanas con\ntiempo para fotos en el Mural de la Prehistoria ? Visita a una casa de\nfabricación de tabaco, parada y paseo por el pueblo de Viñales ?\nAlmuerzo en restaurant típico del lugar y posteriormente visita a la\nCueva del Indio con tiempo libre para que realicen paseo en bote por\nel rio subterráneo si lo desean. Alojamiento en casa particular. Noche\nlibre.\n2do. día\nSalida de Viñales temprano en la mañana. Paseo a caballo para visitar\ncuevas, bañarse en ríos, visitar casas de torcido de tabaco, etc. En\nla tarde regreso a la Habana\n\nPrecio........................345cuc\n(Incluye gastos de combustible, impuestos, salario y alojamiento del\nchofer, una noche de alojamiento en una casa particular con habitación\nclimatizada y baño independiente, 2 almuerzos y el paseo a caballo de\n2 horas).\n\nOTRAS OFERTAS DE EXCURSIONES\nGUAMÁ (340km)\nRecogida en su domicilio. Parada en Jagüey Grande para estirar las\npiernas. Visita al Centro Turístico de Guamá y el criadero de\ncocodrilos. Tiempo para recorrer lugares de interés y tirar fotos.\nRegreso a la Habana hasta su domicilio.\nAuto para 3 personas.......................130cuc**\n\nPLAYA GIRÓN (430km)\nRecogida en su domicilio. Parada en Jagüey Grande para estirar las\npiernas. Visita al Centro Turístico de Guamá, Playa Larga y Playa\nGirón. Tiempo para recorrer lugares de interés, tirar fotos y tomar un\nbaño en la playa. Regreso a la Habana hasta su domicilio.\nAuto para 3 personas.......................150cuc**\n\nCIENFUEGOS (520km)\nRecogida en su domicilio. Parada en Jagüey Grande para estirar las\npiernas. Visita al Centro Turístico de Guamá, Playa Larga y Playa\nGirón, Cienfuegos. Tiempo para recorrer lugares de interés, tirar\nfotos. Regreso a la Habana hasta su domicilio.\nAuto para 3 personas.......................205cuc**\n\nTRINIDAD (750km)\n1er. día\nRecogida en su domicilio (7:00 am) y salida hacia Trinidad. Parada en\nla cafetería de Aguada de los Pasajeros para estirar las piernas.\nTiempo para almorzar en Sancti-Spiritus (1:00 hora). Continuación\nhacia Trinidad. Llegada a la ciudad de Trinidad y tiempo de estancia\npara visita a lugares de interés y centros de venta de artesanías y\nregalos. Alojamiento en casas particulares y tiempo libre toda la\nnoche\n2do. Día\nVisita a la Playa Ancón y tiempo para disfrutar del baño de mar. A las\n3:00 pm salida hacia la Habana por el circuito sur, parada en Aguada\nde Pasajeros para estirar las piernas. Regreso a la Habana hasta su\ndomicilio.\nAuto para 3 personas.......................300cuc**\n\nCIENFUEGOS – TRINIDAD – STA. CLARA (830km)\n1er. día.\nRecogida en su domicilio (7:00am) y salida hacia Cienfuegos. Parada en\nla cafetería de Jagüey Grande para estirar las piernas. Continuación\nhasta el centro turístico de Guamá y tiempo para tomar fotos y ver el\ncriadero de cocodrilos. Salida rumbo a Playa Larga, tiempo para ver\nlas instalaciones turísticas y continuación hacia Playa Girón; tiempo\npara tomar fotos y ver las instalaciones. Salida con rumbo a\nCienfuegos; Llegada a la ciudad y tiempo para visitas a lugares de\ninterés y centros de venta de artesanía y regalos. Alojamiento en\ncasas particulares y tiempo libre toda la noche.\n2do. día\nSalida hacia Trinidad por el circuito sur próximo a la costa. En el\ntrayecto pasaremos por las Playas de Cabagán, Río Hondo, Yaguanabo y\nel Inglés. Llegada a la ciudad de Trinidad y tiempo de estancia para\nvisita a lugares de interés y centros de venta de artesanías y\nregalos. Alojamiento en casas particulares y tiempo libre toda la\nnoche.\n3er. día\nSalida hacia Sta. Clara. En el trayecto pasaremos por el Mirador del\nValle de los Ingenios, la torre de Iznaga y la ciudad de\nSancti-Spiritus donde almorzaremos en el Ranchón el Tenis. Al llegar a\nla ciudad de Sta. Clara visitaremos el mausoleo del Ché y\nposteriormente continuaremos hacia la Habana con parada en la\ncafetería de Aguada de los Pasajeros para refrescar y estirar las\npiernas.\nAuto para 3 personas.......................350cuc**\n\n** Los precios NO incluyen alojamiento y comida.\n\nEsperamos su confirmación y las fechas para proceder con la reservación.\nGracias por contactar YoTeLlevo\nSaludos\n      Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-17 8:00 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#106) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Viñales\n> 2 personas\n>\n> Día del viaje: 1 Diciembre, 2014 (Lunes)\n>\n> Detalles del viaje: Buenos días, Somos una pareja y tenemos intención de ir\n> de La Habana a Viñales el 1 de diciembre. La idea es pasar dos noches en esa\n> zona y seguir nuestro recorrido por la isla. Querría saber el coste de un\n> chófer para esos dos días en Viñales (no tendríamos problema de pasar la\n> segunda noche en Habana). Quisiera conocer disponibilidad, opciones de\n> visitas y precio. Un saludo, Rebeca\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-17 18:15:47'),
(105, '541b41db-c37c-4170-a26b-2eee5bc25abe', 'driver', 'Hola Silvia\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nLa recogida en el aeropuerto y traslado a Luyanó en un auto VAN con\ncapacidad para 6 personas son 35cuc\n\nPodemos satisfacer su solicitud. Los precios de los autos tipo VAN con\ncapacidad para 6 pasajeros y aire acondicionado, son los siguientes:\n\nPara viajes dentro de la ciudad de la Habana\n(incluye hasta Playas del Este)............................. 130cuc diarios\n\nPara viajes fuera de la provincia de la Habana los precios dependen de\nla distancia a recorrer y la cantidad de noches fuera.\n\nEn los precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer cuando se pernocte fuera de la\nHabana.\n\nEsperamos su confirmación y puede escribirnos directamente a nuestro\ncorreo cubamitaxi@gmail.com o llamarnos a nuestros teléfonos que\naparecen en el pie de firma.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n     Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-18 16:35 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#107) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> Aeropuerto Jose Marti - luyano\n> 5 personas\n>\n> Día del viaje: 8 Diciembre, 2014 (Lunes)\n>\n> Detalles del viaje: Estaremos 1 semana en Cuba, quiero saber cuanto me\n> cuesta contratar un carro que me mueva durante el dia a distintos lugares.\n> Gracias Silvia\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta Boyeros.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-19 18:56:43'),
(106, '541b41db-c37c-4170-a26b-2eee5bc25abe', 'driver', 'Hola Silvia\nHemos recibido copia de su solicitud a YoTeLlevo.\nSoy Ovidio, el gerente de Operaciones de MITAXI, el grupo de\ntransportación en Cuba de las agencias BOOKINGHAVANA, HAVANA HOLDING\nL.T.D. y ARTISAL. Es un placer atenderle.\n\nLa recogida en el aeropuerto y traslado a Luyanó en un auto VAN con\ncapacidad para 5 personas son 35cuc\n\nPodemos satisfacer su solicitud. Los precios de los autos tipo VAN con\ncapacidad para 6 pasajeros y aire acondicionado, son los siguientes:\n\nPara viajes dentro de la ciudad de la Habana\n(incluye hasta Playas del Este)............................. 130cuc diarios\n\nPara viajes fuera de la provincia de la Habana los precios dependen de\nla distancia a recorrer y la cantidad de noches fuera.\n\nEn los precios están incluidos los gastos de combustible, impuestos,\nsalario y alojamiento del chofer cuando se pernocte fuera de la\nHabana.\n\nEsperamos su confirmación y puede escribirnos directamente a nuestro\ncorreo cubamitaxi@gmail.com o llamarnos a nuestros teléfonos que\naparecen en el pie de firma.\nGracias por confiar en YoTeLlevo y en MITAXI.\nSaludos cordiales.\n     Ovidio\n      MITAXI\nBOOKING HAVANA\ncubamitaxi@gmail.com\nTelef.: +5378320872\nMóvil: +5352426026\n\n\n2014-09-18 16:35 GMT-04:00, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net>:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#107) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> Aeropuerto Jose Marti - luyano\n> 5 personas\n>\n> Día del viaje: 8 Diciembre, 2014 (Lunes)\n>\n> Detalles del viaje: Estaremos 1 semana en Cuba, quiero saber cuanto me\n> cuesta contratar un carro que me mueva durante el dia a distintos lugares.\n> Gracias Silvia\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta Boyeros.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-19 19:03:57'),
(107, '541cb7d2-f6f0-4a2b-adda-2d4a5bc25abe', 'driver', 'Hola\nMuchas gracias por tenerme en cuenta entre sus opciones para viaje a\nVaradero de 2 personas, estoy disponible esa fecha, el precio por\nllevarlos es de 75 cuc, si el viaje es ida y recogida dias despues\npues tiene descuento de 5 cuc la ida y 5  cuc el regreso, puede\ncontacatarme por el 53599405 o el email loisidal14@gmail.com\n\nSaludos\nLois\n\n\nEl 19/9/14, YoTeLlevo | Viajero <viajero@yotellevo.ahiteva.net> escribió:\n> Hola Chofer,\n>\n> Un nuevo anuncio de viaje (#108) ha sido registrado recientemente con los\n> siguientes datos:\n>\n> --------------------\n>\n> La Habana - Varadero\n> 2 personas\n>\n> Día del viaje: 13 Noviembre, 2014 (Jueves)\n>\n> Detalles del viaje: Qusiera comparar con otras opciones. Asumo que el viaje\n> no será compartido por otros pasajero\n>\n> Preferencias: Carro Moderno, Aire Acondicionado\n>\n> --------------------\n>\n> Para comunicarte con el viajero responde este correo SIN MODIFICAR EL ASUNTO\n> [Nota: Puedes responder desde otro correo, copiando el asunto de este correo\n> en el que vayas a enviar]\n> ¡Ponte en contacto y haz que tu oferta sea la mejor!\n>\n> Usted recibió este correo porque está registrado en YoTeLlevo como chofer\n> que atiende viajes desde/hasta La Habana.\n>\n> Atentamente, el equipo de YoTeLlevo\n\n', '2014-09-20 08:33:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_attachments`
--

DROP TABLE IF EXISTS `email_attachments`;
CREATE TABLE IF NOT EXISTS `email_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `mimetype` varchar(50) NOT NULL,
  `email_queue_id` char(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_queue`
--

DROP TABLE IF EXISTS `email_queue`;
CREATE TABLE IF NOT EXISTS `email_queue` (
  `id` char(36) CHARACTER SET ascii NOT NULL,
  `to` varchar(129) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `config` varchar(30) NOT NULL,
  `template` varchar(50) NOT NULL,
  `layout` varchar(50) NOT NULL,
  `format` varchar(5) NOT NULL,
  `template_vars` text NOT NULL,
  `sent` tinyint(1) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `send_tries` int(2) NOT NULL,
  `send_at` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localities`
--

DROP TABLE IF EXISTS `localities`;
CREATE TABLE IF NOT EXISTS `localities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `province_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `localities_province_fk` (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `localities`
--

INSERT INTO `localities` (`id`, `name`, `province_id`) VALUES
(1, 'Bayamo', 1),
(2, 'Manzanillo', 1),
(5, 'Santiago de Cuba', 2),
(6, 'Contramaestre', 2),
(7, 'Palma Soriano', 2),
(9, 'Holguín', 4),
(10, 'Habana Vieja', 5),
(11, 'Vedado', 5),
(12, 'Guanabacoa', 5),
(13, 'Playa', 5),
(14, 'Varadero', 6),
(15, 'Boyeros', 5),
(16, 'La Habana', 5),
(17, 'Santa Clara', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localities_thesaurus`
--

DROP TABLE IF EXISTS `localities_thesaurus`;
CREATE TABLE IF NOT EXISTS `localities_thesaurus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `locality_id` bigint(20) unsigned NOT NULL,
  `fake_name` varchar(250) COLLATE latin1_bin NOT NULL,
  `real_name` varchar(250) COLLATE latin1_bin NOT NULL,
  `use_as_hint` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `locality_id` (`locality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `localities_thesaurus`
--

INSERT INTO `localities_thesaurus` (`id`, `locality_id`, `fake_name`, `real_name`, `use_as_hint`) VALUES
(1, 2, 'Niquero', 'Niquero', 1),
(2, 1, 'Granma', 'Granma', 1),
(3, 7, 'Palma', 'Palma Soriano', 0),
(4, 5, 'Santiago', 'Santiago de Cuba', 0),
(7, 5, 'Tercer Frente', 'Tercer Frente', 0),
(8, 5, '3er Frente', 'Tercer rente', 0),
(9, 5, 'III Frente', 'Tercer Frente', 0),
(11, 1, 'Marea del Portillo', 'Playa Marea del Portillo', 0),
(13, 9, 'Guardalavaca', 'Playa Guardalavaca', 0),
(14, 2, 'Cabo Cruz | Niquero, Granma', 'Cabo Cruz', 1),
(15, 9, 'Playa Guardalavaca', 'Playa Guardalavaca', 1),
(16, 9, 'Moa', 'Moa', 0),
(17, 9, 'Aeropuerto Frank País | Holguín', 'Aeropuerto Frank País', 1),
(18, 5, 'Aeropuerto Antonio Maceo | Santiago de Cuba', 'Aeropuerto Antonio Maceo', 1),
(19, 2, 'Aeropuerto Sierra Maestra | Manzanillo', 'Aeropuerto Sierra Maestra', 1),
(20, 2, 'Playa Marea del Portillo', 'Playa Marea del Portillo', 1),
(21, 1, 'Aeropuerto Carlos Manuel de Céspedes | Bayamo', 'Aeropuerto Carlos Manuel de Céspedes', 1),
(22, 5, 'Baconao | Santiago de Cuba', 'Baconao', 1),
(23, 9, 'Gibara', 'Gibara', 1),
(24, 5, 'La Gran Piedra | Santiago de Cuba', 'La Gran Piedra', 1),
(25, 15, 'Aeropuerto José Martí | La Habana', 'Aeropuerto José Martí', 1),
(26, 16, 'Habana', 'La Habana', 0),
(27, 14, 'Aeropuerto Juan Gualberto Gómez | Varadero', 'Aeropuerto Juan Gualberto Gómez', 1),
(28, 16, 'Havana', 'La Habana', 0),
(29, 17, 'Sagua La Grande | Villa Clara', 'Sagua La Grande', 1),
(30, 17, 'Sagua', 'Sagua La Grande', 0),
(31, 17, 'Villa Clara', 'Villa Clara', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pending_travels`
--

DROP TABLE IF EXISTS `pending_travels`;
CREATE TABLE IF NOT EXISTS `pending_travels` (
  `id` char(36) CHARACTER SET ascii NOT NULL,
  `origin` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  `locality_id` bigint(20) unsigned NOT NULL,
  `direction` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `people_count` int(11) NOT NULL,
  `details` text NOT NULL,
  `need_modern_car` tinyint(1) NOT NULL,
  `need_air_conditioner` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `created` date NOT NULL,
  `created_from_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `pending_travels_locality_fk` (`locality_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pending_travels`
--

INSERT INTO `pending_travels` (`id`, `origin`, `destination`, `locality_id`, `direction`, `date`, `people_count`, `details`, `need_modern_car`, `need_air_conditioner`, `email`, `created`, `created_from_ip`) VALUES
('542c6dfc-8bfc-449b-a5ce-0db810d2655b', 'Havana', 'Varadero', 14, 1, '2014-10-25', 1, 'fd fdsf dsf sdf', 0, 0, 'rg@rg.rg', '2014-10-01', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `provinces`
--

INSERT INTO `provinces` (`id`, `name`) VALUES
(1, 'Granma'),
(2, 'Santiago de Cuba'),
(4, 'Holguín'),
(5, 'La Habana'),
(6, 'Matanzas'),
(7, 'Villa Clara');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `travels`
--

DROP TABLE IF EXISTS `travels`;
CREATE TABLE IF NOT EXISTS `travels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `origin` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  `locality_id` bigint(20) unsigned NOT NULL,
  `direction` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `people_count` int(11) NOT NULL,
  `details` text NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `state` char(1) NOT NULL,
  `drivers_sent_count` int(10) unsigned NOT NULL,
  `need_modern_car` tinyint(1) NOT NULL,
  `need_air_conditioner` int(11) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `created_from_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `travels_locality_fk` (`locality_id`),
  KEY `travels_user_fk` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Volcado de datos para la tabla `travels`
--

INSERT INTO `travels` (`id`, `origin`, `destination`, `locality_id`, `direction`, `date`, `people_count`, `details`, `user_id`, `state`, `drivers_sent_count`, `need_modern_car`, `need_air_conditioner`, `created`, `modified`, `created_from_ip`) VALUES
(48, '', '', 9, 0, '2014-07-28', 1, 'necesito rentar auto sin chófer  por dos semanas con a/c', 24, 'C', 1, 0, 1, '2014-06-01', '2014-06-01', '190.214.142.163'),
(50, '', '', 9, 1, '2014-07-28', 1, 'necesito auto sin chofer por dos semanas con A/C     contactar EMAIL:ausbertosanpor@hotmail.es', 24, 'C', 1, 0, 1, '2014-06-04', '2014-06-04', '186.178.246.54'),
(59, 'bayamo', 'Holguín', 1, 0, '2014-06-16', 3, 'Jorge 52180405', 27, 'C', 3, 0, 0, '2014-06-13', '2014-06-13', '200.55.152.130'),
(61, 'Varadero', 'Rio Hatiguanico', 14, 0, '2014-08-20', 2, 'Quisiera combinar con un taxista, acordar la tarifa para ir del melia antillas de varadero al Rio Hatiguanico que segun mis calculos son 115 km. Ver que condiciones y tal vez relizarlo durante 2 o 3 dias. Mi correo es pablogerard@yahoo.com y soy de Rio Cuarto, Cordoba, Argentina. Mi nombre es Pablo. Muchas Gracias', 33, 'C', 1, 0, 1, '2014-06-25', '2014-06-25', '186.108.254.98'),
(62, 'Havana', 'Havana', 16, 0, '2014-07-11', 2, 'Queremos contratar un coche con chófer para un viaje por toda Cuba desde el 11.07.2014 hasta el 27.07.2014. Punto de origen i regreso desde la Havana (Vedado).\r\nContactar con Laura a laura.busquets@gmail.com', 34, 'C', 1, 0, 0, '2014-06-26', '2014-06-26', '77.210.52.145'),
(63, 'la habana ', 'Santiago de Cuba', 5, 1, '2014-07-25', 2, 'hola,necesito viajar a santiado desde la habana y queria saber el precio y el tiempo aproximado.\r\npara enviar la respuesta hagalo en la direccion de correo victorgijon@hotmail.com\r\n\r\ngracias', 35, 'C', 3, 0, 0, '2014-07-08', '2014-07-08', '93.156.65.51'),
(64, 'Aeropuerto José Martí | Habana', 'Habana Vieja', 10, 1, '2014-07-16', 2, 'Buenos dias, somos una pareja interesada en hacer una ruta por cuba.\r\nNuestra idea es aterrizar e ir direc\r\ntos a viñales. Alli pasar un par d\r\ne dias y movernos por la zona.\r\nIr a algunos cayos y si diese tiempo o nos cuadrase ir a la zona de cienfuegos y trinidad.\r\nHemos calculado una semana.\r\nTenems varias experiencias viajajando de esta forma por el mindoy la', 36, 'C', 1, 0, 0, '2014-07-13', '2014-07-13', '31.4.218.23'),
(65, 'Habana Vieja', 'Santiago de Cuba', 5, 1, '2015-01-14', 2, 'Hola soy Marcela. Viajo en enero 2015 a La Habana y queremos recorrer todo lo posible de Cuba, ya que estaremos un mes . Me gustaria que me armen un buen itinerario que abarque la parte historica, ya que es lo que mas nos interesa. Tambien queremos conocer las playas mas hermosas. Y nos gustaria que nos recomienden hospedajes economicos en casas de familia ya que queremos estar en contacto con los cubanos. Somos argentinos\r\nSe pueden comunicar al mail:  marcelaguf@gmail.com o al celu 542215935699', 37, 'C', 3, 0, 0, '2014-07-13', '2014-07-13', '190.50.4.90'),
(66, 'Aeropuerto José Martí | Habana', 'Varadero', 14, 1, '2014-08-20', 1, 'necesito taxi, 1 persona 2 maletas, hora 7 pm, enviar email a, jose.alfonso2011@gmail.com', 38, 'C', 1, 0, 0, '2014-07-14', '2014-07-14', '81.202.130.24'),
(67, 'Santiago de Cuba', 'Santiago de Cuba', 5, 0, '2014-08-07', 2, 'escribame a serena.sileoni@brunoleoni.it', 39, 'C', 3, 0, 0, '2014-07-15', '2014-07-15', '93.44.229.214'),
(68, 'Bayamo', 'pinar del rio', 1, 0, '2014-08-10', 4, 'Bayamones@gmail.com necesito saber si renta sin chofer también y los precios gracias', 41, 'C', 3, 1, 1, '2014-07-21', '2014-07-21', '172.56.41.118'),
(69, 'Aeropuerto José Martí | Habana', 'la habana', 16, 1, '2014-08-11', 3, 'escribir a musiquitor@hotmail.es o enviar whatss al 659395350. si el taxista es interesante, nos interesara hacer rutas por viñales, cienfuegos...', 43, 'C', 1, 0, 1, '2014-07-28', '2014-07-28', '80.38.23.122'),
(70, 'La Habana', 'Recorrido por la isla', 16, 0, '2014-09-11', 1, 'mi noimbre es miguel angel sanmiguel kumul soy de mexico en especifico de merida yucatan llego el dia jueves 11 de septiembre a las 2 de la tarde en la terminal 3 por la linea areromexico, el vuelo es 548 procedente de cancun necesito un viaje a las tunas y puerto padre palma soriano voy estar una semana 7 dias mi correo es mask141@hotmail.com espero pronta respuesta', 44, 'C', 1, 0, 1, '2014-07-29', '2014-07-29', '200.79.20.137'),
(71, 'La Habana', 'Trinidad', 16, 0, '2014-12-05', 2, 'Hola, nos gustaría visitar Trinidad, pero sin la presión de una ruta guiada que, al final, no permite dedicar el tiempo deseado a pasear. ¿Podrían enviarme información sobre el coche, conductor y horario recomendado para la visita por favor?', 45, 'C', 1, 1, 1, '2014-08-05', '2014-08-05', '213.0.55.164'),
(72, 'La Habana', 'Cayo coco', 16, 0, '2014-08-11', 2, 'Somos dos, un chico y una chica. Nuestra intención es salir de La Habana el día 11 de Agosto y realizar un recorrido por cuba, pernoctando en Santa Clara, Trinidad, Cienfuegos, Camegüey, Santiago de Cuba ypor último el día 17 en Morón o cualquier otro sitio cerca de Cayo coco. Para estar el día 18 por la mañana en Cayo Coco. \r\nMi correo es Trom_10@hotmail.com', 46, 'C', 1, 0, 0, '2014-08-06', '2014-08-06', '90.164.112.94'),
(73, 'La Habana', 'Recorrido por la isla', 16, 0, '2014-08-14', 4, 'Contactar a vadaverrak4@hotmail.com\r\n\r\nUn saludo\r\n\r\nIliana', 47, 'C', 1, 0, 0, '2014-08-09', '2014-08-09', '90.174.169.137'),
(74, 'La Habana', 'Recorrido por la isla', 16, 0, '2014-10-14', 5, 'iremos a cuba con familia estaremos desde 9 al 15 en varadero y a partir del 15 al 17 en La Habana, quisiera saber en que momento seria conveniente hacer un recorrido por la isla y el precio. Gracias comunicarse al mail sergio.sierralta@yahoo.com.ar', 48, 'C', 1, 0, 0, '2014-08-12', '2014-08-12', '186.125.13.235'),
(75, 'Varadero', 'recorrer la isla', 14, 0, '2014-08-23', 2, 'voy a estar en varadero', 49, 'C', 1, 0, 0, '2014-08-13', '2014-08-13', '186.53.72.158'),
(76, 'La Habana', 'Varadero', 16, 0, '2014-09-04', 1, 'soy hombre gay joven en busca de buenas experiencias', 50, 'C', 1, 1, 0, '2014-08-13', '2014-08-13', '201.140.191.205'),
(79, 'La Habana', 'Varadero', 16, 0, '2014-09-08', 2, 'La posibilidad de convinar taxi colectivo para aprovechar y amortizar viaje. el horario se puede llegar a un acuerdo seria ida ese día y arreglar regreso maso menos en 4/5/6 días posteriores\r\nGracias\r\n ', 51, 'C', 1, 0, 0, '2014-08-20', '2014-08-20', '200.127.35.155'),
(81, 'La Habana', 'Recorrido por la isla', 16, 0, '2014-09-05', 2, 'hola. estaremos 2 dias en la habana , y volveremos dos dias mas pasados cuatro, necesitaremos taxi para los dos primeros y si todo va bien para los dos ultimos, contacta en premarsl@premarsl.info, gracias, nos vemos', 52, 'C', 1, 0, 1, '2014-08-24', '2014-08-24', '185.9.195.41'),
(85, 'Aeropuerto José Martí | La Habana', 'La Habana', 16, 1, '2014-09-08', 2, 'Hola me gustaria saber como puedo reservar un taxi para ir del aeropuerto, al hotel y solicitar informacion para otras excursiones que estoy interesada realizar alli.\r\n\r\n', 54, 'C', 1, 0, 0, '2014-08-28', '2014-08-28', '95.23.6.150'),
(91, 'Villa Clara', 'Santiago de Cuba', 5, 1, '2014-09-07', 6, 'espero una buena oferta', 57, 'C', 1, 1, 0, '2014-09-02', '2014-09-02', '78.53.219.40'),
(95, 'Santiago de Cuba', 'BARACOA', 5, 0, '2014-09-12', 2, 'Tenemos previsto hacer ese viaje de Santiago a Baracoa en ese día 12, somos dos personas con dos maletas. Querriamos saber presupuesto, supongo mas barato que via azul. espero.\r\nMuchas gracias\r\nArantza', 58, 'C', 3, 0, 0, '2014-09-03', '2014-09-03', '193.146.183.193'),
(96, 'Aeropuerto José Martí | La Habana', 'La Habana', 16, 1, '2014-09-07', 2, 'Seria para ir a Habana del este', 60, 'C', 1, 0, 0, '2014-09-04', '2014-09-04', '81.45.26.85'),
(97, 'La Habana', 'Recorrido por la isla', 16, 0, '2014-12-23', 3, 'Me gustaría hacer una ruta de 5 días por el interior de Cuba', 61, 'C', 1, 0, 0, '2014-09-04', '2014-09-04', '80.27.146.37'),
(98, 'Varadero', 'cayo guillermo', 14, 0, '2014-11-25', 2, 'la fecha puede variar en uno o dos dias', 62, 'C', 1, 0, 0, '2014-09-04', '2014-09-04', '201.177.12.235'),
(99, 'La Habana', '8 DIAS POR LA ISLA, VIÑALES TRINIDAD ETC', 16, 0, '2014-10-01', 2, 'buenas tardes,\r\nsomo un matrimonio español, queremos hacer una ruta de unos 8 dias por la isla saliendo desde La habana, viendo lo tipico y lo mnos tipo que seguro que es mas bonito, (soy fotografo aficionado) ,ir a algun calas ,   es es nuestra idea.\r\n\r\nMuchas gracias', 63, 'C', 2, 1, 1, '2014-09-05', '2014-09-05', '88.2.252.44'),
(100, 'La Habana', 'Varadero', 16, 0, '2014-09-20', 6, 'Somos 6 personas y tambien quisieramos nos recojan el dia 26. Somos cubanossss, jaja. Pueden llamarme al 052635881 Saludos', 64, 'C', 1, 0, 0, '2014-09-06', '2014-09-06', '190.15.156.53'),
(101, 'La Habana', 'varios', 16, 0, '2014-10-15', 4, '?Miércoles 15 LA HABANA/PINAR DEL RÍO \r\n?Jueves 16 PINAR DEL RÍO/VIÑALES \r\n?Viernes 17 VIÑALES (VISITAR LA ZONA)\r\n?Sábado 18 VIÑALES A PALMA RUBIA \r\n?Domingo 19 VIÑALES A CIENFUEGOS \r\n?lunes 20 CIENFUEGOS A TRINIDAD \r\n?Martes 21 Playa Ancón\r\n?Jueves 23 TRINIDAD A SANTA CLARA\r\n?Viernes 24 SANTA CLARA A VARADERO\r\nEste seria mas o menos el recorrido. Queremos saber el precio con todo incluido\r\n\r\n', 65, 'C', 2, 1, 1, '2014-09-06', '2014-09-06', '88.25.109.69'),
(102, 'La Habana', 'Trinidad', 16, 0, '2014-09-11', 2, 'turistico', 66, 'C', 2, 0, 0, '2014-09-07', '2014-09-07', '83.60.44.156'),
(103, 'Manzanillo', 'Holguín', 2, 0, '2015-01-02', 2, 'Hola! la idea sería viajar de Manzanillo a playa las coloradas; visitar parque nacional sierra maestra; parque desemabrco de Granma; Bayamo; llegar a Holguín. Lo pensamos en 4 o 5 días. ¿cuánto nos saldría por día? ¿es posible hacerlo?\r\nGracias!\r\nMarcelo.', 67, 'C', 3, 0, 0, '2014-09-07', '2014-09-07', '200.127.235.22'),
(104, 'La Habana', 'Viñales', 16, 0, '2014-11-03', 4, 'Saldriamos de La Habana a Viñales pasando el dia por Las Terrazas y Soroa.\r\nUn saludo,', 68, 'C', 2, 1, 1, '2014-09-08', '2014-09-08', '46.26.112.13'),
(105, 'La Habana', 'Varadero', 16, 0, '2014-10-21', 2, 'Hola, somos 2 personas, estaremos 2 días en la Habana y luego nos vamos a Varadero, no quiero quedarme en varadero todo el día en el hotel, quiero tratar de conocer lo que mas pueda.', 69, 'C', 2, 0, 0, '2014-09-09', '2014-09-09', '200.10.0.2'),
(106, 'La Habana', 'Viñales', 16, 0, '2014-12-01', 2, 'Buenos días,\r\n\r\nSomos una pareja y tenemos intención de ir de La Habana a Viñales el 1 de diciembre. La idea es pasar dos noches en esa zona y seguir nuestro recorrido por la isla.\r\n\r\nQuerría saber el coste de un chófer para esos dos días en Viñales (no tendríamos problema de pasar la segunda noche en Habana).\r\n\r\nQuisiera conocer disponibilidad, opciones de visitas y precio.\r\n\r\nUn saludo,\r\n\r\nRebeca ', 71, 'C', 2, 0, 0, '2014-09-17', '2014-09-17', '80.36.74.181'),
(107, 'Aeropuerto Jose Marti', 'luyano', 15, 0, '2014-12-08', 5, 'Estaremos 1 semana en Cuba, quiero saber cuanto me cuesta contratar un carro que me mueva durante el dia a distintos lugares.\r\nGracias\r\nSilvia', 72, 'C', 1, 1, 1, '2014-09-18', '2014-09-18', '66.176.30.160'),
(108, 'La Habana', 'Varadero', 16, 0, '2014-11-13', 2, 'Qusiera comparar con otras opciones. Asumo que el viaje no será compartido por otros pasajero', 73, 'C', 2, 1, 1, '2014-09-19', '2014-09-19', '186.135.13.17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `travels_by_email`
--

DROP TABLE IF EXISTS `travels_by_email`;
CREATE TABLE IF NOT EXISTS `travels_by_email` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_origin` varchar(250) COLLATE latin1_bin NOT NULL,
  `user_destination` varchar(250) COLLATE latin1_bin NOT NULL,
  `matched` varchar(250) COLLATE latin1_bin NOT NULL,
  `locality_id` bigint(20) unsigned NOT NULL,
  `where` varchar(250) COLLATE latin1_bin NOT NULL,
  `direction` int(11) NOT NULL,
  `description` varchar(1000) COLLATE latin1_bin NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `state` varchar(250) COLLATE latin1_bin NOT NULL,
  `drivers_sent_count` int(11) NOT NULL,
  `need_modern_car` tinyint(1) NOT NULL,
  `need_air_conditioner` tinyint(1) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=38 ;

--
-- Volcado de datos para la tabla `travels_by_email`
--

INSERT INTO `travels_by_email` (`id`, `user_origin`, `user_destination`, `matched`, `locality_id`, `where`, `direction`, `description`, `user_id`, `state`, `drivers_sent_count`, `need_modern_car`, `need_air_conditioner`, `created`, `modified`) VALUES
(35, 'La Habana', 'Santiago de cuba', 'Santiago de Cuba', 5, 'La Habana', 1, 'Contactar con Alejandro al 52721824 o al 6405136.\n\n \n\nSaludos \n\n \n\nDe: M.Aguero [mailto:mercedes.delgado@infomed.sld.cu] \nEnviado el: domingo, 27 de julio de 2014 16:20\nPara: &#039;viajes@yotellevo.ahiteva.net&#039;\nAsunto: habana granma o santiago \n\n \n\nNecesito realizar viaje dos personas \n\n \n\nDestino : Santiago o Granma \n\nOrigen: Habana\n\n \n\nSalida para el 1 de agosto o el 2 de agosto\n\n \n\nCon Retorno a la habana el 9 o el 10 agosto.\n\n \n\nEspero respuesta \n\n \n\nSaludos \n\n \n\n \n\n\n\n--\nNunca digas nunca, di mejor: gracias, permiso, disculpe.\n\nEste mensaje le ha llegado mediante el servicio de correo electronico que ofrece Infomed para respaldar el cumplimiento de las misiones del Sistema Nacional de Salud. La persona que envia este correo asume el compromiso de usar el servicio a tales fines y cumplir con las regulaciones establecidas\n\nInfomed: http://www.sld.cu/', 42, 'C', 3, 0, 0, '2014-07-27', '2014-07-27'),
(36, 'Holguin', 'Habana', 'Habana', 16, 'Holguin', 1, 'A mi correo 1\n\n ', 14, 'C', 2, 0, 0, '2014-08-20', '2014-08-20'),
(37, 'la Habana', 'recorrido por Cuba', 'La Habana', 16, 'recorrido por Cuba', 0, 'Buenos d?as: Somos dos personas, necesitar?amos saber precio y disponibilidad de un coche con chofer, con aire acondicionado, para un recorrido de 10 d?as partiendo desde La Habana para recorrer Vi?ales, Pinar del R?o, cabo Mar?a la Gorda, Ci?naga de Zapata, Cienfuegos, Trinidad y Matanzas y regreso a la Habana.Muchas gracias.\nLeticia Rodr?guez 		 	   		  \n\n', 53, 'C', 1, 0, 0, '2014-08-27', '2014-08-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `display_name` varchar(200) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `travel_count` int(11) NOT NULL,
  `travel_by_email_count` bigint(20) NOT NULL,
  `created` date NOT NULL,
  `registered_from_ip` varchar(100) DEFAULT NULL,
  `register_type` varchar(100) DEFAULT NULL,
  `unsubscribe_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `active`, `display_name`, `email_confirmed`, `travel_count`, `travel_by_email_count`, `created`, `registered_from_ip`, `register_type`, `unsubscribe_date`) VALUES
(3, 'mproenza@grm.desoft.cu', '60dd56fce363a2e493ae60bfdc64a9dffb0b227b', 'admin', 1, 'Martin Proenza', 1, 0, 1, '0000-00-00', '127.0.0.1', NULL, NULL),
(24, 'ausbertosanpor@hotmail.es', 'a602388a6461963514212c34b5e1204e10cc8ba4', 'regular', 1, '', 1, 2, 0, '2014-06-01', '190.214.142.163', 'pending_travel_regis', NULL),
(25, 'lianet@ksabes.com', '204108a490a17884eefee673efd19506360115af', 'regular', 1, '', 1, 0, 0, '2014-06-02', '200.55.136.99', 'register_form', NULL),
(26, 'EGPARDO2003@YAHOO.ES', 'a5bbe188c3dbbc394f95cfdb5b9ce533dd916b33', 'regular', 1, '', 1, 0, 0, '2014-06-02', '83.59.240.176', 'register_form', NULL),
(27, 'jorge.suarez@etecsa.cu', '944bdd2fa23d498dab0ad8f617c4ff615326a04b', 'regular', 1, 'jorge.suarez@etecsa.cu', 0, 1, 0, '2014-06-12', '200.55.152.130', 'register_form', NULL),
(28, 'josemrodriguez89@gmail.com', '15c4f6f43b1c41bb3a3b84b71feaa591a1c245f5', 'regular', 1, '', 0, 0, 0, '2014-06-16', '200.55.181.32', 'register_form', NULL),
(30, 'yorangellao@gmail.com', '87dbfd1ba778b04e61679630c14a9e2d80816da7', 'regular', 1, '', 0, 0, 0, '2014-06-24', '201.238.209.35', 'register_form', NULL),
(31, 'ymendoza@uci.cu', '5a193362c07691444ffc75f4b6a416dc5b808692', 'regular', 1, '', 0, 0, 0, '2014-06-24', '200.55.140.181', 'register_form', NULL),
(32, 'alexeirivera87@gmail.com', '40dba8f6d7992e11f72b90a2a0f33c838f3b1486', 'regular', 1, '', 0, 0, 0, '2014-06-24', '200.55.184.18', 'register_form', NULL),
(33, 'pablogerard@yahoo.com', '804039cf3903c8d739b83813455ccc96f90a369d', 'regular', 1, '', 1, 1, 0, '2014-06-25', '186.108.254.98', 'pending_travel_register_form', NULL),
(34, 'laura.busquets@gmail.com', 'fe6a1f881e0fa5eae1e2b633fb8f59e6cc8ae24b', 'regular', 1, '', 1, 1, 0, '2014-06-26', '77.210.52.145', 'pending_travel_register_form', NULL),
(35, 'victorgijon@hotmail.com', '68ed5802061933c3283784d47def16ab2c547825', 'regular', 1, '', 0, 1, 0, '2014-07-08', '93.156.65.51', 'pending_travel_register_form', NULL),
(36, 'potxilari@gmail.com', '7e1498ae7409aed9e851cc8d0e2932075ac3d07e', 'regular', 1, '', 0, 1, 0, '2014-07-13', '31.4.218.23', 'pending_travel_register_form', NULL),
(37, 'marcelaguf@gmail.com', '314779b8d7f1fe970b4b6a7d76a90a1e0a92b3ad', 'regular', 1, '', 0, 1, 0, '2014-07-13', '190.50.4.90', 'register_form', NULL),
(38, 'jose.alfonso2011@gmail.com', '07956657482270fc7bcaa24b0d2221a15bc8657d', 'regular', 1, '', 0, 1, 0, '2014-07-14', '81.202.130.24', 'pending_travel_register_form', NULL),
(39, 'serena.sileoni@brunoleoni.it', '5363d0cd39d7b4580619373d4991409e1fa908d6', 'regular', 1, '', 0, 1, 0, '2014-07-15', '93.44.229.214', 'pending_travel_register_form', NULL),
(40, 'battistelli.gustavo@gmail.com', 'bb7750f21661195026aee99377f3d131844c1031', 'regular', 1, '', 0, 0, 0, '2014-07-19', '181.1.175.130', 'register_form', NULL),
(41, 'bayamones@gmail.com', 'c4b78fb170e8aebe8f097eba7f45cc92fff0fce4', 'regular', 1, '', 0, 1, 0, '2014-07-21', '172.56.41.118', 'register_form', NULL),
(42, 'mercedes.delgado@infomed.sld.cu', '36d47c39f40477ffe85eceaacb1c05926b4cc32a', 'regular', 1, '', 1, 0, 1, '2014-07-27', NULL, 'email', NULL),
(43, 'musiquitor@hotmail.es', '3a365beee6ef6fb168ddcb6921513866bea914c8', 'regular', 1, '', 0, 1, 0, '2014-07-28', '80.38.23.122', 'pending_travel_register_form', NULL),
(44, 'mask141@hotmail.com', '74e4b59b28d4b36e412b4c4fa5d252038549d83f', 'regular', 1, '', 1, 1, 0, '2014-07-29', '200.79.20.137', 'pending_travel_register_form', NULL),
(45, 'olga.vidal@gmail.com', '5179b4d2243a4fe96f5be76af19ec90c9709d863', 'regular', 1, '', 1, 1, 0, '2014-08-05', '213.0.55.164', 'pending_travel_register_form', NULL),
(46, 'trom_10@hotmail.com', 'fff06f52346b197cc0292246ec1bd34dfed925b2', 'regular', 1, '', 1, 1, 0, '2014-08-06', '90.164.112.94', 'pending_travel_register_form', NULL),
(47, 'vadaverrak4@hotmail.com', '409b6f3eba6b37fdd874f9443c2a9d54fdd4d852', 'regular', 1, '', 1, 1, 0, '2014-08-09', '90.174.169.137', 'pending_travel_register_form', NULL),
(48, 'sergio.sierralta@yahoo.com.ar', '04e1ac2e10b73fae1720472c2355c5b5e0f1158f', 'regular', 1, '', 1, 1, 0, '2014-08-12', '186.125.13.235', 'pending_travel_register_form', NULL),
(49, 'ritatour.rita@hotmail.com', '2dec1708e8e5a8ec4373fe4dbbeac210de1396db', 'regular', 1, '', 0, 1, 0, '2014-08-13', '186.53.72.158', 'pending_travel_register_form', NULL),
(50, 'raulgalaxy39@gmail.com', 'f92ed0b049caef0d6a51f82ad3169d18a64dd496', 'regular', 1, '', 0, 1, 0, '2014-08-13', '201.140.191.205', 'pending_travel_register_form', NULL),
(51, 'miriam_cepeda_219@hotmail.com', '74673a938c1f48493dc52ade28fff8d264a3cdac', 'regular', 1, '', 1, 1, 0, '2014-08-20', '200.127.35.155', 'pending_travel_register_form', NULL),
(52, 'premarsl@premarsl.info', '95e4476d2bcfe476086075cb03ceb5a800d97661', 'regular', 1, '', 1, 1, 0, '2014-08-24', '185.9.195.41', 'pending_travel_register_form', NULL),
(53, 'leticia_mclehm@hotmail.com', '36d47c39f40477ffe85eceaacb1c05926b4cc32a', 'regular', 1, '', 1, 0, 1, '2014-08-27', NULL, 'email', NULL),
(54, 'mariauria81@hotmail.com', 'd250aa72cace35ae44de0348d9da2c3a74e819e7', 'regular', 1, '', 1, 1, 0, '2014-08-28', '95.23.6.150', 'pending_travel_register_form', NULL),
(57, 'malejandro_gonzalezp@yahoo.de', '43649792e1da97d8b092ecd0bb83e0d5e79831e1', 'regular', 1, '', 1, 1, 0, '2014-09-02', '78.53.219.40', 'pending_travel_register_form', NULL),
(58, 'oskozarantza@hotmail.com', '4ed3d2a403125ec3eff1416c1bf8595d162a71ce', 'regular', 1, '', 0, 1, 0, '2014-09-03', '193.146.183.193', 'pending_travel_register_form', NULL),
(59, 'yproenza003@gmail.com', '6e112beb5c6a8a609c579516d6fc3e8785a6e0b1', 'admin', 1, '', 0, 0, 0, '2014-09-03', '190.6.66.124', 'add_user_form', NULL),
(60, 'bel-tran2206@hotmail.com', '96b86825b4d770c62ec8f720430e07103bd450b1', 'regular', 1, '', 0, 1, 0, '2014-09-04', '81.45.26.85', 'pending_travel_register_form', NULL),
(61, 'ivonnealcorta@hotmail.com', 'e679f7b330590eba9e920da3c325fd613a518b2d', 'regular', 1, '', 0, 1, 0, '2014-09-04', '80.27.146.37', 'pending_travel_register_form', NULL),
(62, 'dypgispert@hotmail.com', 'f4c7ff94cc91c961f30c58e839467b588dee1b6b', 'regular', 1, '', 0, 1, 0, '2014-09-04', '201.177.12.235', 'pending_travel_register_form', NULL),
(63, 'JUHANAL06@HOTMAIL.COM', 'dbca609005f661fe345680dfc54208a927872057', 'regular', 1, '', 0, 1, 0, '2014-09-05', '88.2.252.44', 'pending_travel_register_form', NULL),
(64, 'emendez@enet.cu', '6b840ae3e8342ba5fd3a2dd5cf57c945cc162df5', 'regular', 1, '', 0, 1, 0, '2014-09-06', '190.15.156.53', 'pending_travel_register_form', NULL),
(65, 'patsl33@yahoo.es', '4ab778e31a488f991268a48946c134b90c012c5b', 'regular', 1, '', 0, 1, 0, '2014-09-06', '88.25.109.69', 'pending_travel_register_form', NULL),
(66, 'franytati2014@gmail.com', 'f0003e78a7736620c92a79473b624ffcbad74b57', 'regular', 1, '', 0, 1, 0, '2014-09-07', '83.60.44.156', 'pending_travel_register_form', NULL),
(67, 'marcelom.mlx@gmail.com', 'a7afa987c211873a8ed38fb8208f8db8e00640a1', 'regular', 1, '', 0, 1, 0, '2014-09-07', '200.127.235.22', 'pending_travel_register_form', NULL),
(68, 'labeyo@hotmail.com', '62560d4a5537ab0a1cfc9f993526ba129af87e85', 'regular', 1, '', 0, 1, 0, '2014-09-08', '46.26.112.13', 'pending_travel_register_form', NULL),
(69, 'claudia.romero@banchile.cl', 'fc4b9185e1e6ae068c06f42b190681f7731d84fa', 'regular', 1, '', 0, 1, 0, '2014-09-09', '200.10.0.2', 'pending_travel_register_form', NULL),
(70, 'alainrod@gmail.com', '2b6c00cd311266dac888a359f72298dbc0300df5', 'admin', 1, '', 0, 0, 0, '2014-09-09', '190.6.66.124', 'add_user_form', NULL),
(71, 'rdiezant@hotmail.com', 'ad7e482a7a8bf0d7c7d6916e7417a19ba1c0bd8a', 'regular', 1, '', 0, 1, 0, '2014-09-17', '80.36.74.181', 'pending_travel_register_form', NULL),
(72, 'sgomezgonzalez@yahoo.com', 'ce4afc8fee659e07a8bb795168db758fc79e76f9', 'regular', 1, '', 0, 1, 0, '2014-09-18', '66.176.30.160', 'pending_travel_register_form', NULL),
(73, 'info@abf.com.ar', 'd1ab98bf31f253119b182ed313b44c41d3c9a845', 'regular', 1, '', 0, 1, 0, '2014-09-19', '186.135.13.17', 'pending_travel_register_form', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_interactions`
--

DROP TABLE IF EXISTS `user_interactions`;
CREATE TABLE IF NOT EXISTS `user_interactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `interaction_code` varchar(250) COLLATE latin1_bin NOT NULL,
  `interaction_due` varchar(250) COLLATE latin1_bin NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `modified` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `user_interactions`
--

INSERT INTO `user_interactions` (`id`, `user_id`, `interaction_code`, `interaction_due`, `expired`, `created`, `modified`) VALUES
(1, 24, 's38bf603cbcd88cc7ea1b8fe2f7f4e59', 'confirm email', 1, '2014-06-01', '2014-06-01'),
(2, 25, 's28e916c483717e71eb9487246651b7f', 'confirm email', 1, '2014-06-02', '2014-06-02'),
(3, 26, 'n6223785b4eea759011b231a9f7bb89f', 'confirm email', 1, '2014-06-02', '2014-06-02'),
(4, 27, 'm3bce8c8f343f847094a76323f96e5b1', 'confirm email', 0, '2014-06-12', '2014-06-12'),
(5, 28, 'q0e393d72405290fd2b589ec0e42e49a', 'confirm email', 0, '2014-06-16', '2014-06-16'),
(6, 30, 'N8440d4b7667d5ac9e0ae29497e349c3', 'confirm email', 0, '2014-06-24', '2014-06-24'),
(7, 31, 'o77a4dd42c59c4b7e7a683fd724ca5e6', 'confirm email', 0, '2014-06-24', '2014-06-24'),
(8, 32, 'W622364829712af31e2ec1f175cf5a25', 'confirm email', 0, '2014-06-24', '2014-06-24'),
(9, 33, 'lbcfc85aa8848cd70f2c3c1a5e8480b6', 'confirm email', 1, '2014-06-25', '2014-06-25'),
(10, 34, 'If88bbd9ed019352b840fd58e79568cb', 'confirm email', 1, '2014-06-26', '2014-06-26'),
(11, 35, 'I349515c8af023bd7fc18f720569f0b7', 'confirm email', 0, '2014-07-08', '2014-07-08'),
(12, 36, 'ze66eaf89170a4026ae7b7d2d990c85d', 'confirm email', 0, '2014-07-13', '2014-07-13'),
(13, 37, 'S576d66d7b45d3e287874450e0c7354f', 'confirm email', 0, '2014-07-13', '2014-07-13'),
(14, 38, 'Mf36256a2649fb827a107bca54c22962', 'confirm email', 0, '2014-07-14', '2014-07-14'),
(15, 39, 'Bc0dbf51828892f119b3592fc7450a63', 'confirm email', 0, '2014-07-15', '2014-07-15'),
(16, 40, 'obc65a884cf710925b90f0c256f64f99', 'confirm email', 0, '2014-07-19', '2014-07-19'),
(17, 41, 'gbbf07ebdcefc05e750d3b617c031771', 'confirm email', 0, '2014-07-21', '2014-07-21'),
(18, 43, 'y39ad77e47320cb063dba72351b5a8d6', 'confirm email', 0, '2014-07-28', '2014-07-28'),
(19, 44, 'lb36ddae6dadc92588a7a17988e8ea5a', 'confirm email', 1, '2014-07-29', '2014-07-29'),
(20, 45, 'j268bc6f25f3889a06600625640c1563', 'confirm email', 1, '2014-08-05', '2014-08-05'),
(21, 46, 'x2fa3379576c9e92d31fdb84a6b5781d', 'confirm email', 1, '2014-08-06', '2014-08-06'),
(22, 47, 'M2448eca86e3e9b15a19efc107194c65', 'confirm email', 1, '2014-08-09', '2014-08-09'),
(23, 47, 't31a98b61676fa85638065f674850a60', 'confirm email', 0, '2014-08-09', '2014-08-09'),
(24, 48, 'q01a7118957c36546a94ad4d46a96f37', 'confirm email', 1, '2014-08-12', '2014-08-12'),
(25, 49, 'x1617afde788d423482d52333b571e89', 'confirm email', 0, '2014-08-13', '2014-08-13'),
(26, 50, 'w66bba0da13d8cffae9599f12784c0b9', 'confirm email', 0, '2014-08-13', '2014-08-13'),
(27, 51, 'r62a752ea2bc7e73fe1dd76ab90e39b4', 'confirm email', 1, '2014-08-20', '2014-08-20'),
(28, 52, 'R82b71ae36a4ad437499da3dcfb6cf4e', 'confirm email', 1, '2014-08-24', '2014-08-24'),
(29, 54, 'A672df7f2a1fefa907f97a2585f0b289', 'confirm email', 1, '2014-08-28', '2014-08-28'),
(32, 57, 'f019926486d458ba1e9d76ae0a05600e', 'confirm email', 1, '2014-09-02', '2014-09-02'),
(33, 58, 'D3a62ebc84c4bca52b14fcca28cbc8ed', 'confirm email', 0, '2014-09-03', '2014-09-03'),
(34, 60, 'p0682762d09dc6caf08f017b3b22a6f5', 'confirm email', 0, '2014-09-04', '2014-09-04'),
(35, 61, 'Iae4a4ddc109f1c215b6c1091cabdda2', 'confirm email', 0, '2014-09-04', '2014-09-04'),
(36, 62, 'W4f0bb946e1475ebd3f3fbdfd3c56851', 'confirm email', 0, '2014-09-04', '2014-09-04'),
(37, 63, 'y041595d205acfe2f5c0d030ba4995dc', 'confirm email', 0, '2014-09-05', '2014-09-05'),
(38, 64, 'S75fe9e437b991d086debaf5d8b2689c', 'confirm email', 0, '2014-09-06', '2014-09-06'),
(39, 65, 'e18bf5b7443e730a3ba49fc11705e614', 'confirm email', 0, '2014-09-06', '2014-09-06'),
(40, 66, 'c993a26186cf17b32e3146d9f2133421', 'confirm email', 0, '2014-09-07', '2014-09-07'),
(41, 67, 'L988e4ab3b924ac587a69e3510ad7a2f', 'confirm email', 0, '2014-09-07', '2014-09-07'),
(42, 68, 'a7c52f0e009f2c115acd0a9116e46762', 'confirm email', 0, '2014-09-08', '2014-09-08'),
(43, 69, 'Ad0ede40f34dcbcd144caa3f83effbff', 'confirm email', 0, '2014-09-09', '2014-09-09'),
(44, 71, 'vb39959755d5c373e7903033bdfc6d77', 'confirm email', 0, '2014-09-17', '2014-09-17'),
(45, 72, 'rd7940de5e8e680ce7b8bf505a536d72', 'confirm email', 0, '2014-09-18', '2014-09-18'),
(46, 73, 'Oeed15201a6c1f71b56473d9b4c73e1c', 'confirm email', 0, '2014-09-19', '2014-09-19');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `drivers_localities`
--
ALTER TABLE `drivers_localities`
  ADD CONSTRAINT `drivers_localities_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `drivers_localities_ibfk_2` FOREIGN KEY (`locality_id`) REFERENCES `localities` (`id`);

--
-- Filtros para la tabla `drivers_travels`
--
ALTER TABLE `drivers_travels`
  ADD CONSTRAINT `drivers_travels_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `drivers_travels_ibfk_2` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`);

--
-- Filtros para la tabla `drivers_travels_by_email`
--
ALTER TABLE `drivers_travels_by_email`
  ADD CONSTRAINT `drivers_travels_by_email_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `drivers_travels_by_email_ibfk_2` FOREIGN KEY (`travel_id`) REFERENCES `travels_by_email` (`id`);

--
-- Filtros para la tabla `localities`
--
ALTER TABLE `localities`
  ADD CONSTRAINT `localities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Filtros para la tabla `localities_thesaurus`
--
ALTER TABLE `localities_thesaurus`
  ADD CONSTRAINT `localities_thesaurus_ibfk_1` FOREIGN KEY (`locality_id`) REFERENCES `localities` (`id`);

--
-- Filtros para la tabla `pending_travels`
--
ALTER TABLE `pending_travels`
  ADD CONSTRAINT `pending_travels_ibfk_1` FOREIGN KEY (`locality_id`) REFERENCES `localities` (`id`);

--
-- Filtros para la tabla `travels`
--
ALTER TABLE `travels`
  ADD CONSTRAINT `travels_ibfk_1` FOREIGN KEY (`locality_id`) REFERENCES `localities` (`id`),
  ADD CONSTRAINT `travels_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
SET FOREIGN_KEY_CHECKS=1;

--
-- Ultimos cambios
--
ALTER TABLE  `drivers` ADD  `speaks_english` BOOLEAN NOT NULL DEFAULT  '0';
ALTER TABLE  `email_queue` ADD  `lang` CHAR( 2 ) NOT NULL DEFAULT  'es' AFTER  `template_vars`;
ALTER TABLE  `users` ADD  `lang` CHAR( 2 ) NOT NULL DEFAULT  'es';


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
