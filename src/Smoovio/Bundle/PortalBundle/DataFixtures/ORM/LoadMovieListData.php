<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\MovieList;

class LoadMovieListData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lotr = $this->getReference('movie.lotr');

        $movies = new MovieList('Portal', 'portal');
        $movies->addMovie($lotr);

        $manager->persist($movies);
        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
    }
}
