<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Needed
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":1})
     */
    private $value = 1;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scene", inversedBy="needed")
     * @ORM\JoinColumn(name="scene_id", referencedColumnName="id", nullable=false)
     */
    private $scene;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Characteristic")
     * @ORM\JoinColumn(name="characteristic_id", referencedColumnName="cha_id", nullable=false)
     */
    private $characteristic;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scene")
     * @ORM\JoinColumn(name="redirect_id", referencedColumnName="id", nullable=false)
     */
    private $redirectScene;

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
     * Set value.
     *
     * @param int $value
     *
     * @return Needed
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
     * Set scene.
     *
     * @param Scene $scene
     *
     * @return Needed
     */
    public function setScene(Scene $scene)
    {
        $this->scene = $scene;

        return $this;
    }

    /**
     * Get scene.
     *
     * @return Scene
     */
    public function getScene()
    {
        return $this->scene;
    }

    /**
     * Set characteristic.
     *
     * @param Characteristic $characteristic
     *
     * @return Needed
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

    /**
     * Set redirectScene.
     *
     * @param Scene $redirectScene
     *
     * @return Needed
     */
    public function setRedirectScene(Scene $redirectScene)
    {
        $this->redirectScene = $redirectScene;

        return $this;
    }

    /**
     * Get redirectScene.
     *
     * @return Scene
     */
    public function getRedirectScene()
    {
        return $this->redirectScene;
    }
}
