
#UserName
CREATE TABLE `UserName` (
  `UserNameID` int(9) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL,
  PRIMARY KEY (`UserNameID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1

# Register
CREATE TABLE `Register` (
  `delar_id` int(11) NOT NULL AUTO_INCREMENT,
  `delar_name` varchar(80) NOT NULL,
  `contact_name` varchar(20) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `phone_mob` bigint(10) NOT NULL,
  `land_phone` varchar(12) NOT NULL,
  PRIMARY KEY (`delar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1

# Ticket_info
CREATE TABLE `Ticket_info` (
  `ticket_id` varchar(50) NOT NULL,
  `ticket_date` date DEFAULT NULL,
  `event_date` date NOT NULL,
  `guest_name` varchar(80) NOT NULL,
  `guest_gender` varchar(10) NOT NULL,
  `delar_id` int(11) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `fk_delar_id` (`delar_id`),
  CONSTRAINT `fk_delar_id` FOREIGN KEY (`delar_id`) REFERENCES `Register` (`delar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1   	

# CheckIn with out foregin key
CREATE TABLE `CheckIn` (
  `checkin_id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_date` date DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  `ticket_id` varchar(50) NOT NULL,
  `delar_id` int(11) NOT NULL,
  PRIMARY KEY (`checkin_id`),
  KEY `fork_delar_id` (`delar_id`),
  CONSTRAINT `fork_delar_id` FOREIGN KEY (`delar_id`) REFERENCES `Register` (`delar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1

