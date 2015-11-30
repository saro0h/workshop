<?php

namespace Smoovio\Bundle\PortalBundle\Tests\Functional;

use Smoovio\Bundle\PortalBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $this->loadFixtures($client->getKernel());

        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('.movie-title:contains("The Lord of the Rings")')->count());
    }
}
