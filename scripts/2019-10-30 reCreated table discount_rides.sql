DROP TABLE  IF EXISTS `discount_rides`;

CREATE TABLE `discount_rides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  `people_count` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour_min` int(2) NOT NULL,
  `hour_max` int(2) NOT NULL,
  `price` int(5) NOT NULL,
  `is_booked` tinyint(1) NOT NULL,
  `created` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=1 ;

ALTER TABLE  `discount_rides` 
  ADD INDEX  `drivers_discount_rides_fk` (  `driver_id` );

ALTER TABLE  `discount_rides` 
  ADD FOREIGN KEY (  `driver_id` ) REFERENCES  `drivers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;