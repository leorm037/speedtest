<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426155125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE configuration_parameter DROP FOREIGN KEY fk_configuration_parameter_user');
        $this->addSql('ALTER TABLE configuration_parameter DROP FOREIGN KEY fk_configuration_parameter_user1');
        $this->addSql('DROP TABLE configuration_parameter');
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY fk_speedtest_speedtest_server_id');
        $this->addSql('ALTER TABLE speedtest CHANGE speedtest_server_id speedtest_server_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE interface_name interface_name VARCHAR(32) DEFAULT NULL, CHANGE server_ip server_ip VARCHAR(64) NOT NULL, CHANGE result_id result_id VARCHAR(64) NOT NULL');
        $this->addSql('DROP INDEX fk_speedtest_speedtest_server_id ON speedtest');
        $this->addSql('CREATE INDEX IDX_9749F7188F8BB991 ON speedtest (speedtest_server_id)');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT fk_speedtest_speedtest_server_id FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE speedtest_server DROP FOREIGN KEY fk_speedtest_server_user1');
        $this->addSql('DROP INDEX server_id_UNIQUE ON speedtest_server');
        $this->addSql('DROP INDEX fk_speedtest_server_user_id ON speedtest_server');
        $this->addSql('ALTER TABLE speedtest_server DROP updated_user_id, CHANGE datetime datetime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, ADD name VARCHAR(60) NOT NULL, DROP created_at, DROP updated_at, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('DROP INDEX email_unique ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuration_parameter (id INT AUTO_INCREMENT NOT NULL, created_user_id INT NOT NULL, updated_user_id INT NOT NULL, param_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, param_enable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX param_name_UNIQUE (param_name), INDEX fk_configuration_parameter_user_id_created (created_user_id), INDEX fk_configuration_parameter_user_id_updated (updated_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE configuration_parameter ADD CONSTRAINT fk_configuration_parameter_user FOREIGN KEY (created_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE configuration_parameter ADD CONSTRAINT fk_configuration_parameter_user1 FOREIGN KEY (updated_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP is_verified, DROP name, CHANGE roles roles LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX uniq_8d93d649e7927c74 ON user');
        $this->addSql('CREATE UNIQUE INDEX email_UNIQUE ON user (email)');
        $this->addSql('ALTER TABLE speedtest_server ADD updated_user_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE speedtest_server ADD CONSTRAINT fk_speedtest_server_user1 FOREIGN KEY (updated_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX server_id_UNIQUE ON speedtest_server (id)');
        $this->addSql('CREATE INDEX fk_speedtest_server_user_id ON speedtest_server (updated_user_id)');
        $this->addSql('ALTER TABLE speedtest DROP FOREIGN KEY FK_9749F7188F8BB991');
        $this->addSql('ALTER TABLE speedtest CHANGE speedtest_server_id speedtest_server_id INT NOT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE interface_name interface_name VARCHAR(8) DEFAULT NULL, CHANGE server_ip server_ip VARCHAR(64) DEFAULT NULL, CHANGE result_id result_id VARCHAR(64) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_9749f7188f8bb991 ON speedtest');
        $this->addSql('CREATE INDEX fk_speedtest_speedtest_server_id ON speedtest (speedtest_server_id)');
        $this->addSql('ALTER TABLE speedtest ADD CONSTRAINT FK_9749F7188F8BB991 FOREIGN KEY (speedtest_server_id) REFERENCES speedtest_server (id)');
    }
}
