<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601063049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Activite (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, debut VARCHAR(255) DEFAULT NULL, fin VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_4103374398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Paiement (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, dateNaissance VARCHAR(255) DEFAULT NULL, lieuNaissance VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, contactUrgence VARCHAR(255) DEFAULT NULL, idTransaction VARCHAR(255) DEFAULT NULL, statusPaiement VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, paieTelephone VARCHAR(255) DEFAULT NULL, paieDate VARCHAR(255) DEFAULT NULL, paieTime VARCHAR(255) DEFAULT NULL, INDEX IDX_48AA18487A45358C (groupe_id), INDEX IDX_48AA18489B0F88B1 (activite_id), INDEX IDX_48AA1848C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Participant (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, type_id INT DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, dateNaissance VARCHAR(255) DEFAULT NULL, lieuNaissance VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, contactUrgence VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, paieTelephone VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, INDEX IDX_5103E4C67A45358C (groupe_id), INDEX IDX_5103E4C69B0F88B1 (activite_id), INDEX IDX_5103E4C6C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, doyenne VARCHAR(125) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_31C1548798260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, district_id INT DEFAULT NULL, paroisse VARCHAR(255) NOT NULL, localite VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_4B98C21B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, slug VARCHAR(20) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scout (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, datenaiss VARCHAR(255) NOT NULL, lieunaiss VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, branche VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, contactParent VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, cotisation VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, INDEX IDX_176881647A45358C (groupe_id), INDEX IDX_17688164F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Activite ADD CONSTRAINT FK_4103374398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA18487A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA18489B0F88B1 FOREIGN KEY (activite_id) REFERENCES Activite (id)');
        $this->addSql('ALTER TABLE Paiement ADD CONSTRAINT FK_48AA1848C54C8C93 FOREIGN KEY (type_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C69B0F88B1 FOREIGN KEY (activite_id) REFERENCES Activite (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C6C54C8C93 FOREIGN KEY (type_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C1548798260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE scout ADD CONSTRAINT FK_176881647A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE scout ADD CONSTRAINT FK_17688164F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Paiement DROP FOREIGN KEY FK_48AA18489B0F88B1');
        $this->addSql('ALTER TABLE Participant DROP FOREIGN KEY FK_5103E4C69B0F88B1');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21B08FA272');
        $this->addSql('ALTER TABLE Paiement DROP FOREIGN KEY FK_48AA18487A45358C');
        $this->addSql('ALTER TABLE Participant DROP FOREIGN KEY FK_5103E4C67A45358C');
        $this->addSql('ALTER TABLE scout DROP FOREIGN KEY FK_176881647A45358C');
        $this->addSql('ALTER TABLE Activite DROP FOREIGN KEY FK_4103374398260155');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C1548798260155');
        $this->addSql('ALTER TABLE Paiement DROP FOREIGN KEY FK_48AA1848C54C8C93');
        $this->addSql('ALTER TABLE Participant DROP FOREIGN KEY FK_5103E4C6C54C8C93');
        $this->addSql('ALTER TABLE scout DROP FOREIGN KEY FK_17688164F6203804');
        $this->addSql('DROP TABLE Activite');
        $this->addSql('DROP TABLE Paiement');
        $this->addSql('DROP TABLE Participant');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE scout');
        $this->addSql('DROP TABLE statut');
    }
}
