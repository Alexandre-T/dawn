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
use AppBundle\Entity\Action;
use AppBundle\Entity\Needed;
use AppBundle\Entity\Scene;
use AppBundle\Entity\Sentence;
use Application\Sonata\MediaBundle\Entity\Media;

/**
 * Scene Entity test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class SceneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Scene
     */
    private $scene;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->scene = new Scene();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->scene = null;
        parent::tearDown();
    }

    /**
     * Tests Scene->__construct().
     */
    public function testConstruct()
    {
        self::assertNull($this->scene->getId());
        self::assertNull($this->scene->getAchievement());
        self::assertNotNull($this->scene->getAnswers());
        self::assertNotNull($this->scene->getNeeded());
        self::assertEmpty($this->scene->getAnswers());
        self::assertNull($this->scene->getDialogue());
        self::assertFalse($this->scene->getGameOver());
        self::assertFalse($this->scene->isGameOver());
        self::assertNull($this->scene->getMedia());
        self::assertNull($this->scene->getInitial());
    }

    /**
     * Tests Scene->setAchievement() Scene->getAchievement().
     */
    public function testSetAchievement()
    {
        $achievement = new Achievement();
        $result = $this->scene->setAchievement($achievement);
        self::assertEquals($result, $this->scene);
        self::assertEquals($achievement, $this->scene->getAchievement());
    }

    /**
     * Tests Scene get add removeAnswer ().
     */
    public function testAnswers()
    {
        $answer1 = new Action();
        $answer2 = new Sentence();
        $this->scene->addAnswer($answer1);
        self::assertCount(1, $this->scene->getAnswers());
        self::assertTrue($this->scene->getAnswers()->contains($answer1));
        self::assertFalse($this->scene->getAnswers()->contains($answer2));
        $this->scene->addAnswer($answer2);
        self::assertCount(2, $this->scene->getAnswers());
        self::assertTrue($this->scene->getAnswers()->contains($answer1));
        self::assertTrue($this->scene->getAnswers()->contains($answer2));
        $this->scene->removeAnswer($answer1);
        self::assertCount(1, $this->scene->getAnswers());
        self::assertFalse($this->scene->getAnswers()->contains($answer1));
        self::assertTrue($this->scene->getAnswers()->contains($answer2));
        $this->scene->removeAnswer($answer2);
        self::assertCount(0, $this->scene->getAnswers());
        self::assertFalse($this->scene->getAnswers()->contains($answer1));
        self::assertFalse($this->scene->getAnswers()->contains($answer2));
    }

    /**
     * Tests Scene get add removeAnswer ().
     */
    public function testNeeded()
    {
        $needed1 = new Needed();
        $needed2 = new Needed();
        $this->scene->addNeeded($needed1);
        self::assertCount(1, $this->scene->getNeeded());
        self::assertTrue($this->scene->getNeeded()->contains($needed1));
        self::assertFalse($this->scene->getNeeded()->contains($needed2));
        $this->scene->addNeeded($needed2);
        self::assertCount(2, $this->scene->getNeeded());
        self::assertTrue($this->scene->getNeeded()->contains($needed1));
        self::assertTrue($this->scene->getNeeded()->contains($needed2));
        $this->scene->removeNeeded($needed1);
        self::assertCount(1, $this->scene->getNeeded());
        self::assertFalse($this->scene->getNeeded()->contains($needed1));
        self::assertTrue($this->scene->getNeeded()->contains($needed2));
        $this->scene->removeNeeded($needed2);
        self::assertCount(0, $this->scene->getNeeded());
        self::assertFalse($this->scene->getNeeded()->contains($needed1));
        self::assertFalse($this->scene->getNeeded()->contains($needed2));
    }

    /**
     * Tests Scene get add removeAction ().
     */
    public function testActions()
    {
        $action1 = new Action();
        $action2 = new Action();
        $this->scene->addAction($action1);
        self::assertCount(1, $this->scene->getActions());
        self::assertTrue($this->scene->getActions()->contains($action1));
        self::assertFalse($this->scene->getActions()->contains($action2));
        self::assertTrue($this->scene->getAnswers()->contains($action1));
        self::assertFalse($this->scene->getAnswers()->contains($action2));
        $this->scene->addAction($action2);
        self::assertCount(2, $this->scene->getActions());
        self::assertTrue($this->scene->getActions()->contains($action1));
        self::assertTrue($this->scene->getActions()->contains($action2));
        self::assertTrue($this->scene->getAnswers()->contains($action1));
        self::assertTrue($this->scene->getAnswers()->contains($action2));
        $this->scene->removeAction($action1);
        self::assertCount(1, $this->scene->getActions());
        self::assertFalse($this->scene->getActions()->contains($action1));
        self::assertTrue($this->scene->getActions()->contains($action2));
        self::assertFalse($this->scene->getAnswers()->contains($action1));
        self::assertTrue($this->scene->getAnswers()->contains($action2));
        $this->scene->removeAction($action2);
        self::assertCount(0, $this->scene->getActions());
        self::assertFalse($this->scene->getActions()->contains($action1));
        self::assertFalse($this->scene->getActions()->contains($action2));
        self::assertFalse($this->scene->getAnswers()->contains($action1));
        self::assertFalse($this->scene->getAnswers()->contains($action2));
    }

    /**
     * Tests Scene get add removeSentence ().
     */
    public function testSentences()
    {
        $sentence1 = new Sentence();
        $sentence2 = new Sentence();
        $this->scene->addSentence($sentence1);
        self::assertCount(1, $this->scene->getSentences());
        self::assertTrue($this->scene->getSentences()->contains($sentence1));
        self::assertFalse($this->scene->getSentences()->contains($sentence2));
        self::assertTrue($this->scene->getAnswers()->contains($sentence1));
        self::assertFalse($this->scene->getAnswers()->contains($sentence2));

        $this->scene->addSentence($sentence2);
        self::assertCount(2, $this->scene->getSentences());
        self::assertTrue($this->scene->getSentences()->contains($sentence1));
        self::assertTrue($this->scene->getSentences()->contains($sentence2));
        self::assertTrue($this->scene->getAnswers()->contains($sentence1));
        self::assertTrue($this->scene->getAnswers()->contains($sentence2));

        $this->scene->removeSentence($sentence1);
        self::assertCount(1, $this->scene->getSentences());
        self::assertFalse($this->scene->getSentences()->contains($sentence1));
        self::assertTrue($this->scene->getSentences()->contains($sentence2));
        self::assertFalse($this->scene->getAnswers()->contains($sentence1));
        self::assertTrue($this->scene->getAnswers()->contains($sentence2));
        $this->scene->removeSentence($sentence2);
        self::assertCount(0, $this->scene->getSentences());
        self::assertFalse($this->scene->getSentences()->contains($sentence1));
        self::assertFalse($this->scene->getSentences()->contains($sentence2));
        self::assertFalse($this->scene->getAnswers()->contains($sentence1));
        self::assertFalse($this->scene->getAnswers()->contains($sentence2));
    }

    /**
     * Tests Scene->setDialogue() Scene->getDialogue().
     */
    public function testSetDialogue()
    {
        $dialogue = 'foo';
        $result = $this->scene->setDialogue($dialogue);
        self::assertEquals($result, $this->scene);
        self::assertEquals($dialogue, $this->scene->getDialogue());
    }

    /**
     * Tests Scene->setGameOver() Scene->getGameOver() Scene->isGameOver().
     */
    public function testSetGameOver()
    {
        $gameOver = true;
        $result = $this->scene->setGameOver($gameOver);
        self::assertEquals($result, $this->scene);
        self::assertTrue($this->scene->getGameOver());
        self::assertTrue($this->scene->isGameOver());
    }

    /**
     * Tests Scene->setMedia() Scene->getMedia().
     */
    public function testSetMedia()
    {
        $media = new Media();
        $result = $this->scene->setMedia($media);
        self::assertEquals($result, $this->scene);
        self::assertEquals($media, $this->scene->getMedia());
    }

    /**
     * Tests Scene->setInitial() Scene->getInitial().
     */
    public function testSetInitial()
    {
        $initial = true;
        $result = $this->scene->setInitial($initial);
        self::assertEquals($result, $this->scene);
        self::assertTrue($this->scene->getInitial());
    }
}
