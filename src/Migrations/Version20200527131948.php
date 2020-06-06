<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527131948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add comments relation to Image and drop Commentary';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commentary');
        $this->addSql('ALTER TABLE comment ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_9474526C3DA5256D ON comment (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, author VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1CAC12CA3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3DA5256D');
        $this->addSql('DROP INDEX IDX_9474526C3DA5256D ON comment');
        $this->addSql('ALTER TABLE comment DROP image_id');
    }
}
