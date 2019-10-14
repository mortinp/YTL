CREATE TABLE IF NOT EXISTS `discount_rides` (
  `id` char(36) NOT NULL,
  `driver_id` bigint(20) unsigned NOT NULL,
  `origin` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `hour_min` int(2) NOT NULL,
  `hour_max` int(2) NOT NULL,
  `price` int(5) NOT NULL,
  `is_booked` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `discount_rides`
  ADD CONSTRAINT `discount_rides_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;