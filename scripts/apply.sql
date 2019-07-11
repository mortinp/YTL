ALTER TABLE  `driver_traveler_conversations` CHANGE  `conversation_id`  `conversation_id` CHAR( 36 ) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;

ALTER TABLE  `driver_traveler_conversations` ADD FOREIGN KEY (  `conversation_id` ) REFERENCES  `yotellevo`.`drivers_travels` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;