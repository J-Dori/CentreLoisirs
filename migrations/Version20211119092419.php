<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119092419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE qfm');
        $this->addSql('ALTER TABLE rate ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F3940C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_DFEC3F3940C1FEA7 ON rate (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qfm (id INT AUTO_INCREMENT NOT NULL, budget VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price_one_child DOUBLE PRECISION NOT NULL, price_two_child DOUBLE PRECISION NOT NULL, price_three_child DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F3940C1FEA7');
        $this->addSql('DROP INDEX IDX_DFEC3F3940C1FEA7 ON rate');
        $this->addSql('ALTER TABLE rate DROP year_id');
    }
}
