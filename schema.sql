
# Register
CREATE TABLE `Register` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `location` varchar(50) NOT NULL,
  `address` char(50) NOT NULL,
  `pass` int(4) NOT NULL,
  `ticket_id` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
)

