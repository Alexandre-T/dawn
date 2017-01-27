<?php
/**
 * This file is part of the Dawn Project.
 *
 * PHP version 5.6
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category  Testing
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2015 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @see      http://opensource.org/licenses/GPL-3.0
 */

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170123201521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE te_achievement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(32) NOT NULL, image VARCHAR(16) NOT NULL, alternat VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE te_answer (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, dtype VARCHAR(255) NOT NULL, tooltip LONGTEXT DEFAULT NULL, shape VARCHAR(255) DEFAULT NULL, coords VARCHAR(255) DEFAULT NULL, sentence LONGTEXT DEFAULT NULL, INDEX IDX_6DCF5A70166053B4 (scene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE te_characteristics_cha (cha_id INT UNSIGNED AUTO_INCREMENT NOT NULL, cha_code VARCHAR(16) NOT NULL, cha_name VARCHAR(16) NOT NULL, cha_initial INT DEFAULT 0 NOT NULL, cha_minimum INT DEFAULT 0, cha_maximum INT DEFAULT 100, cha_sort INT DEFAULT NULL, cha_prefix VARCHAR(8) NOT NULL, cha_suffix VARCHAR(255) NOT NULL, cha_multiply INT DEFAULT 1 NOT NULL, cha_add INT DEFAULT 0 NOT NULL, PRIMARY KEY(cha_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE te_game (gam_uid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', scene_id INT NOT NULL, gam_ver VARCHAR(8) DEFAULT NULL, loc_id TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_655E0325166053B4 (scene_id), PRIMARY KEY(gam_uid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tj_achievements (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', achievement_id INT NOT NULL, INDEX IDX_8114B34FE48FD905 (game_id), INDEX IDX_8114B34FB3EC99FE (achievement_id), PRIMARY KEY(game_id, achievement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE te_influence (id INT AUTO_INCREMENT NOT NULL, answer_id INT DEFAULT NULL, characteristic_id INT UNSIGNED DEFAULT NULL, bonus INT DEFAULT 0 NOT NULL, INDEX IDX_9B7F8BC4AA334807 (answer_id), INDEX IDX_9B7F8BC4DEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE te_scene (id INT AUTO_INCREMENT NOT NULL, achievement_id INT DEFAULT NULL, dialogue LONGTEXT DEFAULT NULL, image VARCHAR(16) NOT NULL, INDEX IDX_763581A4B3EC99FE (achievement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tj_answers (scene_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_94DFBEBC166053B4 (scene_id), INDEX IDX_94DFBEBCAA334807 (answer_id), PRIMARY KEY(scene_id, answer_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tj_score_sco (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', characteristic_id INT UNSIGNED NOT NULL, sco_value INT NOT NULL, INDEX IDX_D75D27EE48FD905 (game_id), INDEX IDX_D75D27EDEE9D12B (characteristic_id), PRIMARY KEY(game_id, characteristic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE te_answer ADD CONSTRAINT FK_6DCF5A70166053B4 FOREIGN KEY (scene_id) REFERENCES te_scene (id)');
        $this->addSql('ALTER TABLE te_game ADD CONSTRAINT FK_655E0325166053B4 FOREIGN KEY (scene_id) REFERENCES te_scene (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE tj_achievements ADD CONSTRAINT FK_8114B34FE48FD905 FOREIGN KEY (game_id) REFERENCES te_game (gam_uid)');
        $this->addSql('ALTER TABLE tj_achievements ADD CONSTRAINT FK_8114B34FB3EC99FE FOREIGN KEY (achievement_id) REFERENCES te_achievement (id)');
        $this->addSql('ALTER TABLE te_influence ADD CONSTRAINT FK_9B7F8BC4AA334807 FOREIGN KEY (answer_id) REFERENCES te_answer (id)');
        $this->addSql('ALTER TABLE te_influence ADD CONSTRAINT FK_9B7F8BC4DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES te_characteristics_cha (cha_id)');
        $this->addSql('ALTER TABLE te_scene ADD CONSTRAINT FK_763581A4B3EC99FE FOREIGN KEY (achievement_id) REFERENCES te_achievement (id)');
        $this->addSql('ALTER TABLE tj_answers ADD CONSTRAINT FK_94DFBEBC166053B4 FOREIGN KEY (scene_id) REFERENCES te_scene (id)');
        $this->addSql('ALTER TABLE tj_answers ADD CONSTRAINT FK_94DFBEBCAA334807 FOREIGN KEY (answer_id) REFERENCES te_answer (id)');
        $this->addSql('ALTER TABLE tj_score_sco ADD CONSTRAINT FK_D75D27EE48FD905 FOREIGN KEY (game_id) REFERENCES te_game (gam_uid)');
        $this->addSql('ALTER TABLE tj_score_sco ADD CONSTRAINT FK_D75D27EDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES te_characteristics_cha (cha_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tj_achievements DROP FOREIGN KEY FK_8114B34FB3EC99FE');
        $this->addSql('ALTER TABLE te_scene DROP FOREIGN KEY FK_763581A4B3EC99FE');
        $this->addSql('ALTER TABLE te_influence DROP FOREIGN KEY FK_9B7F8BC4AA334807');
        $this->addSql('ALTER TABLE tj_answers DROP FOREIGN KEY FK_94DFBEBCAA334807');
        $this->addSql('ALTER TABLE te_influence DROP FOREIGN KEY FK_9B7F8BC4DEE9D12B');
        $this->addSql('ALTER TABLE tj_score_sco DROP FOREIGN KEY FK_D75D27EDEE9D12B');
        $this->addSql('ALTER TABLE tj_achievements DROP FOREIGN KEY FK_8114B34FE48FD905');
        $this->addSql('ALTER TABLE tj_score_sco DROP FOREIGN KEY FK_D75D27EE48FD905');
        $this->addSql('ALTER TABLE te_answer DROP FOREIGN KEY FK_6DCF5A70166053B4');
        $this->addSql('ALTER TABLE te_game DROP FOREIGN KEY FK_655E0325166053B4');
        $this->addSql('ALTER TABLE tj_answers DROP FOREIGN KEY FK_94DFBEBC166053B4');
        $this->addSql('DROP TABLE te_achievement');
        $this->addSql('DROP TABLE te_answer');
        $this->addSql('DROP TABLE te_characteristics_cha');
        $this->addSql('DROP TABLE te_game');
        $this->addSql('DROP TABLE tj_achievements');
        $this->addSql('DROP TABLE te_influence');
        $this->addSql('DROP TABLE te_scene');
        $this->addSql('DROP TABLE tj_answers');
        $this->addSql('DROP TABLE tj_score_sco');
    }
}
