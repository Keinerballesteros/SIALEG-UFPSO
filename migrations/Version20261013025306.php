<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261013025306 extends AbstractMigration
{
    public function up(Schema $schema): void
{
    $this->addSql('ALTER TABLE TV_USUARIO_ESTUDIANTE_CON_PRERREGISTRO RENAME COLUMN UACP_CODIGOUNI TO UECP_CODIGOUNI');
}

public function down(Schema $schema): void
{
    $this->addSql('ALTER TABLE TV_USUARIO_ESTUDIANTE_CON_PRERREGISTRO RENAME COLUMN UECP_CODIGOUNI TO UACP_CODIGOUNI');
}
}
