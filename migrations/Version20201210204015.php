<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210204015 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_feelings DROP FOREIGN KEY FK_65C1D1D8613FECDF');
        $this->addSql('DROP INDEX IDX_65C1D1D8613FECDF ON customer_feelings');
        $this->addSql('ALTER TABLE customer_feelings CHANGE session_id session_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_feelings CHANGE session_id session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer_feelings ADD CONSTRAINT FK_65C1D1D8613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_65C1D1D8613FECDF ON customer_feelings (session_id)');
    }
}
