ALTER TABLE  `travels` ADD  `original_date` DATE NULL AFTER  `date`;

CREATE TABLE IF NOT EXISTS `x_url_invitations` (
  `id` char(36) NOT NULL,
  `url` text NOT NULL,
  `action_to_allow` varchar(50) NOT NULL,
  `comments` text,
  `allowed_visits_count` int(11) NOT NULL DEFAULT '1',
  `visited_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;