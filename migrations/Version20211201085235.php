<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201085235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animateur_contract ADD age_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animateur_contract ADD CONSTRAINT FK_80A81B04B09E220E FOREIGN KEY (age_group_id) REFERENCES age_group (id)');
        $this->addSql('CREATE INDEX IDX_80A81B04B09E220E ON animateur_contract (age_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animateur_contract DROP FOREIGN KEY FK_80A81B04B09E220E');
        $this->addSql('DROP INDEX IDX_80A81B04B09E220E ON animateur_contract');
        $this->addSql('ALTER TABLE animateur_contract DROP age_group_id');
    }
}
