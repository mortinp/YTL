ALTER TABLE `drivers_travels` DROP `sent`;
ALTER TABLE  `drivers_travels` ADD  `notification_type` CHAR( 1 ) NOT NULL DEFAULT  'A' AFTER  `travel_id`;