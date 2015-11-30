<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

class Person
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $biography;

    /** @var string */
    private $homepage;

    /** @var \DateTime */
    private $birthday;

    /** @var \DateTime */
    private $deathday;

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return \DateTime
     */
    public function getDeathday()
    {
        return $this->deathday;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @param string $biography
     * @param string $homepage
     * @param \DateTime $birthday
     * @param \DateTime $deathday
     */
    public function updateInfo($name, $biography, $homepage, $birthday, $deathday = null)
    {
        if (!$birthday instanceof \DateTime) {
            $birthday = new \DateTime($birthday);
        }
        
        if (!$deathday instanceof \DateTime) {
            $deathday = new \DateTime($deathday);
        }

        $this->name = $name;
        $this->biography = $biography;
        $this->homepage = $homepage;
        $this->birthday = $birthday;
        $this->deathday = $deathday;
    }
}
