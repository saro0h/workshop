<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

class Role
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $character;

    /** @var Movie */
    private $movie;

    /**
     * @var Actor
     */
    private $actor;

    /**
     * @param Movie $movie
     * @param Actor $actor
     * @param string $character
     */
    public function __construct(Movie $movie, Actor $actor, $character)
    {
        $this->movie = $movie;
        $this->actor = $actor;
        $this->character = $character;
    }

    /**
     * @return Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @return string
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
