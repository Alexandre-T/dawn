<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170128111935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE te_achievement ADD media_id INT NOT NULL');
        $this->addSql('ALTER TABLE te_achievement ADD CONSTRAINT FK_82BF27B4EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_82BF27B4EA9FDD75 ON te_achievement (media_id)');
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

        $this->addSql('ALTER TABLE te_achievement DROP FOREIGN KEY FK_82BF27B4EA9FDD75');
        $this->addSql('DROP INDEX IDX_82BF27B4EA9FDD75 ON te_achievement');
        $this->addSql('ALTER TABLE te_achievement DROP media_id');
        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }
}
