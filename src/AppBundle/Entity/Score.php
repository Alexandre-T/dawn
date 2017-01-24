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
     * Increase by integer Quantity owned.
     *
     * @param int $integer
     *
     * @return $this
     */
    public function increase($integer)
    {
        if (!$this->getCharacteristic() instanceof Characteristic) {
            //add a warning ?
            return $this;
        }
        $integer = (int) $integer;
        $result = $this->getValue() + $integer;
        if (!is_null($this->getCharacteristic()->getMaximum())) {
            $result = min($result, $this->getCharacteristic()->getMaximum());
        }
        if (!is_null($this->getCharacteristic()->getMinimum())) {
            $result = max($result, $this->getCharacteristic()->getMinimum());
        }

        return $this->setValue($result);
    }

    /**
     * Calculate and return score.
     *
     * @return string The value of the score with prefix, suffix and arithmetic transformation
     */
    public function getScore()
    {
        if ($this->getCharacteristic() instanceof Characteristic) {
            $multiply = $this->getCharacteristic()->getMultiply();
            $added = $this->getCharacteristic()->getAdd();
            $prefix = $this->getCharacteristic()->getPrefix();
            $suffix = $this->getCharacteristic()->getSuffix();
            $value = $this->getValue();

            return $prefix.($value * $multiply + $added).$suffix;
        } else {
            return (string) $this->getValue();
        }
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Score
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set game.
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
     * Get game.
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set characteristic.
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
     * Get characteristic.
     *
     * @return Characteristic
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }
}
