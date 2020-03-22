<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322200005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jump_node DROP FOREIGN KEY FK_34CFCFC7581F7261');
        $this->addSql('DROP INDEX IDX_34CFCFC7581F7261 ON jump_node');
        $this->addSql('ALTER TABLE jump_node CHANGE exit_node_id exit_system_id INT NOT NULL');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7BCB1A64C FOREIGN KEY (exit_system_id) REFERENCES star_system (id)');
        $this->addSql('CREATE INDEX IDX_34CFCFC7BCB1A64C ON jump_node (exit_system_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jump_node DROP FOREIGN KEY FK_34CFCFC7BCB1A64C');
        $this->addSql('DROP INDEX IDX_34CFCFC7BCB1A64C ON jump_node');
        $this->addSql('ALTER TABLE jump_node CHANGE exit_system_id exit_node_id INT NOT NULL');
        $this->addSql('ALTER TABLE jump_node ADD CONSTRAINT FK_34CFCFC7581F7261 FOREIGN KEY (exit_node_id) REFERENCES star_system (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_34CFCFC7581F7261 ON jump_node (exit_node_id)');
    }
}
