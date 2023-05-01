<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501181639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speedtest_server ADD updated_user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE speedtest_server ADD CONSTRAINT FK_8A8C2A58BB649746 FOREIGN KEY (updated_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8C2A58BB649746 ON speedtest_server (updated_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speedtest_server DROP FOREIGN KEY FK_8A8C2A58BB649746');
        $this->addSql('DROP INDEX IDX_8A8C2A58BB649746 ON speedtest_server');
        $this->addSql('ALTER TABLE speedtest_server DROP updated_user_id');
    }
}
