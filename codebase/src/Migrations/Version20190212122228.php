<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212122228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Post table and User table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<SQL
CREATE TABLE post (
    id INT AUTO_INCREMENT NOT NULL,
    author_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    body LONGTEXT DEFAULT NULL,
    create_at DATETIME NOT NULL,
    update_at DATETIME DEFAULT NULL,
    status INT NOT NULL,
    
    INDEX IDX_5A8A6C8DF675F31B (author_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
SQL
);

        $this->addSql(<<<SQL
CREATE TABLE `user` (
    id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(180) NOT NULL,
    username_canonical VARCHAR(180) NOT NULL,
    email VARCHAR(180) NOT NULL,
    email_canonical VARCHAR(180) NOT NULL,
    enabled TINYINT(1) NOT NULL,
    salt VARCHAR(255) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    last_login DATETIME DEFAULT NULL,
    confirmation_token VARCHAR(180) DEFAULT NULL,
    password_requested_at DATETIME DEFAULT NULL,
    roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)',
    
    UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical),
    UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical),
    UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
SQL
);

        $this->addSql(<<<SQL
ALTER TABLE post
    ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)
SQL
);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE `user`');
    }
}
