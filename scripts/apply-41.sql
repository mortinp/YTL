ALTER TABLE  `shared_travels` CHANGE  `verified`  `activated` TINYINT( 1 ) NOT NULL DEFAULT  '0';

ALTER TABLE  `shared_travels` ADD  `coupling_id` BIGINT UNSIGNED NULL AFTER  `lang`;