CREATE TABLE IF NOT EXISTS `drivers_profiles` (
  `id` char(36) COLLATE latin1_bin NOT NULL,
  `driver_id` bigint(20) unsigned NOT NULL,
  `driver_nick` varchar(255) COLLATE latin1_bin NOT NULL,
  `driver_name` varchar(255) COLLATE latin1_bin NOT NULL,
  `description` text COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

ALTER TABLE  `yotellevo`.`drivers_profiles` ADD INDEX  `drivers_profiles_driver_fk` (  `driver_id` );

ALTER TABLE  `drivers_profiles` ADD FOREIGN KEY (  `driver_id` ) REFERENCES  `yotellevo`.`drivers` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;

ALTER TABLE  `yotellevo`.`drivers_profiles` ADD UNIQUE  `drivers_profiles_driver_unique` (  `driver_id` );

ALTER TABLE  `yotellevo`.`drivers_profiles` ADD UNIQUE  `drivers_profiles_driver_nick_unique` (  `driver_nick` );


CREATE TABLE IF NOT EXISTS `drivers_profiles_resources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_profile_id` char(36) COLLATE latin1_bin NOT NULL,
  `filename` varchar(255) COLLATE latin1_bin NOT NULL,
  `filepath` varchar(255) COLLATE latin1_bin NOT NULL,
  `mimetype` varchar(50) COLLATE latin1_bin NOT NULL,
  `intent` varchar(50) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=1 ;

ALTER TABLE  `yotellevo`.`drivers_profiles_resources` ADD INDEX  `drivers_profiles_resources_profile_fk` (  `driver_profile_id` );

ALTER TABLE  `drivers_profiles_resources` ADD FOREIGN KEY (  `driver_profile_id` ) REFERENCES  `yotellevo`.`drivers_profiles` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;


ALTER TABLE  `drivers_profiles_resources` ADD  `relfilepath` VARCHAR( 250 ) NOT NULL AFTER  `filepath`;


ALTER TABLE  `drivers_profiles` ADD  `avatar_filepath` VARCHAR( 250 ) NOT NULL AFTER  `driver_name`;