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