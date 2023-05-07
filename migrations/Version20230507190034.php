<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507190034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, date VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, medecin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, capacite INT NOT NULL, local VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, prix VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_B26681EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, date_naissance DATE DEFAULT NULL, tel INT DEFAULT NULL, etat_clinique VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, type_assurance VARCHAR(255) DEFAULT NULL, INDEX IDX_4C13CC7887F4FB17 (doctor_id), INDEX IDX_4C13CC786B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_AC6340B371F7E88B (event_id), INDEX IDX_AC6340B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE med (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, nb_dose INT NOT NULL, prix INT NOT NULL, stock INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament_pharmacie (medicament_id INT NOT NULL, pharmacie_id INT NOT NULL, INDEX IDX_804E4447AB0D61F7 (medicament_id), INDEX IDX_804E4447BC6D351B (pharmacie_id), PRIMARY KEY(medicament_id, pharmacie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, reservations_id INT DEFAULT NULL, nom_medecin VARCHAR(255) DEFAULT NULL, nom_patient VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_924B326C87F4FB17 (doctor_id), INDEX IDX_924B326C6B899279 (patient_id), UNIQUE INDEX UNIQ_924B326CD9A7F869 (reservations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance_medicament (id INT AUTO_INCREMENT NOT NULL, ordonnance_id INT DEFAULT NULL, medicament_id INT DEFAULT NULL, dosage INT DEFAULT NULL, duration INT DEFAULT NULL, INDEX IDX_FE7DFAEE2BF23B8F (ordonnance_id), INDEX IDX_FE7DFAEEAB0D61F7 (medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pan (id INT AUTO_INCREMENT NOT NULL, totalprix VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, idu_id INT DEFAULT NULL, datecreation DATETIME NOT NULL, UNIQUE INDEX UNIQ_24CC0DF2376A6230 (idu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_item (id INT AUTO_INCREMENT NOT NULL, medicament_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, quantite INT DEFAULT NULL, totale INT DEFAULT NULL, INDEX IDX_EBFD0067AB0D61F7 (medicament_id), INDEX IDX_EBFD0067F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panierx (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_medica_id INT NOT NULL, qte INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_DF4B49BE79F37AE5 (id_user_id), INDEX IDX_DF4B49BEC711D718 (id_medica_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, event_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AB55E24F9D86650F (user_id_id), INDEX IDX_AB55E24F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pharmacie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tempo TIME NOT NULL, tempf TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, med_id INT DEFAULT NULL, make_rate_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, opinion VARCHAR(255) DEFAULT NULL, INDEX IDX_DFEC3F39793E396C (med_id), UNIQUE INDEX UNIQ_DFEC3F39CE727896 (make_rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, fiche_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_42C8495567B3B43D (users_id), INDEX IDX_42C849556B899279 (patient_id), INDEX IDX_42C84955DF522508 (fiche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, speciality_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, licence_numero VARCHAR(255) DEFAULT NULL, bio_description VARCHAR(255) DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, status TINYINT(1) DEFAULT NULL, rates DOUBLE PRECISION DEFAULT NULL, baned VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6493B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC7887F4FB17 FOREIGN KEY (doctor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC786B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B371F7E88B FOREIGN KEY (event_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medicament_pharmacie ADD CONSTRAINT FK_804E4447AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicament_pharmacie ADD CONSTRAINT FK_804E4447BC6D351B FOREIGN KEY (pharmacie_id) REFERENCES pharmacie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C6B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE ordonnance_medicament ADD CONSTRAINT FK_FE7DFAEE2BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)');
        $this->addSql('ALTER TABLE ordonnance_medicament ADD CONSTRAINT FK_FE7DFAEEAB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2376A6230 FOREIGN KEY (idu_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD0067AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD0067F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panierx ADD CONSTRAINT FK_DF4B49BE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE panierx ADD CONSTRAINT FK_DF4B49BEC711D718 FOREIGN KEY (id_medica_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39793E396C FOREIGN KEY (med_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39CE727896 FOREIGN KEY (make_rate_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495567B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DF522508 FOREIGN KEY (fiche_id) REFERENCES fiche (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6493B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC7887F4FB17');
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC786B899279');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B371F7E88B');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE medicament_pharmacie DROP FOREIGN KEY FK_804E4447AB0D61F7');
        $this->addSql('ALTER TABLE medicament_pharmacie DROP FOREIGN KEY FK_804E4447BC6D351B');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C87F4FB17');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C6B899279');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CD9A7F869');
        $this->addSql('ALTER TABLE ordonnance_medicament DROP FOREIGN KEY FK_FE7DFAEE2BF23B8F');
        $this->addSql('ALTER TABLE ordonnance_medicament DROP FOREIGN KEY FK_FE7DFAEEAB0D61F7');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2376A6230');
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD0067AB0D61F7');
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD0067F77D927C');
        $this->addSql('ALTER TABLE panierx DROP FOREIGN KEY FK_DF4B49BE79F37AE5');
        $this->addSql('ALTER TABLE panierx DROP FOREIGN KEY FK_DF4B49BEC711D718');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F9D86650F');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F39793E396C');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F39CE727896');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495567B3B43D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556B899279');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DF522508');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6493B5A08D7');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE med');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE medicament_pharmacie');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE ordonnance_medicament');
        $this->addSql('DROP TABLE pan');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_item');
        $this->addSql('DROP TABLE panierx');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE pharmacie');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
