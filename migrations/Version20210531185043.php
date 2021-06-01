<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531185043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Participant (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, type_id INT DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, dateNaissance VARCHAR(255) DEFAULT NULL, lieuNaissance VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, contactUrgence VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, paieTelephone VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, INDEX IDX_5103E4C67A45358C (groupe_id), INDEX IDX_5103E4C69B0F88B1 (activite_id), INDEX IDX_5103E4C6C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C69B0F88B1 FOREIGN KEY (activite_id) REFERENCES Activite (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C6C54C8C93 FOREIGN KEY (type_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Participant');
    }
}
