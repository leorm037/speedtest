<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241019233707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speedtest (id INT AUTO_INCREMENT NOT NULL, speedtest_server_id INT DEFAULT NULL, datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ping_jitter NUMERIC(20, 16) DEFAULT NULL, ping_latency NUMERIC(10, 3) DEFAULT NULL, download_bandwidth INT DEFAULT NULL, download_bytes INT DEFAULT NULL, download_elapsed INT DEFAULT NULL, upload_bandwidth INT DEFAULT NULL, upload_bytes INT DEFAULT NULL, upload_elapsed INT DEFAULT NULL, isp VARCHAR(60) DEFAULT NULL, interface_internal_ip VARCHAR(64) DEFAULT NULL, interface_name VARCHAR(32) DEFAULT NULL, interface_mac_addr VARCHAR(32) DEFAULT NULL, interface_is_vpn TINYINT(1) DEFAULT NULL, interface_external_ip VARCHAR(64) DEFAULT NULL, server_ip VARCHAR(64) NOT NULL, result_id VARCHAR(64) NOT NULL, result_url VARCHAR(255) DEFAULT NULL, result_persisted TINYINT(1) DEFAULT NULL, packet_loss NUMERIC(20, 2) DEFAULT NULL, INDEX IDX_9749F7188F8BB991 (speedtest_server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT FK_9749F7188F8BB991 FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id)');
        $this->addSql('DROP INDEX server_id_UNIQUE ON speedtest_server');
        $this->addSql('ALTER TABLE speedtest_server CHANGE datetime datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE updated_user_id updated_user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE speedtest_server ADD CONSTRAINT FK_8A8C2A58BB649746 FOREIGN KEY (updated_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE speedtest_server RENAME INDEX fk_speedtest_server_user_id TO IDX_8A8C2A58BB649746');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speedtest_server DROP FOREIGN KEY FK_8A8C2A58BB649746');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY FK_9749F7188F8BB991');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE speedtest');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE speedtest_server CHANGE updated_user_id updated_user_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at VARCHAR(45) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX server_id_UNIQUE ON speedtest_server (id)');
        $this->addSql('ALTER TABLE speedtest_server RENAME INDEX idx_8a8c2a58bb649746 TO fk_speedtest_server_user_id');
    }
}
