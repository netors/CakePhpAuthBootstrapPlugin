-- Create syntax for TABLE 'roles'
CREATE TABLE `roles` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'users'
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(2) unsigned NOT NULL DEFAULT '5',
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `lastname` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `username` varchar(45) CHARACTER SET latin1 NOT NULL,
  `password` varchar(45) CHARACTER SET latin1 NOT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_password_hash` varchar(255) DEFAULT NULL,
  `email` varchar(45) CHARACTER SET latin1 NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_roles` (`role_id`),
  CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`,`name`) VALUES (1,'MASTER');
INSERT INTO `roles` (`id`,`name`) VALUES (2,'ADMIN');
INSERT INTO `roles` (`id`,`name`) VALUES (3,'USER');