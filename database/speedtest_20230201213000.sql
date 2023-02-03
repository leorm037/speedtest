-- MySQL Script generated by MySQL Workbench
-- Thu Feb  2 23:06:18 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema speedtest
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema speedtest
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `speedtest` DEFAULT CHARACTER SET utf8mb4 ;
USE `speedtest` ;

-- -----------------------------------------------------
-- Table `speedtest`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `speedtest`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(180) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `roles` LONGTEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `speedtest`.`configuration_parameter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `speedtest`.`configuration_parameter` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `param_name` VARCHAR(255) NOT NULL,
  `param_value` VARCHAR(255) NOT NULL,
  `param_type` VARCHAR(255) NOT NULL,
  `param_enable` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  `created_user_id` INT NOT NULL,
  `updated_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `param_name_UNIQUE` (`param_name` ASC),
  INDEX `fk_configuration_parameter_user_id_created` (`created_user_id` ASC),
  INDEX `fk_configuration_parameter_user_id_updated` (`updated_user_id` ASC),
  CONSTRAINT `fk_configuration_parameter_user`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `speedtest`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_configuration_parameter_user1`
    FOREIGN KEY (`updated_user_id`)
    REFERENCES `speedtest`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `speedtest`.`speedtest_server`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `speedtest`.`speedtest_server` (
  `id` INT NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `host` VARCHAR(60) NOT NULL,
  `port` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `location` VARCHAR(60) NOT NULL,
  `country` VARCHAR(60) NOT NULL,
  `selected` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` VARCHAR(45) NULL,
  `updated_user_id` INT NOT NULL,
  UNIQUE INDEX `server_id_UNIQUE` (`id` ASC),
  INDEX `fk_speedtest_server_user_id` (`updated_user_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_speedtest_server_user1`
    FOREIGN KEY (`updated_user_id`)
    REFERENCES `speedtest`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `speedtest`.`speedtest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `speedtest`.`speedtest` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `speedtest_server_id` INT NOT NULL,
  `datetime` DATETIME NOT NULL,
  `ping_jitter` DECIMAL(20,16) NULL,
  `ping_latency` VARCHAR(60) NULL,
  `download_bandwidth` INT NULL,
  `download_bytes` INT NULL,
  `download_elapsed` INT NULL,
  `upload_bandwidth` INT NULL,
  `upload_bytes` INT NULL,
  `upload_elapsed` INT NULL,
  `packet_loss` INT NULL,
  `isp` VARCHAR(60) NULL,
  `interface_internal_ip` VARCHAR(64) NULL,
  `interface_name` VARCHAR(8) NULL,
  `interface_mac_addr` VARCHAR(32) NULL,
  `interface_is_vpn` TINYINT(1) NULL,
  `interface_external_ip` VARCHAR(64) NULL,
  `server_ip` VARCHAR(64) NULL,
  `result_id` VARCHAR(64) NULL,
  `result_url` VARCHAR(255) NULL,
  `result_persisted` TINYINT(1) NULL,
  `speedtestcol` VARCHAR(45) NULL,
  `local_server_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_speedtest_speedtest_server_id` (`speedtest_server_id` ASC),
  CONSTRAINT `fk_speedtest_speedtest_server1`
    FOREIGN KEY (`speedtest_server_id`)
    REFERENCES `speedtest`.`speedtest_server` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'speedtest' IDENTIFIED BY 'speedtest.68';

GRANT ALL ON `speedtest`.* TO 'speedtest';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;