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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="te_action")
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
     * @return string
     */
    public function getCode(){
        return "Action {$this->getId()} - {$this->getTooltip()}";
    }

    /**
     * Set tooltip.
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
     * Get tooltip.
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Set shape.
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
     * Get shape.
     *
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Set coords.
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
     * Get coords.
     *
     * @return string
     */
    public function getCoords()
    {
        return $this->coords;
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
            'coords' => $this->getCoords(),
            'shape' => $this->getShape(),
            'tooltip' => $this->getTooltip(),
        ];
    }
}
