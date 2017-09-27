--
-- Table structure for table `drivers_transactional_emails`
--

CREATE TABLE IF NOT EXISTS `drivers_transactional_emails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned NOT NULL,
  `transaction_type` tinyint(4) NOT NULL,
  `last_sent` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers_transactional_emails`
--
ALTER TABLE `drivers_transactional_emails`
  ADD CONSTRAINT `drivers_transactional_emails_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);