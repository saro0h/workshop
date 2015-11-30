<?php

namespace Smoovio\Bundle\CoreBundle\Repository;

use Smoovio\Bundle\CoreBundle\Entity\Movie;

class MovieRepository extends AbstractRepository
{
    public function getMovies()
    {
        return $this->findBy([], [ 'title' => 'asc' ]);
    }

    public function getMovie($id)
    {
        $q = $this
            ->createQueryBuilder('m')
            ->select('m, g, r, a')
            ->leftJoin('m.roles', 'r')
            ->leftJoin('m.genre', 'g')
            ->leftJoin('r.actor', 'a')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        return $q->getOneOrNullResult();
    }

    /**
     * @param string $term
     * @param string $order
     *
     * @return \Traversable
     */
    public function search($term, $order = 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('m')
            ->select('m')
            ->orderBy('m.title', $order)
        ;

        if ($term) {
            $qb
                ->where('m.title LIKE ?1')
                ->setParameter(1, '%' . $term . '%')
            ;
        }

        //return $this->paginate($qb, $limit, $offset);
        return $qb->getQuery()->execute();
    }

    /**
     * @param string $slug
     *
     * @return null|Movie
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * @param int[]|string[] $ids
     *
     * @return Movie[]
     */
    public function findByIds(array $ids)
    {
        return $this->createQueryBuilder('m')
            ->where('m.id IN :ids')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}
