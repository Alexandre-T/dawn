<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ScoreRepository")
 * @ORM\Table(name="tj_score_sco")
 */
class Score
{
    /**
     * @ORM\Column(type="integer", nullable=false, name="sco_value")
     */
    private $value;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Game", inversedBy="scores")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="gam_uid", nullable=false)
     */
    private $game;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Characteristic", fetch="EAGER")
     * @ORM\JoinColumn(name="characteristic_id", referencedColumnName="cha_id", nullable=false)
     */
    private $characteristic;

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Score
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set game
     *
     * @param Game $game
     *
     * @return Score
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set characteristic
     *
     * @param Characteristic $characteristic
     *
     * @return Score
     */
    public function setCharacteristic(Characteristic $characteristic)
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    /**
     * Get characteristic
     *
     * @return Characteristic
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }
}
