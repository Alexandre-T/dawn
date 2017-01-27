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

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SceneRepository")
 * @ORM\Table(name="te_scene")
 */
class Scene
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dialogue;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"unsigned":true})
     */
    private $initial;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Achievement")
     * @ORM\JoinColumn(name="achievement_id", referencedColumnName="id")
     */
    private $achievement;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Answer", inversedBy="scenes")
     * @ORM\JoinTable(
     *     name="tj_answers",
     *     joinColumns={@ORM\JoinColumn(name="scene_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="answer_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $answers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * Add action.
     *
     * @param Action $action
     *
     * @return Scene
     */
    public function addAction(Action $action)
    {
        return $this->addAnswer($action);
    }

    /**
     * Remove action.
     *
     * @param Action $action
     */
    public function removeAction(Action $action)
    {
        $this->removeAnswer($action);
    }

    /**
     * Get actions.
     *
     * @return Collection
     */
    public function getActions()
    {
        $actions = new ArrayCollection();
        foreach ($this->answers as $answer) {
            if ($answer instanceof Action) {
                $actions[] = $answer;
            }
        }

        return $actions;
    }

    /**
     * Add sentence.
     *
     * @param Sentence $sentence
     *
     * @return Scene
     */
    public function addSentence(Sentence $sentence)
    {
        return $this->addAnswer($sentence);
    }

    /**
     * Remove sentence.
     *
     * @param Sentence $sentence
     */
    public function removeSentence(Sentence $sentence)
    {
        $this->removeAnswer($sentence);
    }

    /**
     * Get sentences.
     *
     * @return Collection
     */
    public function getSentences()
    {
        $sentences = new ArrayCollection();
        foreach ($this->answers as $answer) {
            if ($answer instanceof Sentence) {
                $sentences[] = $answer;
            }
        }

        return $sentences;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dialogue.
     *
     * @param string $dialogue
     *
     * @return Scene
     */
    public function setDialogue($dialogue)
    {
        $this->dialogue = $dialogue;

        return $this;
    }

    /**
     * Get dialogue.
     *
     * @return string
     */
    public function getDialogue()
    {
        return $this->dialogue;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Scene
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set achievement.
     *
     * @param Achievement $achievement
     *
     * @return Scene
     */
    public function setAchievement(Achievement $achievement = null)
    {
        $this->achievement = $achievement;

        return $this;
    }

    /**
     * Get achievement.
     *
     * @return Achievement
     */
    public function getAchievement()
    {
        return $this->achievement;
    }

    /**
     * Add answer.
     *
     * @param Answer $answer
     *
     * @return Scene
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer.
     *
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers.
     *
     * @return Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set initial.
     *
     * @param bool $initial
     *
     * @return Scene
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;

        return $this;
    }

    /**
     * Get initial.
     *
     * @return bool
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Return array of non-object properties.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'dialogue' => $this->getDialogue(),
            'image' => $this->getImage(),
        ];
    }
}
