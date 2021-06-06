<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409222645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP INDEX IDX_39986E43922726E9, ADD UNIQUE INDEX UNIQ_39986E43922726E9 (cover_id)');
        $this->addSql('ALTER TABLE media_object ADD album_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431321137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14D431321137ABCF ON media_object (album_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP INDEX UNIQ_39986E43922726E9, ADD INDEX IDX_39986E43922726E9 (cover_id)');
        $this->addSql('ALTER TABLE media_object DROP FOREIGN KEY FK_14D431321137ABCF');
        $this->addSql('DROP INDEX UNIQ_14D431321137ABCF ON media_object');
        $this->addSql('ALTER TABLE media_object DROP album_id');
    }
}
