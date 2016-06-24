ALTER TABLE  `travels_conversations_meta` ADD  `asked_confirmation` BOOLEAN NOT NULL DEFAULT  '0',
ADD  `received_confirmation_type` CHAR( 1 ) NULL COMMENT  'Y: yes, the travel was done; N: no, it was not done, K: unknown',
ADD  `received_confirmation_details` TEXT NULL;

ALTER TABLE  `travels_conversations_meta` ADD  `archived` BOOLEAN NULL DEFAULT  '0';