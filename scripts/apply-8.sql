ALTER TABLE  `driver_traveler_conversations` ADD  `attachments_ids` TEXT NULL AFTER  `response_text`;

ALTER TABLE  `email_attachments` ADD  `relfilepath` VARCHAR( 255 ) NULL AFTER  `filepath`;