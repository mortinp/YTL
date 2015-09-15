CREATE TABLE IF NOT EXISTS `travels_conversations_meta` (
  `conversation_id` char(36) NOT NULL,
  `following` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `travels_conversations_meta` ADD `read_entry_count` INT NOT NULL DEFAULT '0';