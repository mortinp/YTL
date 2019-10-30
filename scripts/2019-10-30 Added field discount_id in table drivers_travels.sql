ALTER TABLE  `drivers_travels` ADD  `discount_id` BIGINT( 20 ) UNSIGNED NULL;

ALTER TABLE  `drivers_travels` 
  ADD INDEX  `discount_conversation_fk` (  `discount_id` );

ALTER TABLE  `drivers_travels` 
  ADD FOREIGN KEY (  `discount_id` ) REFERENCES  `discount_rides` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;