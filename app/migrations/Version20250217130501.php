<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217130501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table Warranty';
    }

    public function up(Schema $schema): void
    {
        $query = <<<SQL
        CREATE TABLE Warranty (
            id UUID NOT NULL, name VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            warranty_until TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            PRIMARY KEY(id)
        )
SQL;

        $this->addSql($query);
        $this->addSql('COMMENT ON COLUMN Warranty.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN Warranty.warranty_until IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN Warranty.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN Warranty.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE Warranty');
    }
}
