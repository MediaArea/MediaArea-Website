<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180315094939 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE guest_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_4AC9362FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_quotas_default (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, policies INT NOT NULL, uploads INT NOT NULL, urls INT NOT NULL, policy_checks INT NOT NULL, UNIQUE INDEX UNIQ_7B8747A7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_key (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(64) NOT NULL, app VARCHAR(32) DEFAULT NULL, version VARCHAR(16) DEFAULT NULL, ip VARCHAR(48) DEFAULT NULL, UNIQUE INDEX UNIQ_C912ED9D5F37A13B (token), INDEX IDX_C912ED9DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, value TEXT DEFAULT NULL, INDEX IDX_E545A0C5A76ED395 (user_id), UNIQUE INDEX UNIQ_E545A0C5A76ED3955E237E06 (user_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_quotas (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, policies INT NOT NULL, uploads INT NOT NULL, uploads_timestamp DATETIME NOT NULL, urls INT NOT NULL, urls_timestamp DATETIME NOT NULL, policy_checks INT NOT NULL, policy_checks_timestamp DATETIME NOT NULL, UNIQUE INDEX UNIQ_8H1679F4B67BF763 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE display_file (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, display_name VARCHAR(50) NOT NULL, display_filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7F5DB51A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guest_token ADD CONSTRAINT FK_4AC9362FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_quotas_default ADD CONSTRAINT FK_7B8747A7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE api_key ADD CONSTRAINT FK_C912ED9DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_quotas ADD CONSTRAINT FK_A08B56FCA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE display_file ADD CONSTRAINT FK_7F5DB51A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE guest_token');
        $this->addSql('DROP TABLE user_quotas_default');
        $this->addSql('DROP TABLE api_key');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE user_quotas');
        $this->addSql('DROP TABLE display_file');
    }
}
