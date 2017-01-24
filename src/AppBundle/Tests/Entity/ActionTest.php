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
use AppBundle\Entity\Influence;
use AppBundle\Entity\Scene;

/**
 * Answer Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @link     http://opensource.org/licenses/GPL-3.0
 */
class AnswerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Answer
     */
    private $answer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->answer = new Answer();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->answer = null;
        parent::tearDown();
    }

    /**
     * Tests Answer->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->answer->getId());
        self::assertNull($this->answer->getDestination());
    }

    /**
     * Tests Answer->setDestination() Answer->getDestination().
     */
    public function testSetDestination()
    {
        $destination = new Scene();
        $result = $this->answer->setDestination($destination);
        self::assertEquals($result, $this->answer);
        self::assertEquals($destination, $this->answer->getDestination());
    }

    /**
     * Tests Answer get add removeInfluence ().
     */
    public function testInfluences()
    {
        $influence1 = new Influence();
        $influence2 = new Influence();
        $this->answer->addInfluence($influence1);
        self::assertCount(1, $this->answer->getInfluences());
        self::assertTrue($this->answer->getInfluences()->contains($influence1));
        self::assertFalse($this->answer->getInfluences()->contains($influence2));
        $this->answer->addInfluence($influence2);
        self::assertCount(2, $this->answer->getInfluences());
        self::assertTrue($this->answer->getInfluences()->contains($influence1));
        self::assertTrue($this->answer->getInfluences()->contains($influence2));
        $this->answer->removeInfluence($influence1);
        self::assertCount(1, $this->answer->getInfluences());
        self::assertFalse($this->answer->getInfluences()->contains($influence1));
        self::assertTrue($this->answer->getInfluences()->contains($influence2));
        $this->answer->removeInfluence($influence2);
        self::assertCount(0, $this->answer->getInfluences());
        self::assertFalse($this->answer->getInfluences()->contains($influence1));
        self::assertFalse($this->answer->getInfluences()->contains($influence2));
    }
}
