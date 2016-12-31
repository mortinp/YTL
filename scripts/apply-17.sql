START TRANSACTION;


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


ALTER TABLE `drivers` DROP `travel_by_email_count`;


ALTER TABLE  `drivers` ADD  `operator_id` BIGINT UNSIGNED NULL ,
ADD INDEX (  `operator_id` );

ALTER TABLE  `drivers` ADD FOREIGN KEY (  `operator_id` ) REFERENCES  `yotellevo`.`users` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;


ALTER TABLE `driver_traveler_conversations` ADD `read_by` VARCHAR( 250 ) NULL DEFAULT NULL; 
ALTER TABLE `archive_driver_traveler_conversations` ADD `read_by` VARCHAR( 250 ) NULL DEFAULT NULL;


ALTER TABLE `travels` ADD `archive_conversations_count` INT NOT NULL DEFAULT '0';


CREATE TABLE IF NOT EXISTS `op_actions_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_owner` bigint(20) unsigned NOT NULL,
  `op_other` bigint(20) unsigned NOT NULL,
  `action_allowed` char(1) NOT NULL,
  `allowed_by_owner` tinyint(1) NOT NULL DEFAULT '0',
  `accepted_by_other` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `op_action_rule_unique` (`op_owner`,`op_other`,`action_allowed`),
  KEY `op_owner_user_fk` (`op_owner`),
  KEY `op_other_user_fk` (`op_other`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

ALTER TABLE `op_actions_rules`
  ADD CONSTRAINT `op_actions_rules_ibfk_1` FOREIGN KEY (`op_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `op_actions_rules_ibfk_2` FOREIGN KEY (`op_other`) REFERENCES `users` (`id`);
  

ALTER TABLE `driver_traveler_conversations` ADD INDEX ( `conversation_id` ) ;


COMMIT;