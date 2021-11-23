<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114085448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable_children (responsable_id INT NOT NULL, children_id INT NOT NULL, INDEX IDX_853FDDA053C59D72 (responsable_id), INDEX IDX_853FDDA03D3D2749 (children_id), PRIMARY KEY(responsable_id, children_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE responsable_children ADD CONSTRAINT FK_853FDDA053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable_children ADD CONSTRAINT FK_853FDDA03D3D2749 FOREIGN KEY (children_id) REFERENCES children (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE responsable_children');
    }
}
