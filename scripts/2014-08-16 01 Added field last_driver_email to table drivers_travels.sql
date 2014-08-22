ALTER TABLE  `drivers_travels` ADD  `last_driver_email` VARCHAR( 250 ) NOT NULL;

UPDATE drivers_travels SET last_driver_email = ( SELECT username
FROM drivers
WHERE id = driver_id )