<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212140444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Comment table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<SQL
CREATE TABLE comment (
    id INT AUTO_INCREMENT NOT NULL,
    post_id INT NOT NULL,
    author VARCHAR(255) NOT NULL,
    body LONGTEXT NOT NULL,
    url VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    ip INT DEFAULT NULL,
    create_at DATETIME NOT NULL,
    
    INDEX IDX_9474526C4B89032C (post_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
SQL
);

        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comment');
    }
}
