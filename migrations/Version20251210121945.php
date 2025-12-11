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
final class Version20251210121945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adiciona a coluna isSelected na tabela Server';
    }

    public function up(Schema $schema): void
    {
        $this->addSql($this->serverIsSelected());
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TABLE `server` DROP `is_selected`;');
    }

    private function serverIsSelected(): string
    {
        return 'ALTER TABLE `server` ADD `is_selected` BOOLEAN NOT NULL DEFAULT FALSE AFTER `updated_at`;';
    }
}
