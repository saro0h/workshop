<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Movie
{
    /**
     * @var int
     */
    private $id;

    /**
     * The movie's title. (Original version)
     *
     * @var string
     */
    private $title;

    /**
     * A slug of the movie's title.
     *
     * @var string
     */
    private $slug;

    /**
     * A short description of the movie's plot.
     *
     * @var string
     */
    private $description;

    /**
     * The movie's genre
     *
     * @var Genre
     */
    private $genre;

    /**
     * The movie's duration in seconds.
     *
     * @var int
     */
    private $duration;

    /**
     * The date the movie has been released first.
     *
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * An internal key to find the movie in storage.
     *
     * @var string
     */
    private $storageKey;

    /**
     * @var Role[]
     */
    private $roles;

    /**
     * @var Director[]
     */
    private $directors;

    public function __construct()
    {
        $this->directors = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setReleaseDate($releaseDate)
    {
        if (!$releaseDate instanceof \DateTime) {
            $releaseDate = new \DateTime($releaseDate);
        }

        $this->releaseDate = $releaseDate;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function hasRoles()
    {
        return count($this->roles) > 0;
    }

    /**
     * @return Director[]
     */
    public function getDirectors()
    {
        return $this->directors->toArray();
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $title
     * @param string $slug
     * @param string $description
     * @param int $duration
     * @param \DateTime $releaseDate
     */
    public function updateMovieInfo($title, $slug, $description, $duration, $releaseDate)
    {
        if (!$releaseDate instanceof \DateTime) {
            $releaseDate = new \DateTime($releaseDate);
        }

        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->duration = $duration;
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param Genre $genre
     */
    public function updateGenre(Genre $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @param Director $director
     */
    public function addDirector(Director $director)
    {
        if (!$this->directors->contains($director)) {
            $this->directors->add($director);
            $director->addMovie($this);
        }
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}
