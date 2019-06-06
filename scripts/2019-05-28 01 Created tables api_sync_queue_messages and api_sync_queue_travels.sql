CREATE TABLE IF NOT EXISTS `api_sync_queue_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `msg_id` bigint(20) unsigned NOT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `sync_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `api_sync_queue_travels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `travel_id` bigint(20) unsigned NOT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `sync_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;