<?php

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
     * Constructor.
     */
    public function __construct()
    {
        $this->influences = new ArrayCollection();
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
}
