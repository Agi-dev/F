-- commentaire avec des -
## commentaires avec de #

DROP TABLE IF EXISTS `robots`;


CREATE TABLE `robots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  `type` varchar(32) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

-- test insertion
INSERT INTO robots (name, `type`, `year`) VALUES ('Robby the Robot', 'nul' ,'1956');