<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

class Genre
{
    /**
     * @var int
     */
    private $id;

    /**
     * The genre's name
     *
     * @var string
     */
    private $title;

    /**
     * A normalized version of the genre's name. Can be used in URIs.
     *
     * @var string
     */
    private $slug;

    /**
     * @param string $title
     * @param string $slug
     */
    public function __construct($title, $slug)
    {
        $this->title = $title;
        $this->slug = $slug;
    }

    public function update(Genre $genre)
    {
        $this->slug = $genre->slug;
        $this->title = $genre->title;
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
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}
