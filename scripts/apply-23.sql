ALTER TABLE `travels` ADD `operator_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `travels` ADD INDEX ( `operator_id` );
ALTER TABLE `travels` ADD FOREIGN KEY ( `operator_id` ) REFERENCES `yotellevo`.`users` (
`id`
) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `users`   ADD `last_notification_date` DATETIME NULL DEFAULT NULL,
                      ADD `email_config` VARCHAR( 50 ) NULL DEFAULT NULL;