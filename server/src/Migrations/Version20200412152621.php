<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412152621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jump_node DROP FOREIGN KEY FK_34CFCFC7A8FCA1E7');
        $this->addSql('DROP INDEX IDX_34CFCFC7A8FCA1E7 ON jump_node');
        $this->addSql('ALTER TABLE jump_node ADD system_id INT NOT NULL, ADD x INT NOT NULL, ADD y INT NOT NULL, DROP entry_system_id, DROP entry_x, DROP entry_y');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7D0952FA5 FOREIGN KEY (system_id) REFERENCES star_system (id)');
        $this->addSql('CREATE INDEX IDX_34CFCFC7D0952FA5 ON jump_node (system_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jump_node DROP FOREIGN KEY FK_34CFCFC7D0952FA5');
        $this->addSql('DROP INDEX IDX_34CFCFC7D0952FA5 ON jump_node');
        $this->addSql('ALTER TABLE jump_node ADD entry_system_id INT NOT NULL, ADD entry_x INT NOT NULL, ADD entry_y INT NOT NULL, DROP system_id, DROP x, DROP y');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7A8FCA1E7 FOREIGN KEY (entry_system_id) REFERENCES star_system (id)');
        $this->addSql('CREATE INDEX IDX_34CFCFC7A8FCA1E7 ON jump_node (entry_system_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
