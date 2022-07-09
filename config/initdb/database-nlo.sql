CREATE DATABASE IF NOT EXISTS `nlo`;

CREATE TABLE IF NOT EXISTS `nlo`.`ticket` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(255) NOT NULL,
  `pos_x` TINYINT(2) NOT NULL,
  `pos_y` TINYINT(2) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_ticket_user` (`user`),
  UNIQUE KEY `uidx_ticket_position` (`pos_x`, `pos_y`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `nlo`.`price` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pos_x` TINYINT(2) NOT NULL,
  `pos_y` TINYINT(2) NOT NULL,
  `price` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_price_position` (`pos_x`, `pos_y`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
