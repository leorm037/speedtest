<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208231708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speedtest (id INT AUTO_INCREMENT NOT NULL, speedtest_server_id INT DEFAULT NULL, datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ping_jitter NUMERIC(20, 16) DEFAULT NULL, ping_latency NUMERIC(10, 3) DEFAULT NULL, download_bandwidth INT DEFAULT NULL, download_bytes INT DEFAULT NULL, download_elapsed INT DEFAULT NULL, upload_bandwidth INT DEFAULT NULL, upload_bytes INT DEFAULT NULL, upload_elapsed INT DEFAULT NULL, packet_loss INT DEFAULT NULL, isp VARCHAR(60) DEFAULT NULL, interface_internal_ip VARCHAR(64) DEFAULT NULL, interface_name VARCHAR(32) DEFAULT NULL, interface_mac_addr VARCHAR(32) DEFAULT NULL, interface_is_vpn TINYINT(1) DEFAULT NULL, interface_external_ip VARCHAR(64) DEFAULT NULL, server_ip VARCHAR(64) NOT NULL, result_id VARCHAR(64) NOT NULL, result_url VARCHAR(255) DEFAULT NULL, result_persisted TINYINT(1) DEFAULT NULL, INDEX IDX_9749F7188F8BB991 (speedtest_server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speedtest_server (id INT NOT NULL, datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', host VARCHAR(60) NOT NULL, port INT NOT NULL, location VARCHAR(60) NOT NULL, name VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, selected TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT FK_9749F7188F8BB991 FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY FK_9749F7188F8BB991');
        $this->addSql('DROP TABLE speedtest');
        $this->addSql('DROP TABLE speedtest_server');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
