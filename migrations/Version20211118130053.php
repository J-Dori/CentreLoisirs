<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118130053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE array_list ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE array_list ADD CONSTRAINT FK_33AC1EC040C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33AC1EC040C1FEA7 ON array_list (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE array_list DROP FOREIGN KEY FK_33AC1EC040C1FEA7');
        $this->addSql('DROP INDEX UNIQ_33AC1EC040C1FEA7 ON array_list');
        $this->addSql('ALTER TABLE array_list DROP year_id');
    }
}
