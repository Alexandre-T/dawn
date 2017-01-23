<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Action extends Answer
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tooltip;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $shape;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $coords;

    /**
     * Set tooltip
     *
     * @param string $tooltip
     *
     * @return Action
     */
    public function setTooltip($tooltip)
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    /**
     * Get tooltip
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Set shape
     *
     * @param string $shape
     *
     * @return Action
     */
    public function setShape($shape)
    {
        $this->shape = $shape;

        return $this;
    }

    /**
     * Get shape
     *
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Set coords
     *
     * @param string $coords
     *
     * @return Action
     */
    public function setCoords($coords)
    {
        $this->coords = $coords;

        return $this;
    }

    /**
     * Get coords
     *
     * @return string
     */
    public function getCoords()
    {
        return $this->coords;
    }
}
