<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="te_achievement")
 */
class Achievement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=128, nullable=false)
     */
    private $alternat;

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
     * Set title
     *
     * @param string $title
     *
     * @return Achievement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Achievement
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
     * Set alternat
     *
     * @param string $alternat
     *
     * @return Achievement
     */
    public function setAlternat($alternat)
    {
        $this->alternat = $alternat;

        return $this;
    }

    /**
     * Get alternat
     *
     * @return string
     */
    public function getAlternat()
    {
        return $this->alternat;
    }
}
