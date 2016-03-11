ALTER TABLE  `user_interactions` ADD  `sent` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `context_values` ,
ADD  `displayed` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `sent` ,
ADD  `visited` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `displayed`;