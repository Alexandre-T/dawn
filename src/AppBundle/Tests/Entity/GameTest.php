<?php
/**
 * This file is part of the Dawn project.
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

namespace AppBundle\Tests\Entity;

use AppBundle\Controller\Exception\GameException;
use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Game;
use AppBundle\Entity\Score;

/**
 * Game Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Game
     */
    private $game;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->game = new Game();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->game = null;
        parent::tearDown();
    }

    /**
     * Tests Game->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->game->getId());
        self::assertNull($this->game->getCurrentScene());
        self::assertEquals(Game::VERSION, $this->game->getVersion());
        self::assertNotNull($this->game->getScores());
        self::assertEmpty($this->game->getScores());
    }

    /**
     * Tests Game->setVersion() Game->getVersion().
     */
    public function testSetVersion()
    {
        $version = 'foo';
        $result = $this->game->setVersion($version);
        self::assertEquals($result, $this->game);
        self::assertEquals($version, $this->game->getVersion());
    }

    /**
     * Tests Game get add removeScore ().
     */
    public function testScores()
    {
        $score1 = new Score();
        $score2 = new Score();
        $this->game->addScore($score1);
        self::assertCount(1, $this->game->getScores());
        self::assertTrue($this->game->getScores()->contains($score1));
        self::assertFalse($this->game->getScores()->contains($score2));
        $this->game->addScore($score2);
        self::assertCount(2, $this->game->getScores());
        self::assertTrue($this->game->getScores()->contains($score1));
        self::assertTrue($this->game->getScores()->contains($score2));
        $this->game->removeScore($score1);
        self::assertCount(1, $this->game->getScores());
        self::assertFalse($this->game->getScores()->contains($score1));
        self::assertTrue($this->game->getScores()->contains($score2));
        $this->game->removeScore($score2);
        self::assertCount(0, $this->game->getScores());
        self::assertFalse($this->game->getScores()->contains($score1));
        self::assertFalse($this->game->getScores()->contains($score2));
    }

    /**
     * Test Game->getScore() when there is no Score.
     */
    public function testGetScoreNull()
    {
        self::expectException(GameException::class);
        self::expectExceptionCode(GameException::CRITICAL);

        $characteristic1 = new Characteristic();
        self::assertNull($this->game->getScore($characteristic1));
    }

    /**
     * Test Game->getScore() when Characteristic is not in Score.
     */
    public function testGetScoreUnknown()
    {
        self::expectException(GameException::class);
        self::expectExceptionCode(GameException::CRITICAL);

        $characteristic1 = new Characteristic();
        $characteristic2 = new Characteristic();

        $score1 = new Score();
        $score1->setCharacteristic($characteristic1);

        //Characteristic2 is not in Scores
        self::assertNull($this->game->getScore($characteristic2));
    }

    /**
     * Test Game->getScore() in standard mode.
     */
    public function testGetScore()
    {
        $characteristic1 = new Characteristic();
        $characteristic2 = new Characteristic();

        $score1 = new Score();
        $score1->setCharacteristic($characteristic1);

        $score2 = new Score();
        $score2->setCharacteristic($characteristic2);

        $this->game->addScore($score1);
        $this->game->addScore($score2);

        self::assertEquals($score1, $this->game->getScore($characteristic1));
        self::assertEquals($score2, $this->game->getScore($characteristic2));
    }
}
