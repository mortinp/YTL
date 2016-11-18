ALTER TABLE  `drivers` ADD  `province_id` BIGINT UNSIGNED NOT NULL DEFAULT  '5' AFTER  `has_air_conditioner`;

ALTER TABLE  `yotellevo`.`drivers` ADD INDEX  `drivers_province_fk` (  `province_id` );

ALTER TABLE  `drivers` ADD FOREIGN KEY (  `province_id` ) REFERENCES  `yotellevo`.`provinces` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;