<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="te_influence")
 */
class Influence
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     */
    private $bonus;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Answer", inversedBy="influence")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Characteristic")
     * @ORM\JoinColumn(name="characteristic_id", referencedColumnName="cha_id")
     */
    private $characteristic;

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
     * Set bonus.
     *
     * @param int $bonus
     *
     * @return Influence
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus.
     *
     * @return int
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set answer.
     *
     * @param Answer $answer
     *
     * @return Influence
     */
    public function setAnswer(Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer.
     *
     * @return Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set characteristic.
     *
     * @param Characteristic $characteristic
     *
     * @return Influence
     */
    public function setCharacteristic(Characteristic $characteristic = null)
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    /**
     * Get characteristic.
     *
     * @return Characteristic
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }
}
