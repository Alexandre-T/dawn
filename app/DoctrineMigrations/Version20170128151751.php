<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170128151751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene ADD media_id INT NOT NULL, DROP image, CHANGE initial initial TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE te_scene ADD CONSTRAINT FK_763581A4EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_763581A4EA9FDD75 ON te_scene (media_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene DROP FOREIGN KEY FK_763581A4EA9FDD75');
        $this->addSql('DROP INDEX IDX_763581A4EA9FDD75 ON te_scene');
        $this->addSql('ALTER TABLE te_scene ADD image VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, DROP media_id, CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }
}
