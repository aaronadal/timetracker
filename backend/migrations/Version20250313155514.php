<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250313155514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Auth Users Table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE auth__users (
          id CHAR(36) NOT NULL,
          name VARCHAR(255) NOT NULL,
          created_at INT NOT NULL,
          updated_at INT NOT NULL,
          deleted_at INT DEFAULT NULL,
          UNIQUE INDEX unq_name (name),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE auth__users');
    }
}
