<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525140230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add Comment table and relation to Album';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, posted_at DATETIME NOT NULL, INDEX IDX_9474526C1137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
       
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comment');
       
    }
}
