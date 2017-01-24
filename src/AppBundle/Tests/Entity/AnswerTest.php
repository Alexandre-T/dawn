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

use AppBundle\Entity\Action;

/**
 * Action Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @link     http://opensource.org/licenses/GPL-3.0
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Action
     */
    private $action;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->action = new Action();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->action = null;
        parent::tearDown();
    }

    /**
     * Tests Action->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->action->getId());
        self::assertNull($this->action->getCoords());
        self::assertNull($this->action->getShape());
        self::assertNull($this->action->getTooltip());
    }

    /**
     * Tests Action->setCoords() Action->getCoords().
     */
    public function testSetCoords()
    {
        $coords = 'foo';
        $result = $this->action->setCoords($coords);
        self::assertEquals($result, $this->action);
        self::assertEquals($coords, $this->action->getCoords());
    }
    
    /**
     * Tests Action->setShape() Action->getShape().
     */
    public function testSetShape()
    {
        $shape = 'foo';
        $result = $this->action->setShape($shape);
        self::assertEquals($result, $this->action);
        self::assertEquals($shape, $this->action->getShape());
    }
    
    /**
     * Tests Action->setTooltip() Action->getTooltip().
     */
    public function testSetTooltip()
    {
        $tooltip = 'foo';
        $result = $this->action->setTooltip($tooltip);
        self::assertEquals($result, $this->action);
        self::assertEquals($tooltip, $this->action->getTooltip());
    }
}
