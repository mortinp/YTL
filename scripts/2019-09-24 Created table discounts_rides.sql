CREATE TABLE IF NOT EXISTS `discount_rides` ( 
	`id` CHAR(36) NOT NULL , 
	`driver_id` BIGINT(20) UNSIGNED NOT NULL , 
	`origin` VARCHAR(250) NOT NULL , 
	`destination` VARCHAR(250) NOT NULL , 
	`date` DATE NOT NULL , 
	`hour_min` VARCHAR(10) NOT NULL , 
	`hour_max` VARCHAR(10) NOT NULL , 
	`price` INT(5) NOT NULL , 
	`is_booked` BOOLEAN NOT NULL , 
	`created` DATETIME NOT NULL , 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `discount_rides` ADD FOREIGN KEY (`driver_id`) REFERENCES `drivers`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;