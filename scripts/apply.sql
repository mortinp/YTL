ALTER TABLE  `drivers` ADD  `email_active` BOOLEAN NOT NULL DEFAULT  '1';
ALTER TABLE  `email_attachments` CHANGE  `email_queue_id`  `email_queue_id` CHAR( 36 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
