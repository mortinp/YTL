ALTER TABLE  `travels_conversations_meta` ADD  `income` DECIMAL NULL;
ALTER TABLE  `travels_conversations_meta` CHANGE  `income`  `income` DECIMAL( 10, 2 ) NULL DEFAULT NULL;

ALTER TABLE  `travels_conversations_meta` ADD  `income_saving` DECIMAL( 10, 2 ) NULL DEFAULT NULL;

ALTER TABLE `drivers` ADD `min_people_count` INT NOT NULL DEFAULT '1' AFTER `role` ;