<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925154055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_906517449395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invoice AS SELECT id, customer_id, amount, sent_at, status FROM invoice');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('CREATE TABLE invoice (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, amount DOUBLE PRECISION NOT NULL, sent_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL COLLATE BINARY, chrono INTEGER NOT NULL, CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invoice (id, customer_id, amount, sent_at, status) SELECT id, customer_id, amount, sent_at, status FROM __temp__invoice');
        $this->addSql('DROP TABLE __temp__invoice');
        $this->addSql('CREATE INDEX IDX_906517449395C3F3 ON invoice (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_906517449395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invoice AS SELECT id, customer_id, amount, sent_at, status FROM invoice');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('CREATE TABLE invoice (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, amount DOUBLE PRECISION NOT NULL, sent_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO invoice (id, customer_id, amount, sent_at, status) SELECT id, customer_id, amount, sent_at, status FROM __temp__invoice');
        $this->addSql('DROP TABLE __temp__invoice');
        $this->addSql('CREATE INDEX IDX_906517449395C3F3 ON invoice (customer_id)');
    }
}
