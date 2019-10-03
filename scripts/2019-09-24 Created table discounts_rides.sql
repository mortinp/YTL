CREATE TABLE IF NOT EXISTS `discount_rides` ( 
	`id` CHAR(36) NOT NULL , 
	`driver_id` BIGINT(20) UNSIGNED NOT NULL , 
	`origin` VARCHAR(250) NOT NULL , 
	`destination` VARCHAR(250) NOT NULL , 
	`date` DATE NOT NULL , 
	`hour_min` INT(2) NOT NULL , 
	`hour_max` INT(2) NOT NULL , 
	`price` INT(5) NOT NULL , 
	`is_booked` BOOLEAN NOT NULL , 
	`created` DATETIME NOT NULL , 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `discount_rides` ADD FOREIGN KEY (`driver_id`) REFERENCES `drivers`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `discount_rides` ADD `active` BOOLEAN NOT NULL AFTER `created`;

ALTER TABLE `discount_rides` CHANGE `hour_min` `hour_min` INT(2) NOT NULL;

ALTER TABLE `discount_rides` CHANGE `hour_max` `hour_max` INT(2) NOT NULL;

ALTER TABLE `discount_rides` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '1';