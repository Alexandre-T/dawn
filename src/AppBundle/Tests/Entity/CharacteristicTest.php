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

use AppBundle\Entity\Characteristic;

/**
 * Characteristic Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class CharacteristicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Characteristic
     */
    private $characteristic;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->characteristic = new Characteristic();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->characteristic = null;
        parent::tearDown();
    }

    /**
     * Tests Characteristic->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->characteristic->getCode());
        self::assertNull($this->characteristic->getId());

        self::assertInternalType('int', $this->characteristic->getInitial());
        self::assertInternalType('int', $this->characteristic->getMaximum());
        self::assertInternalType('int', $this->characteristic->getMinimum());

        self::assertEquals(0, $this->characteristic->getInitial());
        self::assertEquals(100, $this->characteristic->getMaximum());
        self::assertEquals(0, $this->characteristic->getMinimum());

        self::assertNull($this->characteristic->getName());
        self::assertNull($this->characteristic->getSort());

        self::assertNotNull($this->characteristic->getPrefix());
        self::assertInternalType('string', $this->characteristic->getPrefix());
        self::assertEmpty($this->characteristic->getPrefix());

        self::assertNotNull($this->characteristic->getSuffix());
        self::assertInternalType('string', $this->characteristic->getSuffix());
        self::assertEmpty($this->characteristic->getSuffix());

        self::assertNotNull($this->characteristic->getMultiply());
        self::assertInternalType('int', $this->characteristic->getMultiply());
        self::assertEquals(1, $this->characteristic->getMultiply());

        self::assertNotNull($this->characteristic->getAdd());
        self::assertInternalType('int', $this->characteristic->getAdd());
        self::assertEquals(0, $this->characteristic->getAdd());
    }

    /**
     * Tests Characteristic->setCode() Characteristic->getCode().
     */
    public function testSetCode()
    {
        $code = 'foo';
        $result = $this->characteristic->setCode($code);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($code, $this->characteristic->getCode());
    }

    /**
     * Tests Characteristic->setInitial() Characteristic->getInitial().
     */
    public function testSetInitial()
    {
        $initial = 123;
        $result = $this->characteristic->setInitial($initial);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($initial, $this->characteristic->getInitial());
    }

    /**
     * Tests Characteristic->setMaximum() Characteristic->getMaximum().
     */
    public function testSetMaximum()
    {
        $maximum = 123;
        $result = $this->characteristic->setMaximum($maximum);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($maximum, $this->characteristic->getMaximum());
    }

    /**
     * Tests Characteristic->setMinimum() Characteristic->getMinimum().
     */
    public function testSetMinimum()
    {
        $minimum = 123;
        $result = $this->characteristic->setMinimum($minimum);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($minimum, $this->characteristic->getMinimum());
    }

    /**
     * Tests Characteristic->setName() Characteristic->getName().
     */
    public function testSetName()
    {
        $name = 'foo';
        $result = $this->characteristic->setName($name);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($name, $this->characteristic->getName());
    }

    /**
     * Tests Characteristic->setSort() Characteristic->getSort().
     */
    public function testSetSort()
    {
        $sort = 123;
        $result = $this->characteristic->setSort($sort);
        self::assertEquals($result, $this->characteristic);
        self::assertEquals($sort, $this->characteristic->getSort());
    }
}
