<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529170458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Paiement (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, dateNaissance VARCHAR(255) DEFAULT NULL, lieuNaissance VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, contactUrgence VARCHAR(255) DEFAULT NULL, idTransaction VARCHAR(255) DEFAULT NULL, statusPaiement VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_48AA18487A45358C (groupe_id), INDEX IDX_48AA18489B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA18487A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA18489B0F88B1 FOREIGN KEY (activite_id) REFERENCES Activite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Paiement');
    }
}
