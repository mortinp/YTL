ALTER TABLE  `travels_conversations_meta` CHANGE  `conversation_id`  `conversation_id` CHAR( 36 ) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;

ALTER TABLE  `travels_conversations_meta` ADD INDEX  `drivers_travels_meta_fk` (  `conversation_id` );

ALTER TABLE  `travels_conversations_meta` ADD FOREIGN KEY (  `conversation_id` ) REFERENCES  `yotellevo`.`drivers_travels` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;