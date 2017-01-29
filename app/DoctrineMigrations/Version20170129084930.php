<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170129084930 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE needed (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, characteristic_id INT UNSIGNED NOT NULL, redirect_id INT NOT NULL, value INT DEFAULT 1 NOT NULL, INDEX IDX_C39D69DA166053B4 (scene_id), INDEX IDX_C39D69DADEE9D12B (characteristic_id), INDEX IDX_C39D69DAB42D874D (redirect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE needed ADD CONSTRAINT FK_C39D69DA166053B4 FOREIGN KEY (scene_id) REFERENCES te_scene (id)');
        $this->addSql('ALTER TABLE needed ADD CONSTRAINT FK_C39D69DADEE9D12B FOREIGN KEY (characteristic_id) REFERENCES te_characteristics_cha (cha_id)');
        $this->addSql('ALTER TABLE needed ADD CONSTRAINT FK_C39D69DAB42D874D FOREIGN KEY (redirect_id) REFERENCES te_scene (id)');
        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene ADD game_over TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE needed');
        $this->addSql('ALTER TABLE te_game CHANGE debug debug TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE te_scene DROP game_over, CHANGE initial initial TINYINT(1) DEFAULT NULL');
    }
}
