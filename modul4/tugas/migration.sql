CREATE DATABASE IF NOT EXISTS piranti_modul4;
USE piranti_modul4;

CREATE TABLE IF NOT EXISTS `mpus`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `x` int NULL,
  `y` int NULL,
  `z` int NULL,
  `tilt` ENUM('top', 'bottom', 'left', 'right') NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
