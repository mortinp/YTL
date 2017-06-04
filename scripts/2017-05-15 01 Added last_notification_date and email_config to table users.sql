ALTER TABLE `users`   ADD `last_notification_date` DATETIME NULL DEFAULT NULL,
                      ADD `email_config` VARCHAR( 50 ) NULL DEFAULT NULL;