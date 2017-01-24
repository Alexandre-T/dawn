<?php
/**
 * This file is part of the Dawn project.
 *
 * PHP version 7
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category  Testing
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2015 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @link      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Score;
use AppBundle\Entity\Game;

/**
 * Score Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @link     http://opensource.org/licenses/GPL-3.0
 */
class ScoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Score
     */
    private $score;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->score = new Score();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->score = null;
        parent::tearDown();
    }

    /**
     * Tests Score->__construct().
     */
    public function testConstruct()
    {
        self::assertEmpty($this->score->getValue());
        self::assertNull($this->score->getCharacteristic());
        self::assertNull($this->score->getGame());
    }

    /**
     * Tests Score->increase().
     */
    public function testIncrease()
    {
        $this->score->setValue(0);
        $result = $this->score->increase(123);
        self::assertEquals($result, $this->score);
        //No Characteristic, no increase !
        self::assertEquals(0, $this->score->getValue());
        //Characteristic initialization
        $characteristic = new Characteristic();
        $characteristic->setMinimum(-5);
        $characteristic->setMaximum(100);
        $this->score->setCharacteristic($characteristic);

        $result = $this->score->increase(32);
        self::assertEquals($result, $this->score);
        self::assertEquals(32, $this->score->getValue());
        $result = $this->score->increase(98);
        self::assertEquals($result, $this->score);
        self::assertEquals(100, $this->score->getValue());
        $result = $this->score->increase(-30);
        self::assertEquals($result, $this->score);
        self::assertEquals(70, $this->score->getValue());
        $result = $this->score->increase(-78);
        self::assertEquals($result, $this->score);
        self::assertEquals(-5, $this->score->getValue());
    }

    /**
     * Tests Score->getScore().
     */
    public function testGetScore()
    {
        $this->score->setValue(3);
        //No Characteristic, the value
        self::assertEquals($this->score->getValue(), $this->score->getScore());
        //Characteristic initialization
        $characteristic = new Characteristic();
        $characteristic->setMinimum(-5);
        $characteristic->setMaximum(100);
        $this->score->setCharacteristic($characteristic);

        self::assertEquals('3', $this->score->getScore());
        $characteristic->setPrefix('pref');
        self::assertEquals('pref3', $this->score->getScore());
        $characteristic->setSuffix('suf');
        self::assertEquals('pref3suf', $this->score->getScore());
        $characteristic->setMultiply(-1);
        self::assertEquals('pref-3suf', $this->score->getScore());
        $characteristic->setAdd(3);
        self::assertEquals('pref0suf', $this->score->getScore());
    }

    /**
     * Tests Score->getScore() for time.
     */
    public function testGetScoreForTime()
    {
        $this->score->setValue(24);
        //Characteristic initialization
        $characteristic = new Characteristic();
        $characteristic->setMinimum(6);
        $characteristic->setMaximum(24);
        $characteristic->setSuffix(':00');
        $characteristic->setMultiply(-1);
        $characteristic->setAdd(30);
        $this->score->setCharacteristic($characteristic);

        self::assertEquals('6:00', $this->score->getScore());
        $this->score->setValue(23);
        self::assertEquals('7:00', $this->score->getScore());
        $this->score->setValue(12);
        self::assertEquals('18:00', $this->score->getScore());
        $this->score->setValue(6);
        self::assertEquals('24:00', $this->score->getScore());
    }

    /**
     * Tests Score->setValue() Score->getValue().
     */
    public function testSetValue()
    {
        $initial = 123;
        $result = $this->score->setValue($initial);
        self::assertEquals($result, $this->score);
        self::assertEquals($initial, $this->score->getValue());
    }

    /**
     * Tests Score->setCharacteristic() Score->getCharacteristic().
     */
    public function testSetCharacteristic()
    {
        $characteristic = new Characteristic();
        $result = $this->score->setCharacteristic($characteristic);
        self::assertEquals($result, $this->score);
        self::assertEquals($characteristic, $this->score->getCharacteristic());
    }

    /**
     * Tests Score->setGame() Score->getGame().
     */
    public function testSetGame()
    {
        $game = new Game();
        $result = $this->score->setGame($game);
        self::assertEquals($result, $this->score);
        self::assertEquals($game, $this->score->getGame());
    }
}
