<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lotr = $this->getReference('movie.lotr');
        $elijah = $this->getReference('actor.elijah');

        $frodo = new Role($lotr, $elijah, 'Frodo');

        $manager->persist($frodo);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
