<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Achievement")
     * @ORM\JoinColumn(name="achievement_id", referencedColumnName="id")
     */
    private $achievement;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Answer")
     * @ORM\JoinTable(
     *     name="Answers",
     *     joinColumns={@ORM\JoinColumn(name="scene_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="answer_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $answers;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dialogue
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
     * Get dialogue
     *
     * @return string
     */
    public function getDialogue()
    {
        return $this->dialogue;
    }

    /**
     * Set image
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
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set achievement
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
     * Get achievement
     *
     * @return Achievement
     */
    public function getAchievement()
    {
        return $this->achievement;
    }

    /**
     * Add answer
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
     * Remove answer
     *
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
