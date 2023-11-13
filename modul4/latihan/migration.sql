CREATE DATABASE IF NOT EXISTS piranti_modul4;
USE piranti_modul4;

CREATE TABLE IF NOT EXISTS `data_cahaya`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ldr_value` int NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
