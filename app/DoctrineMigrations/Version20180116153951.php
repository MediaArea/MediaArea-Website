<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180116153951 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bin (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, hash VARCHAR(8) NOT NULL, title VARCHAR(100) NOT NULL, format SMALLINT UNSIGNED DEFAULT 0 NOT NULL, anonymize SMALLINT UNSIGNED DEFAULT 0 NOT NULL, visibility SMALLINT UNSIGNED DEFAULT 0 NOT NULL, expire_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_AA275AEDD1B862B8 (hash), INDEX IDX_AA275AEDA76ED395 (user_id), INDEX visibility_idx (visibility), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bin ADD CONSTRAINT FK_AA275AEDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bin');
    }
}
