<?php

namespace Smoovio\Bundle\PortalBundle\Tests\Functional;

use Smoovio\Bundle\PortalBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testProfile()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/profile');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }
}
