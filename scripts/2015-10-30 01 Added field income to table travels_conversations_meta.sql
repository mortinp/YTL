ALTER TABLE  `travels_conversations_meta` ADD  `income` DECIMAL NULL;
ALTER TABLE  `travels_conversations_meta` CHANGE  `income`  `income` DECIMAL( 10, 2 ) NULL DEFAULT NULL;