CREATE TABLE IF NOT EXISTS `casas_find_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `details` text,
  `send_to` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `casas_find_requests` CHANGE  `send_to`  `send_to` VARCHAR( 250 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `casas_find_requests` ADD  `created` DATE NOT NULL;
ALTER TABLE  `casas_find_requests` ADD  `guests_names` TEXT NULL AFTER  `user_id`;
ALTER TABLE  `casas_find_requests` ADD  `user_interaction_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER  `user_id`;

ALTER TABLE  `yotellevo`.`casas_find_requests` ADD INDEX  `casas_find_requests_users_fk` (  `user_id` );
ALTER TABLE  `casas_find_requests` ADD FOREIGN KEY (  `user_id` ) REFERENCES  `yotellevo`.`users` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;


ALTER TABLE  `yotellevo`.`casas_find_requests` ADD INDEX `casas_find_requests_user_interactions_fk` (  `user_interaction_id` );
ALTER TABLE  `casas_find_requests` ADD FOREIGN KEY (  `user_interaction_id` ) REFERENCES  `yotellevo`.`user_interactions` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;