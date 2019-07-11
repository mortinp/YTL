ALTER TABLE  `driver_traveler_conversations` CHANGE  `conversation_id`  `conversation_id` CHAR( 36 ) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;

ALTER TABLE  `driver_traveler_conversations` ADD FOREIGN KEY (  `conversation_id` ) REFERENCES  `yotellevo`.`drivers_travels` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;



ALTER TABLE  `api_sync_queue_2driver_conversations` CHANGE  `conversation_id`  `conversation_id` CHAR( 36 ) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;

ALTER TABLE  `api_sync_queue_2driver_conversations` ADD INDEX (  `conversation_id` );

ALTER TABLE  `api_sync_queue_2driver_conversations` ADD FOREIGN KEY (  `conversation_id` ) REFERENCES  `yotellevo`.`drivers_travels` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;



ALTER TABLE  `driver_traveler_conversations` CHANGE  `id`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE  `api_sync_queue_2driver_conversations` ADD FOREIGN KEY (  `msg_id` ) REFERENCES  `yotellevo`.`driver_traveler_conversations` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;