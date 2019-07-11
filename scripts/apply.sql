ALTER TABLE  `driver_traveler_conversations` CHANGE  `id`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE  `api_sync_queue_2driver_conversations` ADD FOREIGN KEY (  `msg_id` ) REFERENCES  `yotellevo`.`driver_traveler_conversations` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;