<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119074241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE age_group ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE age_group ADD CONSTRAINT FK_F88B425340C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_F88B425340C1FEA7 ON age_group (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE age_group DROP FOREIGN KEY FK_F88B425340C1FEA7');
        $this->addSql('DROP INDEX IDX_F88B425340C1FEA7 ON age_group');
        $this->addSql('ALTER TABLE age_group DROP year_id');
    }
}
