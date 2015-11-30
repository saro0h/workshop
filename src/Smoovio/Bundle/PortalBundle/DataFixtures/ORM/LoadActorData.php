<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\Actor;

class LoadActorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $elijah = new Actor();
        $elijah->updateInfo('Elijah Wood', null, null, null, null);

        $manager->persist($elijah);
        $manager->flush();

        $this->addReference('actor.elijah', $elijah);
    }

    public function getOrder()
    {
        return 1;
    }
}
