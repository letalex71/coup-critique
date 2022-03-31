<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501050431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, tier_id INT NOT NULL, name VARCHAR(5000) NOT NULL, explanations VARCHAR(10000) DEFAULT NULL, validated VARCHAR(2) NOT NULL, INDEX IDX_C4E0A61FF675F31B (author_id), INDEX IDX_C4E0A61FA354F9DC (tier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tier (id INT AUTO_INCREMENT NOT NULL, generation VARCHAR(2) NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FA354F9DC FOREIGN KEY (tier_id) REFERENCES tier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FA354F9DC');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE tier');
    }
}
