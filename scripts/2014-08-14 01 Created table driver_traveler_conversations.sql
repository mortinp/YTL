CREATE TABLE IF NOT EXISTS `driver_traveler_conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) NOT NULL,
  `response_by` varchar(20) NOT NULL,
  `response_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;