<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204232841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speedtest_server DROP FOREIGN KEY fk_speedtest_server_user1');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configuration_parameter DROP FOREIGN KEY fk_configuration_parameter_user1');
        $this->addSql('ALTER TABLE configuration_parameter DROP FOREIGN KEY fk_configuration_parameter_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE configuration_parameter');
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY fk_speedtest_speedtest_server1');
        $this->addSql('ALTER TABLE speedtest DROP speedtestcol, DROP local_server_id, CHANGE datetime datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE ping_latency ping_latency NUMERIC(10, 3) DEFAULT NULL, CHANGE interface_name interface_name VARCHAR(32) DEFAULT NULL, CHANGE server_ip server_ip VARCHAR(64) NOT NULL, CHANGE result_id result_id VARCHAR(64) NOT NULL');
        $this->addSql('DROP INDEX fk_speedtest_speedtest_server_id ON speedtest');
        $this->addSql('CREATE INDEX IDX_9749F7188F8BB991 ON speedtest (speedtest_server_id)');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT fk_speedtest_speedtest_server1 FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP INDEX fk_speedtest_server_user_id ON speedtest_server');
        $this->addSql('DROP INDEX server_id_UNIQUE ON speedtest_server');
        $this->addSql('ALTER TABLE speedtest_server DROP updated_user_id, CHANGE datetime datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX email_UNIQUE (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE configuration_parameter (id INT AUTO_INCREMENT NOT NULL, created_user_id INT NOT NULL, updated_user_id INT NOT NULL, param_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_enable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX fk_configuration_parameter_user_id_created (created_user_id), INDEX fk_configuration_parameter_user_id_updated (updated_user_id), UNIQUE INDEX param_name_UNIQUE (param_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE configuration_parameter ADD CONSTRAINT fk_configuration_parameter_user1 FOREIGN KEY (updated_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE configuration_parameter ADD CONSTRAINT fk_configuration_parameter_user FOREIGN KEY (created_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE speedtest_server ADD updated_user_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE speedtest_server ADD CONSTRAINT fk_speedtest_server_user1 FOREIGN KEY (updated_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_speedtest_server_user_id ON speedtest_server (updated_user_id)');
        $this->addSql('CREATE UNIQUE INDEX server_id_UNIQUE ON speedtest_server (id)');
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY FK_9749F7188F8BB991');
        $this->addSql('ALTER TABLE speedtest ADD speedtestcol VARCHAR(45) DEFAULT NULL, ADD local_server_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE ping_latency ping_latency VARCHAR(60) DEFAULT NULL, CHANGE interface_name interface_name VARCHAR(8) DEFAULT NULL, CHANGE server_ip server_ip VARCHAR(64) DEFAULT NULL, CHANGE result_id result_id VARCHAR(64) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_9749f7188f8bb991 ON speedtest');
        $this->addSql('CREATE INDEX fk_speedtest_speedtest_server_id ON speedtest (speedtest_server_id)');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT FK_9749F7188F8BB991 FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id)');
    }
}
