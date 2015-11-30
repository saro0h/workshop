<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\Movie;

class LoadMovieData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lotr = new Movie();
        $lotr->updateMovieInfo('The Lord of the Rings', 'lotr', '...', 42, new \DateTime());
        $lotr->updateGenre($this->getReference('genre.fantasy'));

        $manager->persist($lotr);
        $manager->flush();

        $this->addReference('movie.lotr', $lotr);
    }

    public function getOrder()
    {
        return 2;
    }
}
