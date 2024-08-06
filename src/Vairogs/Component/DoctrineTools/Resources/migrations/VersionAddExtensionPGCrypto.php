<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class VersionAddExtensionPGCrypto extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'CREATE EXTENSION IF NOT EXISTS "pgcrypto"';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE EXTENSION IF NOT EXISTS "pgcrypto"');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP EXTENSION IF EXISTS "pgcrypto"');
    }
}
