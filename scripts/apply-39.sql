CREATE TABLE IF NOT EXISTS `shared_travels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` varchar(250) NOT NULL,
  `activation_token` varchar(250) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `modality_code` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  `people_count` int(11) NOT NULL,
  `address_origin` text NOT NULL,
  `address_destination` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `name_id` varchar(250) NOT NULL,
  `contacts` varchar(250) DEFAULT NULL,
  `state` char(1) NOT NULL DEFAULT 'P',
  `lang` char(2) NOT NULL DEFAULT 'es',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;