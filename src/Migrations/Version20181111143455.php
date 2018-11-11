<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181111143455 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD api_token VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD people_id INT NOT NULL, ADD login VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username, DROP roles');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493147C936 FOREIGN KEY (people_id) REFERENCES people (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493147C936 ON user (people_id)');
    }
}
