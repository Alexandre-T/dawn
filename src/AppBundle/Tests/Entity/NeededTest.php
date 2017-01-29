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

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Scene;
use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Needed;

/**
 * Needed Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class NeededTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Needed
     */
    private $needed;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->needed = new Needed();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->needed = null;
        parent::tearDown();
    }

    /**
     * Tests Needed->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->needed->getId());
        self::assertNull($this->needed->getScene());
        self::assertNull($this->needed->getRedirectScene());
        self::assertInternalType('int', $this->needed->getValue());
        self::assertEquals(1, $this->needed->getValue());
        self::assertNull($this->needed->getCharacteristic());
    }

    /**
     * Tests Needed->setScene() Needed->getScene().
     */
    public function testSetScene()
    {
        $scene = new Scene();
        $result = $this->needed->setScene($scene);
        self::assertEquals($result, $this->needed);
        self::assertEquals($scene, $this->needed->getScene());
        self::assertNull($this->needed->getRedirectScene());
    }

    /**
     * Tests Needed->setRedirectScene() Needed->getRedirectScene().
     */
    public function testSetRedirectScene()
    {
        $scene = new Scene();
        $result = $this->needed->setRedirectScene($scene);
        self::assertEquals($result, $this->needed);
        self::assertEquals($scene, $this->needed->getRedirectScene());
        self::assertNull($this->needed->getScene());
    }

    /**
     * Tests Needed->setValue() Needed->getValue().
     */
    public function testSetValue()
    {
        $value = 15;
        $result = $this->needed->setValue($value);
        self::assertEquals($result, $this->needed);
        self::assertEquals($value, $this->needed->getValue());
    }

    /**
     * Tests Needed->setCharacteristic() Needed->getCharacteristic().
     */
    public function testSetCharacteristic()
    {
        $characteristic = new Characteristic();
        $result = $this->needed->setCharacteristic($characteristic);
        self::assertEquals($result, $this->needed);
        self::assertEquals($characteristic, $this->needed->getCharacteristic());
    }
}
