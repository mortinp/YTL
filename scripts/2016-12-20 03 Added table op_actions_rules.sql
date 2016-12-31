CREATE TABLE IF NOT EXISTS `op_actions_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_owner` bigint(20) unsigned NOT NULL,
  `op_other` bigint(20) unsigned NOT NULL,
  `action_allowed` char(1) NOT NULL,
  `allowed_by_owner` tinyint(1) NOT NULL DEFAULT '0',
  `accepted_by_other` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `op_action_rule_unique` (`op_owner`,`op_other`,`action_allowed`),
  KEY `op_owner_user_fk` (`op_owner`),
  KEY `op_other_user_fk` (`op_other`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

ALTER TABLE `op_actions_rules`
  ADD CONSTRAINT `op_actions_rules_ibfk_1` FOREIGN KEY (`op_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `op_actions_rules_ibfk_2` FOREIGN KEY (`op_other`) REFERENCES `users` (`id`);