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
 * @ORM\Entity
 * @ORM\Table(name="te_answer")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Influence", mappedBy="answer", fetch="EAGER")
     */
    private $influences;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scene")
     * @ORM\JoinColumn(name="scene_id", referencedColumnName="id", nullable=false)
     */
    private $destination;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Scene", mappedBy="answers", cascade={"all"})
     */
    private $scenes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->influences = new ArrayCollection();
        $this->scenes = new ArrayCollection();
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
     * Add influence.
     *
     * @param Influence $influence
     *
     * @return Answer
     */
    public function addInfluence(Influence $influence)
    {
        $this->influences[] = $influence;

        return $this;
    }

    /**
     * Remove influence.
     *
     * @param Influence $influence
     */
    public function removeInfluence(Influence $influence)
    {
        $this->influences->removeElement($influence);
    }

    /**
     * Get influence.
     *
     * @return Collection
     */
    public function getInfluences()
    {
        return $this->influences;
    }

    /**
     * Set destination.
     *
     * @param Scene $destination
     *
     * @return Answer
     */
    public function setDestination(Scene $destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return Scene
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Add scene.
     *
     * @param scene $scene
     *
     * @return Answer
     */
    public function addScene(scene $scene)
    {
        if (!$this->scenes->contains($scene)) {
            $this->scenes[] = $scene;
            $scene->addAnswer($this);
        }

        return $this;
    }

    /**
     * Remove scene.
     *
     * @param scene $scene
     */
    public function removeScene(scene $scene)
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            $scene->removeAnswer($this);
        }
    }

    /**
     * Get scenes.
     *
     * @return Collection
     */
    public function getScenes()
    {
        return $this->scenes;
    }
}
