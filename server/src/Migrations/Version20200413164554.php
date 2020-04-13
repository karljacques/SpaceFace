<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200413164554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_937AB034A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commodity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, weight INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage (id INT AUTO_INCREMENT NOT NULL, capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stored_commodity (id INT AUTO_INCREMENT NOT NULL, storage_component_id INT NOT NULL, commodity_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_36B319DCAEC82F58 (storage_component_id), INDEX IDX_36B319DCB4ACC212 (commodity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stored_commodity ADD CONSTRAINT FK_36B319DCAEC82F58 FOREIGN KEY (storage_component_id) REFERENCES storage (id)');
        $this->addSql('ALTER TABLE stored_commodity ADD CONSTRAINT FK_36B319DCB4ACC212 FOREIGN KEY (commodity_id) REFERENCES commodity (id)');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB24A76ED395');
        $this->addSql('DROP INDEX IDX_FA30EB24A76ED395 ON ship');
        $this->addSql('ALTER TABLE ship ADD owner_id INT DEFAULT NULL, CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE user_id storage_component_id INT NOT NULL');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB24AEC82F58 FOREIGN KEY (storage_component_id) REFERENCES storage (id)');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB247E3C61F9 FOREIGN KEY (owner_id) REFERENCES `character` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA30EB24AEC82F58 ON ship (storage_component_id)');
        $this->addSql('CREATE INDEX IDX_FA30EB247E3C61F9 ON ship (owner_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB247E3C61F9');
        $this->addSql('ALTER TABLE stored_commodity DROP FOREIGN KEY FK_36B319DCB4ACC212');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB24AEC82F58');
        $this->addSql('ALTER TABLE stored_commodity DROP FOREIGN KEY FK_36B319DCAEC82F58');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE commodity');
        $this->addSql('DROP TABLE storage');
        $this->addSql('DROP TABLE stored_commodity');
        $this->addSql('DROP INDEX UNIQ_FA30EB24AEC82F58 ON ship');
        $this->addSql('DROP INDEX IDX_FA30EB247E3C61F9 ON ship');
        $this->addSql('ALTER TABLE ship DROP owner_id, CHANGE docked_at_id docked_at_id INT DEFAULT NULL, CHANGE storage_component_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FA30EB24A76ED395 ON ship (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
