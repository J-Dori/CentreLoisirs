<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201143400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_detail ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription_detail ADD CONSTRAINT FK_26390BEA40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_26390BEA40C1FEA7 ON inscription_detail (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_detail DROP FOREIGN KEY FK_26390BEA40C1FEA7');
        $this->addSql('DROP INDEX IDX_26390BEA40C1FEA7 ON inscription_detail');
        $this->addSql('ALTER TABLE inscription_detail DROP year_id');
    }
}
