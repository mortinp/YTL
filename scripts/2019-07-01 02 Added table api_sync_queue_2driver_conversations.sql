CREATE TABLE IF NOT EXISTS `api_sync_queue_2driver_conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) NOT NULL,
  `msg_id` bigint(20) unsigned DEFAULT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `sync_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;