<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Director extends Person
{
    /**
     * @var ArrayCollection
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    /**
     * @param Movie $m
     */
    public function addMovie(Movie $m)
    {
        if (!$this->movies->contains($m)) {
            $this->movies->add($m);
            $m->addDirector($this);
        }
    }

    /**
     * @return array
     */
    public function getMovies()
    {
        return $this->movies->toArray();
    }
}