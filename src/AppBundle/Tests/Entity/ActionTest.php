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
 * @link      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Action;
use AppBundle\Entity\Scene;

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
     * Tests Action get add removeScene ().
     */
    public function testScenes()
    {
        $scene1 = new Scene();
        $scene2 = new Scene();
        $this->action->addScene($scene1);
        self::assertCount(1, $this->action->getScenes());
        self::assertTrue($this->action->getScenes()->contains($scene1));
        self::assertFalse($this->action->getScenes()->contains($scene2));
        $this->action->addScene($scene2);
        self::assertCount(2, $this->action->getScenes());
        self::assertTrue($this->action->getScenes()->contains($scene1));
        self::assertTrue($this->action->getScenes()->contains($scene2));
        $this->action->removeScene($scene1);
        self::assertCount(1, $this->action->getScenes());
        self::assertFalse($this->action->getScenes()->contains($scene1));
        self::assertTrue($this->action->getScenes()->contains($scene2));
        $this->action->removeScene($scene2);
        self::assertCount(0, $this->action->getScenes());
        self::assertFalse($this->action->getScenes()->contains($scene1));
        self::assertFalse($this->action->getScenes()->contains($scene2));
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
