ALTER TABLE `drivers_travels` ADD `entries_count` INT NOT NULL DEFAULT '0';
ALTER TABLE `drivers_travels` CHANGE `entries_count` `driver_traveler_conversation_count` INT( 11 ) NOT NULL DEFAULT '0';