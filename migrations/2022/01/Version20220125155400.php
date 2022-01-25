<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220125155400 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE oauth2_authorization_code CHANGE user_identifier user_identifier VARCHAR(128) DEFAULT NULL;');
        $this->addSql('ALTER TABLE oauth2_refresh_token CHANGE access_token access_token CHAR(80) DEFAULT NULL;');
        $this->addSql('ALTER TABLE oauth2_client CHANGE secret secret VARCHAR(128) DEFAULT NULL;');
        $this->addSql('ALTER TABLE oauth2_access_token CHANGE user_identifier user_identifier VARCHAR(128) DEFAULT NULL;');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL;');
    }
}