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

use AppBundle\Entity\Sentence;
use AppBundle\Entity\Scene;

/**
 * Sentence Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class SentenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Sentence
     */
    private $sentence;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sentence = new Sentence();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->sentence = null;
        parent::tearDown();
    }

    /**
     * Tests Sentence->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->sentence->getId());
        self::assertNull($this->sentence->getSentence());
    }

    /**
     * Tests Sentence->setSentence() Sentence->getSentence().
     */
    public function testSetSentence()
    {
        $sentence = new Scene();
        $result = $this->sentence->setSentence($sentence);
        self::assertEquals($result, $this->sentence);
        self::assertEquals($sentence, $this->sentence->getSentence());
    }
}
