<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217133126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE warranty ADD receipt_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN warranty.receipt_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE warranty ADD CONSTRAINT FK_71A17EA42B5CA896 FOREIGN KEY (receipt_id) REFERENCES Receipt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71A17EA42B5CA896 ON warranty (receipt_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Warranty DROP CONSTRAINT FK_71A17EA42B5CA896');
        $this->addSql('DROP INDEX UNIQ_71A17EA42B5CA896');
        $this->addSql('ALTER TABLE Warranty DROP receipt_id');
    }
}
