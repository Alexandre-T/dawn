<?php
/**
 * This file is part of the Dawn Project.
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

use AppBundle\Entity\Answer;
use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Influence;

/**
 * Influence Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @link     http://opensource.org/licenses/GPL-3.0
 */
class InfluenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Influence
     */
    private $influence;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->influence = new Influence();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->influence = null;
        parent::tearDown();
    }

    /**
     * Tests Influence->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->influence->getId());
        self::assertNull($this->influence->getAnswer());
        self::assertInternalType('int', $this->influence->getBonus());
        self::assertEquals(0, $this->influence->getBonus());
        self::assertNull($this->influence->getCharacteristic());
    }

    /**
     * Tests Influence->setAnswer() Influence->getAnswer().
     */
    public function testSetAnswer()
    {
        $answer = new Answer();
        $result = $this->influence->setAnswer($answer);
        self::assertEquals($result, $this->influence);
        self::assertEquals($answer, $this->influence->getAnswer());
    }

    /**
     * Tests Influence->setBonus() Influence->getBonus().
     */
    public function testSetBonus()
    {
        $bonus = 15;
        $result = $this->influence->setBonus($bonus);
        self::assertEquals($result, $this->influence);
        self::assertEquals($bonus, $this->influence->getBonus());
    }

    /**
     * Tests Influence->setCharacteristic() Influence->getCharacteristic().
     */
    public function testSetCharacteristic()
    {
        $characteristic = new Characteristic();
        $result = $this->influence->setCharacteristic($characteristic);
        self::assertEquals($result, $this->influence);
        self::assertEquals($characteristic, $this->influence->getCharacteristic());
    }
}
