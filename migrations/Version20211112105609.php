<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112105609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE age_group (id INT AUTO_INCREMENT NOT NULL, age_group VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animateur (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(3) DEFAULT NULL, lname VARCHAR(50) NOT NULL, fname VARCHAR(50) NOT NULL, birthday DATE DEFAULT NULL, birth_city VARCHAR(100) DEFAULT NULL, address VARCHAR(150) NOT NULL, cp VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, phone_mob VARCHAR(15) DEFAULT NULL, phone_home VARCHAR(15) DEFAULT NULL, num_ss VARCHAR(15) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animateur_contract (id INT AUTO_INCREMENT NOT NULL, year_id INT DEFAULT NULL, animateur_id INT DEFAULT NULL, type_contract VARCHAR(50) NOT NULL, salary DOUBLE PRECISION NOT NULL, INDEX IDX_80A81B0440C1FEA7 (year_id), INDEX IDX_80A81B047F05C301 (animateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE children (id INT AUTO_INCREMENT NOT NULL, lname VARCHAR(50) NOT NULL, fname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, medical_obs LONGTEXT DEFAULT NULL, allergy_obs LONGTEXT DEFAULT NULL, food_obs LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qfm (id INT AUTO_INCREMENT NOT NULL, budget VARCHAR(50) NOT NULL, price_one_child DOUBLE PRECISION NOT NULL, price_two_child DOUBLE PRECISION NOT NULL, price_three_child DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, children_id INT DEFAULT NULL, title VARCHAR(3) DEFAULT NULL, relation VARCHAR(10) NOT NULL, lname VARCHAR(50) NOT NULL, fname VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, cp VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(150) DEFAULT NULL, phone_mob VARCHAR(15) DEFAULT NULL, phone_home VARCHAR(15) DEFAULT NULL, work_name VARCHAR(100) DEFAULT NULL, work_phone VARCHAR(15) DEFAULT NULL, INDEX IDX_52520D073D3D2749 (children_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week (id INT AUTO_INCREMENT NOT NULL, week_num SMALLINT NOT NULL, theme VARCHAR(255) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, week_type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE year (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, price_meal DOUBLE PRECISION DEFAULT NULL, price_inscription DOUBLE PRECISION DEFAULT NULL, num_habilitation VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animateur_contract ADD CONSTRAINT FK_80A81B0440C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE animateur_contract ADD CONSTRAINT FK_80A81B047F05C301 FOREIGN KEY (animateur_id) REFERENCES animateur (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D073D3D2749 FOREIGN KEY (children_id) REFERENCES children (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animateur_contract DROP FOREIGN KEY FK_80A81B047F05C301');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D073D3D2749');
        $this->addSql('ALTER TABLE animateur_contract DROP FOREIGN KEY FK_80A81B0440C1FEA7');
        $this->addSql('DROP TABLE age_group');
        $this->addSql('DROP TABLE animateur');
        $this->addSql('DROP TABLE animateur_contract');
        $this->addSql('DROP TABLE children');
        $this->addSql('DROP TABLE qfm');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE week');
        $this->addSql('DROP TABLE year');
    }
}
