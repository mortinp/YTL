CREATE TABLE IF NOT EXISTS `testimonials_replies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `testimonial_id` CHAR(36) NOT NULL ,
  `reply_text` TEXT NOT NULL ,
  `reply_by` SET('driver','traveler') NOT NULL ,
  `state` SET('P','A','R') NOT NULL DEFAULT 'P' ,
  `created` DATETIME NOT NULL ,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
 ) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
ALTER TABLE `testimonials` ADD `driver_reply_token` VARCHAR(32) NULL DEFAULT NULL AFTER `validation_token`; 
