<?php

namespace Smoovio\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GenreRepository extends EntityRepository
{
    /**
     * Returns all genres ordered by title ascendant.
     *
     * @return \Smoovio\Bundle\CoreBundle\Entity\Genre[]
     */
    public function getGenres()
    {
        return $this->findBy([], [ 'title' => 'ASC' ]);
    }
} 
