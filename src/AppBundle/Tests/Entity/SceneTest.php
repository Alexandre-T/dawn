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
use AppBundle\Entity\Answer;
use AppBundle\Entity\Scene;
use AppBundle\Entity\Sentence;

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
        self::assertEmpty($this->scene->getAnswers());
        self::assertNull($this->scene->getDialogue());
        self::assertNull($this->scene->getImage());
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
        $answer1 = new Answer();
        $answer2 = new Answer();
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
     * Tests Scene->setImage() Scene->getImage().
     */
    public function testSetImage()
    {
        $image = 'foo';
        $result = $this->scene->setImage($image);
        self::assertEquals($result, $this->scene);
        self::assertEquals($image, $this->scene->getImage());
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
