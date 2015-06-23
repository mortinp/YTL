ALTER TABLE  `drivers_profiles` CHANGE  `description`  `description_es` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `drivers_profiles` ADD  `description_en` TEXT NOT NULL;
ALTER TABLE  `drivers_profiles` ADD  `show_profile` BOOLEAN NOT NULL DEFAULT  '0';