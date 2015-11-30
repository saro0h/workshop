<?php

namespace Smoovio\Bundle\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\Entity\Director;

class LoadDirectorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $peter = new Director();
        $peter->updateInfo('Peter Jackson', null, null, null, null);
        $manager->persist($peter);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
