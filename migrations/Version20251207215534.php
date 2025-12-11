<?php

declare(strict_types=1);

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207215534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql($this->server());
        $this->addSql($this->result());
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `result`');
        $this->addSql('DROP TABLE `server`');
    }

    private function server(): string
    {
        return 'CREATE TABLE IF NOT EXISTS `speedtest`.`server` (
                    `id` INT NOT NULL,
                    `uuid` BINARY(16) NOT NULL,
                    `host` VARCHAR(255) NULL,
                    `port` INT NULL,
                    `name` VARCHAR(60) NULL,
                    `location` VARCHAR(60) NULL,
                    `country` VARCHAR(60) NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE INDEX `uuid_UNIQUE` (`uuid` ASC))
                ENGINE = InnoDB;'
        ;
    }

    private function result(): string
    {
        return 'CREATE TABLE `speedtest`.`result` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `timestamp` TIMESTAMP NOT NULL,
                    `ping_jitter` DECIMAL(6,3) NULL,
                    `ping_latency` DECIMAL(6,3) NULL,
                    `ping_low` DECIMAL(6,3) NULL,
                    `ping_high` DECIMAL(6,3) NULL,
                    `download_bandwidth` INT NULL,
                    `download_bytes` INT NULL,
                    `download_elapsed` INT NULL,
                    `download_latency_iqm` DECIMAL(6,3) NULL,
                    `download_latency_low` DECIMAL(6,3) NULL,
                    `download_latency_high` DECIMAL(6,3) NULL,
                    `download_latency_jitter` DECIMAL(6,3) NULL,
                    `upload_bandwidth` INT NULL,
                    `upload_bytes` INT NULL,
                    `upload_elapsed` INT NULL,
                    `upload_latency_iqm` DECIMAL(6,3) NULL,
                    `upload_latency_low` DECIMAL(6,3) NULL,
                    `upload_latency_high` DECIMAL(6,3) NULL,
                    `upload_latency_jitter` DECIMAL(6,3) NULL,
                    `packet_loss` INT NULL,
                    `isp` VARCHAR(45) NULL,
                    `interface_internal_ip` VARCHAR(45) NULL,
                    `interface_name` VARCHAR(45) NULL,
                    `interface_mac_addr` VARCHAR(45) NULL,
                    `interface_is_vpn` TINYINT NULL,
                    `interface_external_ip` VARCHAR(60) NULL,
                    `server_id` INT NOT NULL,
                    `server_ip` VARCHAR(60) NULL,
                    `result_id` VARCHAR(36) NULL,
                    `result_url` VARCHAR(255) NULL,
                    `result_persisted` TINYINT NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP NULL,
                    PRIMARY KEY (`id`),
                    INDEX `fk_result_server_idx` (`server_id` ASC),
                    CONSTRAINT `fk_result_server`
                      FOREIGN KEY (`server_id`)
                      REFERENCES `speedtest`.`server` (`id`)
                      ON DELETE NO ACTION
                      ON UPDATE NO ACTION)
                ENGINE = InnoDB;'
        ;
    }
}
