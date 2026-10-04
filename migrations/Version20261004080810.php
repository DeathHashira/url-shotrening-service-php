<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261004080810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add stats column';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE urls
        ADD stats INT DEFAULT 0");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE urls
        DROP stats INT DEFAULT 0");
    }
}
