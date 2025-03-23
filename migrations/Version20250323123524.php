<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323123524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, propriétaire_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, espece VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, UNIQUE INDEX UNIQ_6AAB231F7E9E4C8C (photo_id), INDEX IDX_6AAB231FF917CCFC (propriétaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, assistant_id INT DEFAULT NULL, veterinaire_id INT DEFAULT NULL, date_creation DATETIME DEFAULT NULL, date_rdv DATETIME DEFAULT NULL, motif VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_65E8AA0A8E962C16 (animal_id), INDEX IDX_65E8AA0AE05387EF (assistant_id), INDEX IDX_65E8AA0A5C80924 (veterinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous_traitement (rendez_vous_id INT NOT NULL, traitement_id INT NOT NULL, INDEX IDX_C4ED2EF91EF7EAA (rendez_vous_id), INDEX IDX_C4ED2EFDDA344B6 (traitement_id), PRIMARY KEY(rendez_vous_id, traitement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, duree INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FF917CCFC FOREIGN KEY (propriétaire_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AE05387EF FOREIGN KEY (assistant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous_traitement ADD CONSTRAINT FK_C4ED2EF91EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous_traitement ADD CONSTRAINT FK_C4ED2EFDDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7E9E4C8C');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FF917CCFC');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8E962C16');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AE05387EF');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5C80924');
        $this->addSql('ALTER TABLE rendez_vous_traitement DROP FOREIGN KEY FK_C4ED2EF91EF7EAA');
        $this->addSql('ALTER TABLE rendez_vous_traitement DROP FOREIGN KEY FK_C4ED2EFDDA344B6');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE rendez_vous_traitement');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('DROP TABLE user');
    }
}
