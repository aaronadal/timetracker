<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250314090926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Tracking WorkEntries Table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tracking__work_entries (
          id CHAR(36) NOT NULL,
          user CHAR(36) NOT NULL,
          start INT NOT NULL,
        end INT NOT NULL,
        created_at INT NOT NULL,
        updated_at INT NOT NULL,
        deleted_at INT DEFAULT NULL,
        INDEX idx_user (user),
        PRIMARY KEY(id))DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tracking__work_entries');
    }
}
