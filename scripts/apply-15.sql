begin;

/* ----------- making Testimonials table ----------- */
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` char(36) COLLATE latin1_bin NOT NULL,
  `author` varchar(1000) COLLATE latin1_bin NOT NULL,
  `text` TEXT NOT NULL,
  `state` set('P','A','R') COLLATE latin1_bin NOT NULL DEFAULT 'P',
  `lang` char(2) COLLATE latin1_bin NOT NULL DEFAULT 'es',
  `image_filepath` varchar(250) COLLATE latin1_bin NOT NULL,
  `conversation_id` char(36) COLLATE latin1_bin DEFAULT NULL,
  `driver_id` bigint(20) unsigned NOT NULL,
  `email` varchar(200) COLLATE latin1_bin DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,  
  PRIMARY KEY (`id`),
  KEY `driver_travel_id_fk` (`conversation_id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `drivers_travels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `testimonials_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);


  
/* ----------- adding data to DriversProfiles  ----------- */
ALTER TABLE `drivers_profiles` ADD `driver_code` VARCHAR( 10 ) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL ,
                               ADD `testimonial_attempts` INT NOT NULL DEFAULT '0';

							   
							   
/* ----------- adding data to TravelsConversationsMeta  ----------- */
ALTER TABLE `travels_conversations_meta` ADD `testimonial_requested` BOOLEAN NOT NULL DEFAULT '0';

commit;