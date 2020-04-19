<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419185807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE market (id INT AUTO_INCREMENT NOT NULL, dockable_id INT DEFAULT NULL, storage_id INT NOT NULL, INDEX IDX_6BAC85CBE2CE6278 (dockable_id), UNIQUE INDEX UNIQ_6BAC85CB5CC5DB90 (storage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_commodity (id INT AUTO_INCREMENT NOT NULL, market_id INT NOT NULL, commodity_id INT NOT NULL, INDEX IDX_CBDFD4E3622F3F37 (market_id), INDEX IDX_CBDFD4E3B4ACC212 (commodity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CBE2CE6278 FOREIGN KEY (dockable_id) REFERENCES dockable (id)');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CB5CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage (id)');
        $this->addSql('ALTER TABLE market_commodity ADD CONSTRAINT FK_CBDFD4E3622F3F37 FOREIGN KEY (market_id) REFERENCES market (id)');
        $this->addSql('ALTER TABLE market_commodity ADD CONSTRAINT FK_CBDFD4E3B4ACC212 FOREIGN KEY (commodity_id) REFERENCES commodity (id)');
        $this->addSql('ALTER TABLE ship CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE market_commodity DROP FOREIGN KEY FK_CBDFD4E3622F3F37');
        $this->addSql('DROP TABLE market');
        $this->addSql('DROP TABLE market_commodity');
        $this->addSql('ALTER TABLE ship CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
