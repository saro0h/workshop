<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class MovieList
{
    /**
     * @var int
     */
    private $id;

    /**
     * The list's title
     *
     * @var string
     */
    private $title;

    /**
     * A normalized version of the list's title. Could be used in URIs.
     *
     * @var string
     */
    private $slug;

    /**
     * @var Movie[]|ArrayCollection
     */
    private $movies;

    /**
     * @param string $title
     * @param string $slug
     */
    public function __construct($title, $slug)
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->movies = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Movie $movie
     */
    public function addMovie(Movie $movie)
    {
        $this->movies[$movie->getId()] = $movie;
    }

    /**
     * @return Movie[]
     */
    public function getMovies()
    {
        return $this->movies->toArray();
    }
}
