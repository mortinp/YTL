CREATE TABLE `activity_driver_subscriptions` ( 
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`driver_id` BIGINT UNSIGNED NOT NULL , 
`activity_id` BIGINT UNSIGNED NOT NULL , 
`price` DOUBLE NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
 ) 
ENGINE = InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=1 ;

ALTER TABLE  `activity_driver_subscriptions` 
  ADD INDEX  `activity_driver_subscriptions_fk` (  `driver_id` );

ALTER TABLE  `activity_driver_subscriptions` 
  ADD FOREIGN KEY (  `driver_id` ) REFERENCES  `drivers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;