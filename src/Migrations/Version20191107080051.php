<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107080051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, objet_id INT NOT NULL, emplacement_id INT NOT NULL, etat TinyInt(1) NOT NULL, INDEX IDX_23A0E66F520CF5A (objet_id), INDEX IDX_23A0E66C4598A51 (emplacement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, INDEX IDX_C0CF65F6F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, quantite SMALLINT NOT NULL, photo VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peremption (article_id INT NOT NULL, date_peremption DATE NOT NULL, PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, statut TinyInt(1) NOT NULL, INDEX IDX_42C84955FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_has_articles (reservation_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_CCAABA5EB83297E7 (reservation_id), INDEX IDX_CCAABA5E7294869C (article_id), PRIMARY KEY(reservation_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, role TinyInt(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B36C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacement (id)');
        $this->addSql('ALTER TABLE emplacement ADD CONSTRAINT FK_C0CF65F6F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE peremption ADD CONSTRAINT FK_9240DCB27294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_has_articles ADD CONSTRAINT FK_CCAABA5EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation_has_articles ADD CONSTRAINT FK_CCAABA5E7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE peremption DROP FOREIGN KEY FK_9240DCB27294869C');
        $this->addSql('ALTER TABLE reservation_has_articles DROP FOREIGN KEY FK_CCAABA5E7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C4598A51');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F520CF5A');
        $this->addSql('ALTER TABLE reservation_has_articles DROP FOREIGN KEY FK_CCAABA5EB83297E7');
        $this->addSql('ALTER TABLE emplacement DROP FOREIGN KEY FK_C0CF65F6F6BD1646');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FB88E14F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE peremption');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_has_articles');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE utilisateur');
    }
}
