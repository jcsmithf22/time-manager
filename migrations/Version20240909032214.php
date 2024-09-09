<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909032214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE submission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE submission (id INT NOT NULL, submitter_id UUID NOT NULL, date DATE NOT NULL, comments TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB055AF3919E5513 ON submission (submitter_id)');
        $this->addSql('COMMENT ON COLUMN submission.submitter_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3919E5513 FOREIGN KEY (submitter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE submission_id_seq CASCADE');
        $this->addSql('ALTER TABLE submission DROP CONSTRAINT FK_DB055AF3919E5513');
        $this->addSql('DROP TABLE submission');
    }
}
