<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909032519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE entry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entry (id INT NOT NULL, submission_id INT NOT NULL, task TEXT NOT NULL, hours_planned DOUBLE PRECISION NOT NULL, hours_actual DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B219D70E1FD4933 ON entry (submission_id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT FK_2B219D70E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE entry_id_seq CASCADE');
        $this->addSql('ALTER TABLE entry DROP CONSTRAINT FK_2B219D70E1FD4933');
        $this->addSql('DROP TABLE entry');
    }
}
