ALTER TABLE `driver_traveler_conversations` ADD `date_read` DATETIME NULL;
ALTER TABLE `drivers_travels` ADD `notified_by` VARCHAR( 250 ) NULL;
ALTER TABLE `drivers_travels` ADD `created` DATETIME NULL;

-- fixing archive

ALTER TABLE `archive_driver_traveler_conversations` ADD `date_read` DATETIME NULL;
ALTER TABLE `archive_drivers_travels` ADD `notified_by` VARCHAR( 250 ) NULL;
ALTER TABLE `archive_drivers_travels` ADD `created` DATETIME NULL;