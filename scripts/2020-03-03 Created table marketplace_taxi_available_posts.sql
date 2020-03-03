CREATE TABLE IF NOT EXISTS `marketplace_taxi_available_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `origin_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `time_available_start` int(11) NOT NULL,
  `time_available_end` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `max_pax` int(11) NOT NULL,
  `price_x_seat` int(11) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone_number` varchar(20) NOT NULL,
  `created_by` varchar(20) NOT NULL DEFAULT 'organic',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;