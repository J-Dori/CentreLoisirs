<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211203065813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fin_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fin_expense (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, year_id INT NOT NULL, num_exp INT NOT NULL, date_in DATE NOT NULL, pay_mode VARCHAR(20) NOT NULL, doc_num VARCHAR(100) NOT NULL, amount DOUBLE PRECISION NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_56E52BA912469DE2 (category_id), INDEX IDX_56E52BA940C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fin_income (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, year_id INT NOT NULL, num_inc INT NOT NULL, date_in DATE NOT NULL, pay_mode VARCHAR(20) NOT NULL, doc_num VARCHAR(100) DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_5125C31A12469DE2 (category_id), INDEX IDX_5125C31A40C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fin_expense ADD CONSTRAINT FK_56E52BA912469DE2 FOREIGN KEY (category_id) REFERENCES fin_category (id)');
        $this->addSql('ALTER TABLE fin_expense ADD CONSTRAINT FK_56E52BA940C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE fin_income ADD CONSTRAINT FK_5125C31A12469DE2 FOREIGN KEY (category_id) REFERENCES fin_category (id)');
        $this->addSql('ALTER TABLE fin_income ADD CONSTRAINT FK_5125C31A40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fin_expense DROP FOREIGN KEY FK_56E52BA912469DE2');
        $this->addSql('ALTER TABLE fin_income DROP FOREIGN KEY FK_5125C31A12469DE2');
        $this->addSql('DROP TABLE fin_category');
        $this->addSql('DROP TABLE fin_expense');
        $this->addSql('DROP TABLE fin_income');
    }
}
