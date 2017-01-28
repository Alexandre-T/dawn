<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170128150558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_achievement DROP image');
        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_achievement ADD image VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }
}
