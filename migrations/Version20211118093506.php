<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118093506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE week ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C040C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_5B5A69C040C1FEA7 ON week (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C040C1FEA7');
        $this->addSql('DROP INDEX IDX_5B5A69C040C1FEA7 ON week');
        $this->addSql('ALTER TABLE week DROP year_id');
    }
}
