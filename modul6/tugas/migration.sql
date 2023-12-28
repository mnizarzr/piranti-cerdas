CREATE DATABASE IF NOT EXISTS pirdas;
USE pirdas;

CREATE TABLE IF NOT EXISTS `modul6`  (
  `id` int NOT NULL AUTO_INCREMENT,
  mpu_x decimal(10, 4) NULL,
  mpu_y decimal(10, 4) NULL,
  mpu_z decimal(10, 4) NULL,
  buzzer_status boolean,
  led_status boolean,
  `datetime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
