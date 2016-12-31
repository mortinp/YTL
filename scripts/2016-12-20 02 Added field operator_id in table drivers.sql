ALTER TABLE  `drivers` ADD  `operator_id` BIGINT UNSIGNED NULL ,
ADD INDEX (  `operator_id` );

ALTER TABLE  `drivers` ADD FOREIGN KEY (  `operator_id` ) REFERENCES  `yotellevo`.`users` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;