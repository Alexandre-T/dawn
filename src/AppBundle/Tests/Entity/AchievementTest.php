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

use AppBundle\Entity\Achievement;

/**
 * Achievement Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class AchievementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Achievement
     */
    private $achievement;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->achievement = new Achievement();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->achievement = null;
        parent::tearDown();
    }

    /**
     * Tests Achievement->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->achievement->getId());
        self::assertNull($this->achievement->getAlternat());
        self::assertNull($this->achievement->getImage());
        self::assertNull($this->achievement->getTitle());
    }

    /**
     * Tests Achievement->setAlternat() Achievement->getAlternat().
     */
    public function testSetAlternat()
    {
        $alternat = 'foo';
        $result = $this->achievement->setAlternat($alternat);
        self::assertEquals($result, $this->achievement);
        self::assertEquals($alternat, $this->achievement->getAlternat());
    }

    /**
     * Tests Achievement->setImage() Achievement->getImage().
     */
    public function testSetImage()
    {
        $image = 'foo';
        $result = $this->achievement->setImage($image);
        self::assertEquals($result, $this->achievement);
        self::assertEquals($image, $this->achievement->getImage());
    }

    /**
     * Tests Achievement->setTitle() Achievement->getTitle().
     */
    public function testSetTitle()
    {
        $title = 'foo';
        $result = $this->achievement->setTitle($title);
        self::assertEquals($result, $this->achievement);
        self::assertEquals($title, $this->achievement->getTitle());
    }
}
