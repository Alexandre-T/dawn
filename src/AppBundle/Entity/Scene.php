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

use Application\Sonata\MediaBundle\Entity\Media;
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
     * @ORM\Column(type="boolean", nullable=true, options={"unsigned":true})
     */
    private $initial;

    /**
     * @ORM\Column(type="boolean", nullable=false, name="game_over", options={"default":false})
     */
    private $gameOver = false;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Needed", mappedBy="scene")
     */
    private $needed;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Achievement")
     * @ORM\JoinColumn(name="achievement_id", referencedColumnName="id")
     */
    private $achievement;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false)
     */
    private $media;

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
        $this->needed = new ArrayCollection();
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
            'image' => $this->getMedia()->getProviderMetadata(),
            'game-over' => $this->isGameOver(),
        ];
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
        if (!$this->answers->contains($answer)){
            $this->answers[] = $answer;
            $answer->addScene($this);
        }

        return $this;
    }

    /**
     * Remove answer.
     *
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            $answer->removeScene($this);
        }
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
     * Set gameOver.
     *
     * @param bool $gameOver
     *
     * @return Scene
     */
    public function setGameOver($gameOver)
    {
        $this->gameOver = $gameOver;

        return $this;
    }

    /**
     * Get gameOver.
     *
     * @return bool
     */
    public function isGameOver()
    {
        return $this->getGameOver();
    }

    /**
     * Get gameOver.
     *
     * @return bool
     */
    public function getGameOver()
    {
        return $this->gameOver;
    }

    /**
     * Add needed.
     *
     * @param Needed $needed
     *
     * @return Scene
     */
    public function addNeeded(Needed $needed)
    {
        $this->needed[] = $needed;

        return $this;
    }

    /**
     * Remove needed.
     *
     * @param Needed $needed
     */
    public function removeNeeded(Needed $needed)
    {
        $this->needed->removeElement($needed);
    }

    /**
     * Get needed.
     *
     * @return Collection
     */
    public function getNeeded()
    {
        return $this->needed;
    }

    /**
     * Set media
     *
     * @param Media $media
     *
     * @return Scene
     */
    public function setMedia(Media $media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * To String method for Sonata Admin
     * @return string
     */
    public function __toString()
    {
        return 'Scene ' . $this-> getId() . ' — ' . $this->getDialogue();
    }
}
