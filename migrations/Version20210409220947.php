<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409220947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43922726E9');
        $this->addSql('DROP INDEX IDX_39986E43922726E9 ON album');
        $this->addSql('ALTER TABLE album DROP cover_id');
        $this->addSql('ALTER TABLE media_object ADD album_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431321137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('CREATE INDEX IDX_14D431321137ABCF ON media_object (album_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album ADD cover_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43922726E9 FOREIGN KEY (cover_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_39986E43922726E9 ON album (cover_id)');
        $this->addSql('ALTER TABLE media_object DROP FOREIGN KEY FK_14D431321137ABCF');
        $this->addSql('DROP INDEX IDX_14D431321137ABCF ON media_object');
        $this->addSql('ALTER TABLE media_object DROP album_id');
    }
}
