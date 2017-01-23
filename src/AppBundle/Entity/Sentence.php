<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="te_sentence")
 */
class Sentence extends Answer
{
    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $sentence;

    /**
     * Set sentence
     *
     * @param string $sentence
     *
     * @return Sentence
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }
}
