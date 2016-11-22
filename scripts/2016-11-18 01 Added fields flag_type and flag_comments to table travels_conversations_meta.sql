ALTER TABLE  `travels_conversations_meta` ADD  `flag_type` CHAR( 1 ) NULL AFTER  `following` ,
ADD  `flag_comment` TEXT NULL AFTER  `flag_type`;