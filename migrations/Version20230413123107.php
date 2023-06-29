<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413123107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD vendeur1 VARCHAR(255) NOT NULL, ADD vendeur2 VARCHAR(255) DEFAULT NULL, ADD introduction LONGTEXT NOT NULL, ADD titre_secondaire VARCHAR(255) NOT NULL, ADD titre_conclusion VARCHAR(255) NOT NULL, ADD conclusion LONGTEXT NOT NULL, ADD prix NUMERIC(10, 3) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP vendeur1, DROP vendeur2, DROP introduction, DROP titre_secondaire, DROP titre_conclusion, DROP conclusion, DROP prix');
    }
}
