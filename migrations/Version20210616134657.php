<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616134657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thumbnail_object ADD album_id INT NOT NULL');
        $this->addSql('ALTER TABLE thumbnail_object ADD CONSTRAINT FK_ED06B5A1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('CREATE INDEX IDX_ED06B5A1137ABCF ON thumbnail_object (album_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thumbnail_object DROP FOREIGN KEY FK_ED06B5A1137ABCF');
        $this->addSql('DROP INDEX IDX_ED06B5A1137ABCF ON thumbnail_object');
        $this->addSql('ALTER TABLE thumbnail_object DROP album_id');
    }
}
