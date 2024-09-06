<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803143531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yandex_iam_token (id UUID NOT NULL, value VARCHAR(300) NOT NULL, expired TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_424D21681D775834 ON yandex_iam_token (value)');
        $this->addSql('COMMENT ON COLUMN yandex_iam_token.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN yandex_iam_token.expired IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN yandex_iam_token.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN yandex_iam_token.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE yandex_iam_token');
    }
}
