<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322192124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ship (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, system_id INT NOT NULL, x INT NOT NULL, y INT NOT NULL, INDEX IDX_FA30EB24A76ED395 (user_id), INDEX IDX_FA30EB24D0952FA5 (system_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE star_system (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size_x INT NOT NULL, size_y INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, api_token VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB24D0952FA5 FOREIGN KEY (system_id) REFERENCES star_system (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB24D0952FA5');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB24A76ED395');
        $this->addSql('DROP TABLE ship');
        $this->addSql('DROP TABLE star_system');
        $this->addSql('DROP TABLE user');
    }
}
