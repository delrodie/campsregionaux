<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531164923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Paiement ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA1848C54C8C93 FOREIGN KEY (type_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_48AA1848C54C8C93 ON Paiement (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Paiement DROP FOREIGN KEY FK_48AA1848C54C8C93');
        $this->addSql('DROP INDEX IDX_48AA1848C54C8C93 ON Paiement');
        $this->addSql('ALTER TABLE Paiement DROP type_id');
    }
}
