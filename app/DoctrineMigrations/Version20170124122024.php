<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170124122024 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_game ADD debug TINYINT(1) DEFAULT \'0\' NOT NULL, DROP loc_id, CHANGE gam_ver version VARCHAR(8) DEFAULT NULL');
        $this->addSql('ALTER TABLE te_scene CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_game ADD loc_id TINYINT(1) DEFAULT \'0\' NOT NULL, DROP debug, CHANGE version gam_ver VARCHAR(8) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE te_scene CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }
}
