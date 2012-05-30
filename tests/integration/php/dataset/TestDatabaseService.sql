DROP TABLE IF EXISTS `robots`;
DROP TABLE IF EXISTS `robots_parts`;
DROP TABLE IF EXISTS `parts`;

CREATE TABLE `robots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  `type` varchar(32) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `robots_parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `robots_id` int(10) NOT NULL,
  `parts_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `robots_id` (`robots_id`),
  KEY `parts_id` (`parts_id`)
);

CREATE TABLE `parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `robots` (`name`, `type`, `year`) VALUES ('astroboy', 'mechanical', '1952');
INSERT INTO `robots` (`name`, `type`, `year`) VALUES ('goldorak', 'mechanical', '1976');
INSERT INTO `robots` (`name`, `type`, `year`) VALUES ('Steve Ostin', 'android', '1984');