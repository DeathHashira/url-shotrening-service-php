<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261003190711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create urls table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE urls (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        short_code VARCHAR(255) UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS urls");
    }
}
