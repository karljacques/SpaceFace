<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322195044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jump_node (id INT AUTO_INCREMENT NOT NULL, entry_system_id INT NOT NULL, exit_node_id INT NOT NULL, entry_x INT NOT NULL, entry_y INT NOT NULL, exit_x INT NOT NULL, exit_y INT NOT NULL, INDEX IDX_34CFCFC7A8FCA1E7 (entry_system_id), INDEX IDX_34CFCFC7581F7261 (exit_node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7A8FCA1E7 FOREIGN KEY (entry_system_id) REFERENCES star_system (id)');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7581F7261 FOREIGN KEY (exit_node_id) REFERENCES star_system (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE jump_node');
    }
}
