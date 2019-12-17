<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217160917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_957A6479D0494586 ON fos_user');
        $this->addSql('DROP INDEX idx_user_identifier ON fos_user');
        $this->addSql('ALTER TABLE fos_user CHANGE user_identifier _uid VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A64791EF01FFC ON fos_user (_uid)');
        $this->addSql('CREATE INDEX idx_user_identifier ON fos_user (_uid)');
        $this->addSql('ALTER TABLE ingredient ADD _uid VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BAF78701EF01FFC ON ingredient (_uid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_957A64791EF01FFC ON fos_user');
        $this->addSql('DROP INDEX idx_user_identifier ON fos_user');
        $this->addSql('ALTER TABLE fos_user CHANGE _uid user_identifier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479D0494586 ON fos_user (user_identifier)');
        $this->addSql('CREATE INDEX idx_user_identifier ON fos_user (user_identifier)');
        $this->addSql('DROP INDEX UNIQ_6BAF78701EF01FFC ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP _uid');
    }
}
