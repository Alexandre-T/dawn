<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CharacteristicRepository")
 * @ORM\Table(name="te_characteristics_cha")
 */
class Characteristic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="cha_id", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16, nullable=false, name="cha_code")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=16, nullable=false, name="cha_name")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false, name="cha_initial", options={"default":0})
     */
    private $initial = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, name="cha_minimum", options={"default":0})
     */
    private $minimum = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, name="cha_maximum", options={"default":100})
     */
    private $maximum = 100;

    /**
     * @ORM\Column(type="integer", nullable=true, name="cha_sort")
     */
    private $sort;

    /**
     * @ORM\Column(type="string", length=8, nullable=false, name="cha_prefix")
     */
    private $prefix;

    /**
     * @ORM\Column(type="string", nullable=false, name="cha_suffix")
     */
    private $suffix;

    /**
     * @ORM\Column(type="integer", nullable=false, name="cha_multiply", options={"default":1})
     */
    private $multiply = 1;

    /**
     * @ORM\Column(type="integer", nullable=false, name="cha_add", options={"default":0})
     */
    private $add = 0;

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
     * Set code
     *
     * @param string $code
     *
     * @return Characteristic
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Characteristic
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set initial
     *
     * @param integer $initial
     *
     * @return Characteristic
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;

        return $this;
    }

    /**
     * Get initial
     *
     * @return integer
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Set minimum
     *
     * @param integer $minimum
     *
     * @return Characteristic
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * Get minimum
     *
     * @return integer
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * Set maximum
     *
     * @param integer $maximum
     *
     * @return Characteristic
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    /**
     * Get maximum
     *
     * @return integer
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Characteristic
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     *
     * @return Characteristic
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param string $suffix
     *
     * @return Characteristic
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set multiply
     *
     * @param integer $multiply
     *
     * @return Characteristic
     */
    public function setMultiply($multiply)
    {
        $this->multiply = $multiply;

        return $this;
    }

    /**
     * Get multiply
     *
     * @return integer
     */
    public function getMultiply()
    {
        return $this->multiply;
    }

    /**
     * Set add
     *
     * @param integer $add
     *
     * @return Characteristic
     */
    public function setAdd($add)
    {
        $this->add = $add;

        return $this;
    }

    /**
     * Get add
     *
     * @return integer
     */
    public function getAdd()
    {
        return $this->add;
    }
}
