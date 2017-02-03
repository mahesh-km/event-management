
# Register
CREATE TABLE `Register` (
  `delar_id` int(11) NOT NULL AUTO_INCREMENT,
  `delar_name` varchar(20) NOT NULL,
  `contact_name` varchar(20),
  `salesman_name` varchar(20),  	 
  `email` varchar(80) NOT NULL,
  `address` char(50) NOT NULL,
  `phone_mob` int(10) NOT NULL,
  `land_phone` int(12),
  `delar_dist` char(50) NOT NULL,
  `pass` int(4) NOT NULL,
  `ticket_id` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`delar_id`),
  UNIQUE KEY `email` (`email`)
);

