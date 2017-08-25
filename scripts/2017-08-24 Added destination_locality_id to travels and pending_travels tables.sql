-- updating travels table
ALTER TABLE `travels` DROP FOREIGN KEY `travels_ibfk_1`;
ALTER TABLE `travels` CHANGE `locality_id` `origin_locality_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `travels` ADD FOREIGN KEY (`origin_locality_id`) REFERENCES `localities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `travels` ADD `destination_locality_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL AFTER `origin_locality_id`;
ALTER TABLE `travels` ADD INDEX ( `destination_locality_id` );
ALTER TABLE `travels` ADD FOREIGN KEY (`destination_locality_id`) REFERENCES `localities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


-- updating pending_travels table
ALTER TABLE `pending_travels` DROP FOREIGN KEY `pending_travels_ibfk_1`;
ALTER TABLE `pending_travels` CHANGE `locality_id` `origin_locality_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `pending_travels` ADD FOREIGN KEY (`origin_locality_id`) REFERENCES `localities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `pending_travels` ADD `destination_locality_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL AFTER `origin_locality_id`;
ALTER TABLE `pending_travels` ADD INDEX ( `destination_locality_id` );
ALTER TABLE `pending_travels` ADD FOREIGN KEY (`destination_locality_id`) REFERENCES `localities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
