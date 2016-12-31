-- that script was done using "show create table command"
-- clone drivers_travels
CREATE TABLE IF NOT EXISTS `archive_drivers_travels` (
 `id` char(36) COLLATE latin1_bin NOT NULL,
 `driver_id` bigint(20) unsigned NOT NULL,
 `travel_id` bigint(20) unsigned NOT NULL,
 `notification_type` char(1) COLLATE latin1_bin NOT NULL DEFAULT 'A' COMMENT 'Indicates how the driver was notified: automatically when the request was created, manually by an admin, or any other way',
 `last_driver_email` varchar(250) COLLATE latin1_bin NOT NULL,
 `driver_traveler_conversation_count` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `arch_dri_tra_driver_fk` (`driver_id`),
 KEY `arch_dri_tra_travel_fk` (`travel_id`),
 CONSTRAINT `arch_dri_tra_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
 CONSTRAINT `arch_dri_tra_ibfk_2` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- clone driver_traveler_conversations
CREATE TABLE IF NOT EXISTS `archive_driver_traveler_conversations` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `conversation_id` char(36) NOT NULL,
 `response_by` varchar(20) NOT NULL,
 `response_text` text NOT NULL,
 `attachments_ids` text,
 `created` datetime NOT NULL,
 PRIMARY KEY (`id`),
 KEY `conversation_id` (`conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;

-- clone travels_conversations_meta
CREATE TABLE IF NOT EXISTS `archive_travels_conversations_meta` (
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
 `testimonial_requested` tinyint(1) NOT NULL DEFAULT '0',
 KEY `conversation_id` (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


