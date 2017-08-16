ALTER TABLE `drivers_travels` CHANGE `travel_id` `travel_id` BIGINT( 20 ) UNSIGNED NULL;
ALTER TABLE `drivers_travels` ADD `travel_date` DATE NULL DEFAULT NULL ,
							  ADD `user_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL ,
						      ADD INDEX ( `user_id` );
ALTER TABLE `drivers_travels` ADD FOREIGN KEY ( `user_id` ) REFERENCES `users` ( `id` ) ON DELETE RESTRICT ON UPDATE RESTRICT;