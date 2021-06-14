<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210613153431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE thumbnail_object (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, track_id VARCHAR(255) NOT NULL, file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_ED06B5A1137ABCF (album_id), INDEX IDX_ED06B5A5ED23C43 (track_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE thumbnail_object ADD CONSTRAINT FK_ED06B5A1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE thumbnail_object ADD CONSTRAINT FK_ED06B5A5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id)');
        $this->addSql('ALTER TABLE track ADD thumbnail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES thumbnail_object (id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6FDFF2E92 ON track (thumbnail_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A6FDFF2E92');
        $this->addSql('DROP TABLE thumbnail_object');
        $this->addSql('DROP INDEX IDX_D6E3F8A6FDFF2E92 ON track');
        $this->addSql('ALTER TABLE track DROP thumbnail_id');
    }
}
