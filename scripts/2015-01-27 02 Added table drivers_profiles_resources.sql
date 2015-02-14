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