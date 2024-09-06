<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812211931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recognized_text (id UUID NOT NULL, file_id UUID DEFAULT NULL, text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97ECF6793CB796C ON recognized_text (file_id)');
        $this->addSql('COMMENT ON COLUMN recognized_text.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN recognized_text.file_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN recognized_text.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN recognized_text.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recognized_text ADD CONSTRAINT FK_97ECF6793CB796C FOREIGN KEY (file_id) REFERENCES file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recognized_text DROP CONSTRAINT FK_97ECF6793CB796C');
        $this->addSql('DROP TABLE recognized_text');
    }
}
