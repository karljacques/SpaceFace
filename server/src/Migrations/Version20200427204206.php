<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427204206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ship CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE market CHANGE dockable_id dockable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_commodity CHANGE sell sell INT DEFAULT NULL, CHANGE buy buy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stored_commodity DROP FOREIGN KEY FK_36B319DCAEC82F58');
        $this->addSql('DROP INDEX IDX_36B319DCAEC82F58 ON stored_commodity');
        $this->addSql('ALTER TABLE stored_commodity CHANGE storage_component_id storage_id INT NOT NULL');
        $this->addSql('ALTER TABLE stored_commodity ADD CONSTRAINT FK_36B319DC5CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage (id)');
        $this->addSql('CREATE INDEX IDX_36B319DC5CC5DB90 ON stored_commodity (storage_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE market CHANGE dockable_id dockable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_commodity CHANGE sell sell INT DEFAULT NULL, CHANGE buy buy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ship CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stored_commodity DROP FOREIGN KEY FK_36B319DC5CC5DB90');
        $this->addSql('DROP INDEX IDX_36B319DC5CC5DB90 ON stored_commodity');
        $this->addSql('ALTER TABLE stored_commodity CHANGE storage_id storage_component_id INT NOT NULL');
        $this->addSql('ALTER TABLE stored_commodity ADD CONSTRAINT FK_36B319DCAEC82F58 FOREIGN KEY (storage_component_id) REFERENCES storage (id)');
        $this->addSql('CREATE INDEX IDX_36B319DCAEC82F58 ON stored_commodity (storage_component_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
