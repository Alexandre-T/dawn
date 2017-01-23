<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\GameRepository")
 * @ORM\Table(name="te_game")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", length=32, name="gam_uid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8, nullable=true, name="gam_ver")
     */
    private $version;

    /**
     * @ORM\Column(type="boolean", nullable=false, name="loc_id", options={"default":false,"unsigned":true})
     */
    private $debug;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Score", mappedBy="game")
     */
    private $scores;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scene")
     * @ORM\JoinColumn(name="scene_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $currentScene;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Achievement")
     * @ORM\JoinTable(
     *     name="tj_achievements",
     *     joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="gam_uid", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="achievement_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $achievement;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scores = new ArrayCollection();
        $this->achievement = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Game
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set debug
     *
     * @param boolean $debug
     *
     * @return Game
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Get debug
     *
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Add score
     *
     * @param Score $score
     *
     * @return Game
     */
    public function addScore(Score $score)
    {
        $this->scores[] = $score;

        return $this;
    }

    /**
     * Remove score
     *
     * @param Score $score
     */
    public function removeScore(Score $score)
    {
        $this->scores->removeElement($score);
    }

    /**
     * Get scores
     *
     * @return Collection
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Set currentScene
     *
     * @param Scene $currentScene
     *
     * @return Game
     */
    public function setCurrentScene(Scene $currentScene)
    {
        $this->currentScene = $currentScene;

        return $this;
    }

    /**
     * Get currentScene
     *
     * @return Scene
     */
    public function getCurrentScene()
    {
        return $this->currentScene;
    }

    /**
     * Add achievement
     *
     * @param Achievement $achievement
     *
     * @return Game
     */
    public function addAchievement(Achievement $achievement)
    {
        $this->achievement[] = $achievement;

        return $this;
    }

    /**
     * Remove achievement
     *
     * @param Achievement $achievement
     */
    public function removeAchievement(Achievement $achievement)
    {
        $this->achievement->removeElement($achievement);
    }

    /**
     * Get achievement
     *
     * @return Collection
     */
    public function getAchievement()
    {
        return $this->achievement;
    }
}
