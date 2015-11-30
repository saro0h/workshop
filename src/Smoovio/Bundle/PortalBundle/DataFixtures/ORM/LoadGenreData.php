<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\Genre;

class LoadGenreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fantasy = new Genre('Fantasy', 'fantasy');

        $manager->persist($fantasy);
        $manager->flush();

        $this->addReference('genre.fantasy', $fantasy);
    }

    public function getOrder()
    {
        return 1;
    }
}
