CREATE TABLE `yotellevo`.`activity_driver_subscriptions` ( `driver_id` BIGINT UNSIGNED NOT NULL , `activity_id` BIGINT UNSIGNED NOT NULL , `price` DOUBLE NOT NULL ) ENGINE = InnoDB;

ALTER TABLE `activity_driver_subscriptions` ADD `id` SERIAL NOT NULL FIRST, ADD PRIMARY KEY (`id`);