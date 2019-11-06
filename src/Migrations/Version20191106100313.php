<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106100313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE etat etat TinyInt(1) NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE statut statut TinyInt(1) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE role role TinyInt(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE etat etat TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE statut statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE role role TINYINT(1) NOT NULL');
    }
}
