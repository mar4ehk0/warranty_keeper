<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218093459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE warranty ADD recognised_description TEXT NOT NULL');
        $this->addSql('ALTER TABLE warranty RENAME COLUMN description TO human_description');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE Warranty ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE Warranty DROP human_description');
        $this->addSql('ALTER TABLE Warranty DROP recognised_description');
    }
}
